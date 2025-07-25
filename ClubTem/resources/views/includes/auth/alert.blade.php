<div class="msg col-12">
    @if (session('message'))
        <div class="alert alert-{{ session('status') }}">
        {{ session('message') }}
        </div>
    @endif

    @if ($errors->any() || $errors->has('error'))
        <div class="col-12 alert alert-erro">
            <ul class="d-flex flex-direction-column gap-0-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>