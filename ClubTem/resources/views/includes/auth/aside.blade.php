<ul class="aside-info w-100 h-100">
    <ul class="aside-info-user">
        <li class="logo text-center">
            <img src="{{ asset('img/web/logo_aside.png') }}" alt="Foto Usuário" title="Foto Usuário">
        </li>

        <li class="aside-info-user-img d-flex align-center justify-center">
            @if (Auth::user()->client == null)
                <i class="fa-solid fa-user"></i>
            @else
                @if (Auth::user()->client->photo == null)
                    <i class="fa-solid fa-user"></i>
                @else
                    <img src="{{ asset('storage/img/users/' . Auth::user()->client->photo) }}" alt="Foto Usuário"
                        title="Foto Usuário">
                @endif
            @endif

            <h6 class="bold text-center m-0">{{ Auth::user()->client->name ?? '' }}</h6>
        </li>

        {{-- <li class="aside-info-name">
            
        </li> --}}

        <li class="aside-info-level">
            <h6 class="bold text-center m-0">{{ str_replace('_', ' ', Auth::user()->role->name) ?? '' }}</h6>
        </li>

        <div class="close-aside">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </ul>

    <ul class="aside-info-menu">
        @foreach ($menuRoles as $item)
            <li>
                <a href="{{ $item['route'] }}">{{ $item['name'] }}</a>
            </li>
        @endforeach
    </ul>
</ul>
