<header>
    <div class="row">
        <div class="col-12">
            <ul class="main-header-info d-flex flex-direction-row justify-between align-center">
                <ul class="main-header-info-icon">
                    <li class="toggleMenu">
                        <i class="fa-solid fa-bars"></i>
                    </li>

                </ul>

                <ul class="main-header-info-menu d-flex felx-direction-row justify-end align-center gap">
                    <li><a href="{{ route('dashboard.index') }}">Painel</a></li>

                    <li><a href="{{ route('dashboard.client.index') }}">Perfil</a></li>

                    <li><a href="{{ route('dashboard.logout') }}">Sair</a></li>
                </ul>
            </ul>

        </div>
    </div>
</header>
