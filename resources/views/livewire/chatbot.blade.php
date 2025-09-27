<div class="h-screen bg-gray-100 flex flex-col">
    <!-- Encabezado del Chat -->
    <header class="bg-white shadow-md p-4">
        <h1 class="text-2xl font-bold text-center text-gray-800">Asistente Virtual Ropa IA</h1>
    </header>

    <!-- Área de Mensajes -->
    <div class="flex-1 overflow-y-auto p-6 space-y-4" id="message-container">
        @foreach ($messages as $message)
            @if ($message['source'] === 'bot')
                <!-- Mensaje del Bot -->
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold">
                        IA
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm max-w-lg">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $message['content'] }}</p>
                    </div>
                </div>
            @else
                <!-- Mensaje del Usuario -->
                <div class="flex items-start gap-3 justify-end">
                    <div class="bg-indigo-500 text-white p-4 rounded-lg shadow-sm max-w-lg">
                        <p class="whitespace-pre-wrap">{{ $message['content'] }}</p>
                    </div>
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-300 text-gray-700 flex items-center justify-center font-bold">
                        Tú
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Barra de Entrada de Texto -->
    <footer class="bg-white border-t border-gray-200 p-4">
        <form wire:submit.prevent="sendMessage" class="flex items-center gap-4">
            <input 
                wire:model="newMessage"
                type="text"
                placeholder="Escribe tu pregunta aquí..."
                class="flex-1 p-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500"
                autocomplete="off"
            >
            <button 
                type="submit"
                class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-full hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors disabled:opacity-50"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Enviar</span>
                <span wire:loading>...</span>
            </button>
        </form>
    </footer>

    <!-- Script para auto-scroll -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            const messageContainer = document.getElementById('message-container');
            
            // Función para hacer scroll al final
            const scrollToBottom = () => {
                messageContainer.scrollTop = messageContainer.scrollHeight;
            }

            // Scroll inicial
            scrollToBottom();

            // Escuchar por nuevos mensajes y hacer scroll
            Livewire.hook('message.processed', () => {
                scrollToBottom();
            });
        });
    </script>
</div>