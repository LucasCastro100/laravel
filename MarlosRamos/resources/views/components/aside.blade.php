<aside class="bg-white text-black fixed h-full border-r border-gray-100 md:block p-4 transition-all text-center"
    :class="openAside ? 'w-[250px]' : 'w-[85px]'">

    <button @click="openAside = !openAside" class="p-2 bg-gray-50 rounded-md mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>

    <!-- MENU -->
    <nav class="space-y-2">
        @foreach ($adminMenu as $item)
            {{-- @if (Auth::user()->role >= $item['role']) --}}
                <x-responsive-nav-link :href="route($item['route'])" :active="request()->routeIs($item['route'])">
                    <i class="{{ $item['icon'] }} pr-2"></i>
                    <span class="ml-3 text-sm font-medium transition-all duration-300"
                        x-show="openAside">{{ __($item['name']) }}</span>
                </x-responsive-nav-link>
            {{-- @endif --}}
        @endforeach

        <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
            <i class="fas fa-user-circle pr-2"></i>
            <span class="ml-3 text-sm font-medium transition-all duration-300"
                x-show="openAside">{{ __('Perfil') }}</span>
        </x-responsive-nav-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                onclick="event.preventDefault();
                                this.closest('form').submit();">
                <i class="fas fa-sign-out-alt pr-2"></i>
                <span class="ml-3 text-sm font-medium transition-all duration-300"
                    x-show="openAside">{{ __('Sair') }}</span>
            </x-responsive-nav-link>
        </form>
    </nav>
</aside>
