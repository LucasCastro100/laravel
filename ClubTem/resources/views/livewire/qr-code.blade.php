<div class="col-12">
    <div class="row">
        @if ($qrCodes->isEmpty())
            <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
        @else
            {{ $qrCodes->links() }}
        @endif
    </div>
</div>
