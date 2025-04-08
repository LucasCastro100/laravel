<td>
    <ul class="actions">
        
        @isset($show)
            <li class="show">
                <a href="{{ $show }}" title="VISUALIZAR">
                    <i class="fa-solid fa-eye"></i>
                </a>
            </li>
        @endisset

        @if (isset($chekUser) && $chekUser)
            @isset($edit)
                <li class="edit">
                    <a href="{{ $edit }}" title="EDITAR">
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                </li>
            @endisset

            @if (isset($trash) && $trash)
                <li class="active">
                    <form action="{{ $active }}" method="POST"
                        onsubmit="return confirm('Tem certeza que deseja ativar esta permuta?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="click" title="ATIVAR">
                            <i class="fa-solid fa-circle-check"></i>
                        </button>
                    </form>
                </li>
            @else
                @isset($delete)
                    <li class="delete">
                        <form action="{{ $delete }}" method="POST"
                            onsubmit="return confirm('Tem certeza que deseja deletar esta permuta?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="click" title="APAGAR">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </li>
                @endisset
            @endif

            @isset($pdf)
                <li class="pdf">
                    <a href="{{ $pdf }}" title="PDF">
                        <i class="fa-solid fa-file-pdf"></i>
                    </a>
                </li>
            @endisset
        @endif
    </ul>
</td>
