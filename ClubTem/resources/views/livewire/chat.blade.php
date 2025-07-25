<div class="col-12">
    <div class="row">
        <div id="messages-container" class="messages-container" wire:poll.1000ms="checkForNewMessages">
            @foreach ($messages as $date => $dailyMessages)
                <div class="date-separator">
                    <span>{{ $date }}</span>
                </div>
                @foreach ($dailyMessages as $message)
                    <div wire:key="message-{{ $message->id }}"
                        class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                        <div class="message-content">
                            <strong>{{ $message->chat }}</strong>
                            <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

        <div class="input-container">
            <textarea wire:model="newMessage" class="chat-input" placeholder="Digite sua mensagem..."></textarea>
            <button wire:click="sendMessage" class="send-button" @if(empty($newMessage)) disabled @endif>Enviar</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            scrollToBottom();
            console.log(container)
        });

        window.addEventListener('messagesUpdated', function() {
            scrollToBottom();
        });

        function scrollToBottom() {
            var container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }         
        }
    </script>
</div>
