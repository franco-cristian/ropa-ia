<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ChatService;

class Chatbot extends Component
{
    public array $messages = [];
    public string $newMessage = '';

    /**
     * Se ejecuta cuando el componente se carga por primera vez.
     */
    public function mount(): void
    {
        // Añadimos el mensaje de bienvenida inicial.
        $this->messages[] = [
            'source' => 'bot',
            'content' => '¡Hola! Soy el asistente de Ropa IA. ¿En qué puedo ayudarte hoy? Puedo darte recomendaciones de compra. Puedes preguntarme sobre nuestras políticas de envío, devoluciones o cómo cuidar tu ropa.'
        ];
    }

    /**
     * Se ejecuta cuando el usuario envía un mensaje.
     */
    public function sendMessage(ChatService $chatService): void
    {
        $userMessage = trim($this->newMessage);
        if (empty($userMessage)) {
            return;
        }

        // 1. Añade el mensaje del usuario al historial.
        $this->messages[] = ['source' => 'user', 'content' => $userMessage];
        $this->newMessage = ''; // Limpia el input.

        // 2. Muestra un indicador de "escribiendo...".
        $this->messages[] = ['source' => 'bot', 'content' => '...'];
        $typingMessageIndex = array_key_last($this->messages);

        // Pasamos el historial de mensajes (excepto el "escribiendo...") al servicio.
        $historyForService = array_slice($this->messages, 0, -1);

        // 3. Llama a nuestro "cerebro" para obtener la respuesta inteligente.
        $botResponse = $chatService->getSmartResponse($userMessage, $historyForService);

        // 4. Reemplaza el "escribiendo..." con la respuesta real.
        $this->messages[$typingMessageIndex]['content'] = $botResponse;
    }

    public function render()
    {
        return view('livewire.chatbot');
    }
}