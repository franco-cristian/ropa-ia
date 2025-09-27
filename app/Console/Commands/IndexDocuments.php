<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use App\Models\DocumentChunk;
use Smalot\PdfParser\Parser;
use thiagoalessio\TesseractOCR\TesseractOCR;

class IndexDocuments extends Command
{
    protected $signature = 'docs:index';
    protected $description = 'Lee docs, genera embeddings con un modelo robusto (BGE) y los guarda.';
    
    /**
     * BAAI/bge-base-en-v1.5 es un estándar de la industria para RAG.
     */
    private const EMBEDDING_API_URL = 'https://api-inference.huggingface.co/models/BAAI/bge-base-en-v1.5';

    public function handle(Parser $pdfParser): int
    {
        $this->info('🚀 Iniciando indexación con el modelo BGE (Modo a Prueba de Fallos)...');

        $apiToken = config('app.hugging_face_token');
        if (empty($apiToken)) {
            $this->error('CRÍTICO: La API Key de Hugging Face no está configurada.');
            return self::FAILURE;
        }

        $path = storage_path('app/documents');
        if (!File::exists($path) || empty($files = File::allFiles($path))) {
            $this->warn('No se encontraron archivos en storage/app/documents. Nada que hacer.');
            return self::SUCCESS;
        }

        $this->info('1/3 - Pre-procesando archivos y dividiendo en chunks...');
        $allChunks = [];
        // pre-procesamiento
        foreach ($files as $file) {
            $source = $file->getFilename();
            $content = '';
            if (strtolower($file->getExtension()) === 'pdf') {
                try {
                    $pdf = $pdfParser->parseFile($file->getPathname());
                    $content = trim($pdf->getText());
                    if (empty($content)) {
                        $content = (new TesseractOCR($file->getPathname()))->lang('spa', 'eng')->run();
                    }
                } catch (\Exception $e) { continue; }
            } else {
                $content = File::get($file->getPathname());
            }
            $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
            $chunks = array_filter(array_map('trim', preg_split('/(\r\n|\n){2,}/', $content)));
            foreach ($chunks as $chunk) {
                $allChunks[] = ['source' => $source, 'content' => $chunk];
            }
        }
        
        if (empty($allChunks)) {
            $this->error('No se pudieron extraer chunks de los documentos.');
            return self::FAILURE;
        }

        $this->info('2/3 - Iniciando generación de embeddings para ' . count($allChunks) . ' chunks...');
        $this->output->progressStart(count($allChunks));

        foreach ($allChunks as $chunkData) {
            try {
                $response = Http::withToken($apiToken)
                                ->timeout(60)
                                ->post(self::EMBEDDING_API_URL, [
                                    'inputs' => $chunkData['content'],
                                ]);

                if ($response->successful()) {
                    $embedding = $response->json();
                    DocumentChunk::updateOrCreate(
                        ['source' => $chunkData['source'], 'content' => $chunkData['content']],
                        ['embedding' => $embedding]
                    );
                } else {
                    $this->error(" -> Fallo para chunk de {$chunkData['source']}: " . $response->body());
                }

            } catch (\Exception $e) {
                $this->error(" -> Excepción de conexión: " . $e->getMessage());
            }
            
            $this->output->progressAdvance();
            usleep(250000); // Pausa de 0.25 segundos
        }

        $this->output->progressFinish();
        $this->info('3/3 - ✅ Proceso de indexación completado.');
        return self::SUCCESS;
    }
}