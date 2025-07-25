<div class="col-12">
    @if ($friends->isEmpty())
        <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
    @else
        <ul class="list-friends">
            @if ($friends->isEmpty())
                <li class="d-flex flex-direction-row justify-between align-center">
                    <h5 class="m-0">Sem nenhum convite</h5>
                </li>
            @else
                @foreach ($friends as $friend)
                    <?php
                    $friend = $friend->user_id === Auth::user()->id ? [$friend->friend, $friend->status, 'sender', $friend->uuid] : [$friend->user, $friend->status, 'receiver', $friend->uuid];
                    
                    $nameParts = explode(' ', $friend[0]->client->name);
                    $firstName = mb_strtoupper($nameParts[0]);
                    $lastName = count($nameParts) > 1 ? mb_strtoupper(end($nameParts)) : '';
                    ?>

                    <li class="d-flex flex-direction-row justify-between align-center">
                        <h5 class="m-0">{{ $firstName }} {{ $lastName }}</h5>

                        @if ($friend[1] == 'pending')
                            @if ($friend[2] == 'sender')
                                <div class="name_friendly">
                                    <p class="alert alert-pending">Aguardando resposta</p>
                                </div>
                            @else
                                <div class="d-flex flex-direction-row align-center justify-center gap">
                                    <form action="{{ route('dashboard.friend.accept', ['friendId' => $friend[3]]) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="click alert alert-success">Aceitar</button>
                                    </form>

                                    <form action="{{ route('dashboard.friend.reject', ['friendId' => $friend[3]]) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="click alert alert-erro">Rejeitar</button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('dashboard.chat.show', ['friendId' => $friend[0]->id]) }}" class="alert alert-primary">Iniciar
                                conversa</a>
                        @endif
                    </li>
                @endforeach
            @endif
        </ul>
    @endif
</div>
