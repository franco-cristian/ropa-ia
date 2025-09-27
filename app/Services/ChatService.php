<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\DocumentChunk;
use Pgvector\Laravel\Vector;
use Exception;
use Pgvector\Laravel\Distance;

class ChatService
{
    private const EMBEDDING_API_URL = 'https://api-inference.huggingface.co/models/BAAI/bge-base-en-v1.5';
    private const GENERATION_API_URL = 'https://api.groq.com/openai/v1/chat/completions';
    private const GENERATION_MODEL = 'llama-3.1-8b-instant';

    private string $hfApiToken;
    private string $groqApiToken;
    private array $conversationHistory;

    public function __construct()
    {
        $this->hfApiToken = config('app.hugging_face_token');
        $this->groqApiToken = config('app.groq_api_key');
    }

    public function getSmartResponse(string $question, array $history = []): string
    {
        $this->conversationHistory = $history;
        try {
            // --- PASO 1: ROUTER ---
            $intent = $this->getIntent($question);

            switch ($intent) {
                case 'RAG':
                    $context = $this->getContextFromDocuments($question);
                    if (empty($context)) return "No he encontrado información específica sobre tu pregunta en mis documentos.";
                    return $this->synthesizeResponse($question, $context);

                case 'NL2SQL':
                    $entities = $this->extractEntities($question);
                    $sqlQueryBuilder = $this->buildSqlQuery($entities);
                    
                    if (is_null($sqlQueryBuilder)) {
                        return "Lo siento, no he entendido bien tu pregunta. ¿Puedes ser más específico?";
                    }
                    
                    $queryResults = $sqlQueryBuilder->get();
                    
                    if ($queryResults->isEmpty()) {
                        return "Lo siento, no he encontrado productos o información que coincida con tu búsqueda.";
                    }
                    $context = $queryResults->toJson();
                    return $this->synthesizeResponse($question, $context);
                
                case 'OFF_TOPIC':
                    return "Lo siento, solo puedo responder preguntas sobre nuestros productos y políticas de la tienda.";
                
                default:
                    return "No estoy seguro de cómo ayudarte con eso. Intenta reformular tu pregunta.";
            }
        } catch (Exception $e) {
            return "Ocurrió un error inesperado. Por favor, inténtalo de nuevo. [DEBUG: " . $e->getMessage() . "]";
        }
    }

    private function getIntent(string $question): string
    {
        // El prompt del Router
        $conversationContext = implode("\n", array_map(fn($msg) => $msg['source'] . ': ' . $msg['content'], $this->conversationHistory));
        $prompt = <<<PROMPT
        [INST] Tu única tarea es clasificar la pregunta del usuario (`user`) en una de tres categorías: `RAG`, `NL2SQL`, o `OFF_TOPIC`. Responde únicamente con la palabra de la categoría.

        - `RAG`: Preguntas sobre políticas de la tienda (envío, devoluciones, pago, cuidado de ropa, tiempos de entrega).
        - `NL2SQL`: Preguntas sobre productos, stock, precios, descripciones o recomendaciones basadas en el clima.
        - `OFF_TOPIC`: Preguntas no relacionadas con la tienda.

        REGLA DE ORO: Si una pregunta es sobre "tiempos de entrega" o "costos de envío", SIEMPRE es `RAG`.

        <ejemplos>
        Pregunta: "cuanto tarda en llegar mi campera a formosa?" -> Respuesta: RAG
        Pregunta: "cuanto cuesta el Buzo de Friza Invisible?" -> Respuesta: NL2SQL
        Pregunta: "qué me recomiendas para el sabado en formosa?" -> Respuesta: NL2SQL
        Pregunta: "quien gano el mundial de 1986?" -> Respuesta: OFF_TOPIC
        </ejemplos>
        
        Historial de Conversación:
        {$conversationContext}

        Pregunta Actual: "{$question}"
        Respuesta:
        [/INST]
        PROMPT;

        $response = $this->callGenerationApi($prompt, 10);
        $intent = trim(strtoupper($response));
        return in_array($intent, ['RAG', 'NL2SQL', 'OFF_TOPIC']) ? $intent : 'UNKNOWN';
    }

    private function extractEntities(string $question): array
    {
        $prompt = <<<PROMPT
        [INST] Tu tarea es extraer entidades de la pregunta de un cliente y devolverlas como un JSON.
        Entidades posibles: `product_name` (string), `product_type` (string), `gender` (string), `location` (string), `attribute` (string), `weather_event` (string).
        Si una pregunta tiene varios productos, devuelve un array de nombres en `product_names`.
        Si no hay entidades, devuelve un JSON vacío. Responde solo con el JSON.

        <ejemplos>
        Pregunta: "cuanto cuesta el Buzo de Friza Invisible?" -> Respuesta: {"product_name": "Buzo de Friza Invisible"}
        Pregunta: "que camisas de mujer tienes en stock?" -> Respuesta: {"product_type": "camisa", "gender": "mujer"}
        Pregunta: "que me recomiendas para el viernes en formosa si va a llover? soy varón" -> Respuesta: {"location": "Formosa", "weather_event": "lluvia", "gender": "hombre"}
        Pregunta: "el viernes estará fresco en formosa?" -> Respuesta: {"location": "Formosa", "attribute": "clima"}
        Pregunta: "cuanto cuesta el Buzo de Friza Invisible? y la Camisa Casual Hombre?" -> Respuesta: {"product_names": ["Buzo de Friza Invisible", "Camisa Casual Hombre"]}
        </ejemplos>

        Pregunta: "{$question}"
        Respuesta:
        [/INST]
        PROMPT;

        $response = $this->callGenerationApi($prompt, 200);
        return json_decode($response, true) ?? [];
    }

    /**
     * CONSTRUCTOR DE QUERIES: Devuelve un objeto Query Builder.
     */
    private function buildSqlQuery(array $entities): ?Builder
    {
        if (empty($entities)) {
            // Manejo de consultas generales como "¿qué puedo comprar?"
            return DB::table('products as p')->select('p.name', 'p.price', 'p.stock', 'p.long_description')->where('p.stock', '>', 0)->inRandomOrder()->limit(5);
        }

        if (isset($entities['attribute']) && $entities['attribute'] === 'clima' && isset($entities['location'])) {
            return DB::table('climates')->select('weather_data')->where('city', 'ILIKE', '%' . $entities['location'] . '%')->where('date', '>=', now()->toDateString())->limit(1);
        }

        $query = DB::table('products as p');

        // Lógica de Selección de Campos
        if (isset($entities['product_names']) && is_array($entities['product_names'])) {
            $query->select('name', 'price', 'stock', 'long_description')
                  ->where(function ($q) use ($entities) {
                      foreach ($entities['product_names'] as $name) {
                          $q->orWhere('name', 'ILIKE', '%' . trim($name) . '%');
                      }
                  });
            // Para preguntas de múltiples productos, no filtramos por stock
        } elseif (isset($entities['product_name'])) {
            $query->select('name', 'price', 'stock', 'long_description')->where('name', 'ILIKE', '%' . $entities['product_name'] . '%');
            // Para un producto específico, no filtramos por stock para poder decir si está agotado
        } else {
            // Para recomendaciones y búsquedas genéricas
            $query->select('p.name', 'p.price', 'p.stock', 'p.long_description')->where('p.stock', '>', 0);
        }

        // Lógica de Filtrado
        if (isset($entities['product_type'])) {
            $query->where('p.name', 'ILIKE', '%' . $entities['product_type'] . '%');
        }

        if (isset($entities['gender'])) {
            $query->where('p.name', 'ILIKE', '%' . $entities['gender'] . '%');
        }
        
        if (isset($entities['location']) || isset($entities['weather_event'])) {
            $location = $entities['location'] ?? 'Formosa'; // Default
            
            $query->join('climates as c', function ($join) use ($location) {
                $join->on(DB::raw('1'), '=', DB::raw('1'))
                     ->where('c.city', 'ILIKE', '%' . $location . '%');
            })->where('c.date', '>=', now()->toDateString());

            if (isset($entities['weather_event'])) {
                if ($entities['weather_event'] === 'lluvia') {
                    $query->whereRaw("CAST(jsonb_path_query_first(c.weather_data, '$.hourly.precipitation[0]') AS numeric) > 0.1");
                } elseif ($entities['weather_event'] === 'calor') {
                    $query->whereRaw("CAST(jsonb_path_query_first(c.weather_data, '$.hourly.temperature_2m[0]') AS numeric) > 25");
                } elseif ($entities['weather_event'] === 'frío' || $entities['weather_event'] === 'fresco') {
                    $query->whereRaw("CAST(jsonb_path_query_first(c.weather_data, '$.hourly.temperature_2m[0]') AS numeric) < 15");
                }
            }
        }
        
        return $query->limit(5);
    }

    private function synthesizeResponse(string $question, string $context): string
    {
        // sintetizador
        $conversationContext = implode("\n", array_map(fn($msg) => $msg['source'] . ': ' . $msg['content'], $this->conversationHistory));
        $prompt = <<<PROMPT
        [INST] Eres un asistente de chat amigable para la tienda 'Ropa IA'. Tu tarea es tomar los DATOS TÉCNICOS del contexto y el HISTORIAL DE CONVERSACIÓN para dar una respuesta natural y útil al cliente.

        REGLAS:
        - Habla directamente al cliente. NUNCA uses prefijos como "Respuesta:".
        - Si los DATOS son un JSON de productos, preséntalos en una lista clara. Formatea los precios. Usa la `long_description` si está disponible. Si un producto tiene `stock: 0`, menciónalo.
        - Si los DATOS son un JSON de clima, resume el pronóstico de forma sencilla.
        - NUNCA menciones "JSON" o "base de datos".

        HISTORIAL DE CONVERSACIÓN:
        {$conversationContext}
        
        DATOS TÉCNICOS (Contexto):
        {$context}

        PREGUNTA ORIGINAL DEL CLIENTE:
        "{$question}"

        Tu respuesta final y amigable para el cliente:
        [/INST]
        PROMPT;
        return $this->callGenerationApi($prompt, 500);
    }
    
    // --- MÉTODOS AYUDANTES (CON LÓGICA DE REINTENTO) ---
    private function getContextFromDocuments(string $question): string
    {
        $response = Http::withToken($this->hfApiToken)->timeout(60)->post(self::EMBEDDING_API_URL, ['inputs' => $question]);
        if ($response->failed()) return '';
        $questionEmbedding = $response->json();
        $relevantChunks = DocumentChunk::query()->nearestNeighbors('embedding', new Vector($questionEmbedding), Distance::Cosine)->take(4)->get();
        return $relevantChunks->isEmpty() ? '' : $relevantChunks->pluck('content')->implode("\n\n---\n\n");
    }

    private function callGenerationApi(string $prompt, int $maxTokens = 1024): string
    {
        $retries = 3;
        $delay = 1; // Start with 1 second delay

        while ($retries > 0) {
            $response = Http::withToken($this->groqApiToken)
                ->timeout(30)
                ->post(self::GENERATION_API_URL, [
                    'model' => self::GENERATION_MODEL,
                    'messages' => [['role' => 'user', 'content' => $prompt]],
                    'temperature' => 0.2,
                    'max_tokens' => $maxTokens,
                ]);

            if ($response->successful()) {
                return trim($response->json()['choices'][0]['message']['content'] ?? "");
            }

            $errorBody = $response->json();
            if (isset($errorBody['error']['code']) && $errorBody['error']['code'] === 'rate_limit_exceeded') {
                preg_match('/Please try again in ([\d\.]+)s\./', $errorBody['error']['message'], $matches);
                $wait = isset($matches[1]) ? ceil((float)$matches[1]) : $delay;
                sleep($wait);
                $delay *= 2;
            } else {
                throw new Exception("La llamada a la API de Groq falló. Respuesta: " . $response->body());
            }

            $retries--;
        }

        throw new Exception("Se alcanzó el límite de reintentos por rate limit en la API de Groq.");
    }
}