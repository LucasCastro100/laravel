<div class="col-12">
    @if ($message)
        <div class="w-100 mb-1 alert {{ $status === 'success' ? 'alert-success' : 'alert-erro' }}">
            {{ $message }}
        </div>
    @endif

    <div class="w-100 overflow-x">
        @if (count($prospectingr) > 0)
            <table>
                <thead>
                    <tr>
                        <th>USUÁRIO</th>
                        <th>SEGMENTO</th>
                        <th>EMPRESA</th>
                        <th>AÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prospectingr as $prospect)
                        <tr>
                            <td>{{ $prospect->client->name }}</td>

                            <td class="{{ $prospect->prospecting == null ? 'text-center' : '' }}">
                                @if ($prospect->prospecting == null)
                                    <i class="fa-solid fa-xmark"></i>
                                @else
                                    {{ $prospect->prospecting }}
                                @endif
                            </td>

                            <td class="{{ $prospect->company == null ? 'text-center' : '' }}">
                                @if ($prospect->company == null)
                                    <i class="fa-solid fa-xmark"></i>
                                @else
                                    {{ $prospect->company }}
                                @endif
                            </td>

                            <td>
                                <ul class="actions">
                                    <li class="delete">
                                        <button type="submit" class="click" title="APAGAR"
                                            wire:click="deleteProspecction({{ $prospect->id }})">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $prospectingr->links() }}
        @else
            <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
        @endif
    </div>
</div>
