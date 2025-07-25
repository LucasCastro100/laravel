<div class="col-12">
    <ul class="info-list-title-btn d-flex flex-direction-row justify-between align-center">
        <li class="list-title">
            <h2 class="bold">{{ $title }}</h2>
        </li>

        @if (isset($btns))
            <li class="list-btn d-flex flex-direction-row justify-between align-center gap">
                @foreach ($btns as $btn)
                    <a href="{{ $btn['route'] }}" class="btn">{{ $btn['name'] }}</a>
                @endforeach
            </li>
        @endif
    </ul>
</div>
