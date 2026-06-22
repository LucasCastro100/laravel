@php
    $isTbr = request()->routeIs('tbr.*');
    $isClientes = request()->routeIs('clientes.*');
    $isFinanceiro = request()->routeIs('financeiro.*');
@endphp

<div class="h-full">
    <div x-data="{ collapsed: JSON.parse(localStorage.getItem('sidebarCollapsed') || 'false'), showNav: true, showActions: true }"
         x-init="$watch('collapsed', val => { localStorage.setItem('sidebarCollapsed', val); window.dispatchEvent(new CustomEvent('sidebar-collapsed', { detail: val })) })"
        class="sidebar h-full flex flex-col transition-all duration-300 ease-in-out"
        :class="collapsed ? 'w-16' : 'w-64'">

        {{-- Botão de colapsar --}}
        <div class="flex items-center py-3 border-b border-gray-800/50 transition-all duration-300"
             :class="collapsed ? 'justify-center px-0' : 'justify-between px-4'">
            <span x-show="!collapsed" class="text-xs uppercase font-bold tracking-wider text-gray-500">
                @if ($isTbr) TBR
                @elseif ($isClientes) Clientes
                @elseif ($isFinanceiro) Financeiro
                @else Menu @endif
            </span>
            <button @click="collapsed = !collapsed"
                class="p-1.5 rounded-lg hover:bg-gray-800 text-gray-400 hover:text-gray-200 transition"
                :title="collapsed ? 'Expandir' : 'Colapsar'">
                <svg :class="collapsed ? 'rotate-180' : ''"
                    class="h-5 w-5 transform transition-transform duration-300" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>
        </div>

        {{-- Navegação --}}
        <div class="px-3 mt-3">
            <div class="flex items-center justify-between px-2 py-1.5 cursor-pointer text-gray-500 text-xs uppercase font-bold tracking-wider"
                @click="showNav = !showNav" title="Mostrar/Esconder Navegação">
                <span x-show="!collapsed">Navegação</span>
                <svg x-show="!collapsed" :class="showNav ? 'rotate-180' : ''"
                    class="h-3.5 w-3.5 transform transition-transform" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <ul x-show="showNav" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-0 translate-y-0"
                class="space-y-0.5 mt-1">

                {{-- TBR Navigation --}}
                @if ($isTbr)
                <li>
                    <a wire:navigate href="{{ route('tbr.dashboard') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('tbr.dashboard') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Dashboard">
                        <i class="sidebar-icon fas fa-house text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('tbr.categories') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('tbr.categories') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Categorias">
                        <i class="sidebar-icon fas fa-tags text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Categorias</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('tbr.questions') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('tbr.questions') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Perguntas">
                        <i class="sidebar-icon fas fa-question-circle text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Perguntas</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('tbr.modalities') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('tbr.modalities') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Modalidades">
                        <i class="sidebar-icon fas fa-layer-group text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Modalidades</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('tbr.dp-missions') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('tbr.dp-missions') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Missões DP">
                        <i class="sidebar-icon fas fa-robot text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Missões DP</span>
                    </a>
                </li>
                @endif

                {{-- Clientes Navigation --}}
                @if ($isClientes)
                <li>
                    <a wire:navigate href="{{ route('clientes.dashboard') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('clientes.dashboard') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Dashboard">
                        <i class="sidebar-icon fas fa-house text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('clientes.clients') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('clientes.clients') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Clientes">
                        <i class="sidebar-icon fas fa-users text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Clientes</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('clientes.plans') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('clientes.plans') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Planos">
                        <i class="sidebar-icon fas fa-file-invoice text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Planos</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('clientes.receitas') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('clientes.receitas') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Receitas">
                        <i class="sidebar-icon fas fa-money-bill-wave text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Receitas</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('clientes.accounts') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('clientes.accounts') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Gastos">
                        <i class="sidebar-icon fas fa-credit-card text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Gastos</span>
                    </a>
                </li>
                @endif

                {{-- Financeiro Navigation --}}
                @if ($isFinanceiro)
                <li>
                    <a wire:navigate href="{{ route('financeiro.dashboard') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('financeiro.dashboard') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Dashboard">
                        <i class="sidebar-icon fas fa-house text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('financeiro.transactions') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('financeiro.transactions') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Contas">
                        <i class="sidebar-icon fas fa-credit-card text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Contas</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('financeiro.account-types') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('financeiro.account-types') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Tipos de Conta">
                        <i class="sidebar-icon fas fa-list text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Tipos de Conta</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('financeiro.categories') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('financeiro.categories') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Categorias">
                        <i class="sidebar-icon fas fa-tags text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Categorias</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>

        {{-- TBR Ações (only in TBR) --}}
        @if ($isTbr)
        <hr class="sidebar-divider my-4 mx-3" />

        <div class="px-3">
            <div class="flex items-center justify-between px-2 py-1.5 cursor-pointer text-gray-500 text-xs uppercase font-bold tracking-wider"
                @click="showActions = !showActions" title="Mostrar/Esconder Ações">
                <span x-show="!collapsed">Ações</span>
                <svg x-show="!collapsed" :class="showActions ? 'rotate-180' : ''"
                    class="h-3.5 w-3.5 transform transition-transform" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <ul x-show="showActions" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-0 translate-y-0"
                class="space-y-0.5 mt-1">
                @can('create-event')
                <li>
                    <button wire:click="openEventModal"
                        class="sidebar-action-btn event flex items-center gap-3 px-4 py-2.5 rounded-lg w-full text-left transition"
                        :class="{ 'justify-center': collapsed }" title="Abrir modal para cadastrar eventos">
                        <i class="sidebar-icon fas fa-calendar-plus text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Cadastrar Eventos</span>
                    </button>
                </li>
                @endcan

                @can('create')
                <li>
                    <button wire:click="openTeamModal"
                        class="sidebar-action-btn team flex items-center gap-3 px-4 py-2.5 rounded-lg w-full text-left transition"
                        :class="{ 'justify-center': collapsed }" title="Abrir modal para cadastrar equipes">
                        <i class="sidebar-icon fas fa-users text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Cadastrar Equipes</span>
                    </button>
                </li>
                @endcan
            </ul>
        </div>
        @endif

        {{-- Spacer --}}
        <div class="flex-1"></div>

        {{-- Perfil / Sair --}}
        <div class="px-3 py-3 border-t border-gray-800/50 mt-2">
            <ul class="space-y-0.5">
                <li>
                    <a wire:navigate href="{{ route('profile.show') }}"
                        class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('profile.show') ? 'active' : '' }}"
                        :class="{ 'justify-center': collapsed }" title="Perfil">
                        <i class="sidebar-icon fas fa-user text-gray-500"></i>
                        <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Perfil</span>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="sidebar-action-btn logout flex items-center gap-3 px-4 py-2.5 rounded-lg w-full text-left transition"
                            :class="{ 'justify-center': collapsed }" title="Sair">
                            <i class="sidebar-icon fas fa-sign-out-alt text-gray-500"></i>
                            <span x-show="!collapsed" class="sidebar-text text-xs font-semibold text-gray-400">Sair</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    {{-- Modal para cadastrar eventos --}}
    @if ($showEventModal)
        <div class="fixed p-6 inset-0 bg-black/70 flex items-center justify-center z-50">
            <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl w-full max-w-md max-h-[90vh] overflow-y-auto text-center space-y-6">
                <h2 class="text-xl font-bold mb-4 text-gray-100">Cadastrar Evento</h2>

                <div class="space-y-4 text-left">
                    <fieldset class="border border-gray-700 rounded p-4 mt-4">
                        <legend class="font-semibold mb-2 text-gray-300">Dados Evento</legend>
                        <div class="mb-4">
                            <label class="block font-semibold text-gray-300">Nome do evento</label>
                            <input type="text" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2" placeholder="Nome do evento"
                                wire:model.defer="eventName">
                            @error('eventName')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label class="block font-semibold text-gray-300">Data do evento</label>
                            <input type="date" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2" wire:model.defer="eventDate">
                            @error('eventDate')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="border border-gray-700 rounded p-4">
                        <legend class="font-semibold mb-2 text-gray-300">Localização</legend>

                        <div class="mb-4">
                            <label class="block font-semibold text-gray-300">Região</label>
                            <input list="regions" wire:model.lazy="selectedRegion"
                                class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2" placeholder="Digite ou selecione a região" />
                            <datalist id="regions">
                                @foreach ($regions as $region)
                                    <option value="{{ $region['nome'] }}"></option>
                                @endforeach
                            </datalist>

                            <div wire:loading.delay wire:target="selectedRegion" wire:loading.class='w-full p-2'>
                                <span class="font-semibold text-gray-400">Carregando Estados...</span>
                            </div>
                        </div>

                        @if ($selectedRegionId)
                            <div class="mb-4">
                                <label class="block font-semibold text-gray-300">Estado</label>

                                @if (count($filteredStates) > 0)
                                    <input list="states" wire:model.lazy="selectedState"
                                        class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2"
                                        placeholder="Digite ou selecione o estado" />
                                    <datalist id="states">
                                        @foreach ($filteredStates as $state)
                                            <option value="{{ $state['nome'] }}"></option>
                                        @endforeach
                                    </datalist>
                                @endif

                                <div wire:loading.delay wire:target="selectedState" wire:loading.class='w-full p-2'>
                                    <span class="font-semibold text-gray-400">Carregando Municípios...</span>
                                </div>
                            </div>
                        @endif

                        @if ($selectedStateId)
                            <div class="mb-0">
                                <label class="block font-semibold text-gray-300">Município</label>

                                @if (count($filteredCities) > 0)
                                    <input list="cities" wire:model.lazy="selectedCity"
                                        class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2"
                                        placeholder="Digite ou selecione o município" />
                                    <datalist id="cities">
                                        @foreach ($filteredCities as $city)
                                            <option value="{{ $city['nome'] }}"></option>
                                        @endforeach
                                    </datalist>
                                @endif
                            </div>
                        @endif
                    </fieldset>

                </div>

                <div class="text-right space-x-2 mt-6">
                    <button wire:click="saveEvent"
                        class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded transition">Salvar</button>
                    <button wire:click="closeEventModal"
                        class="bg-gray-700 hover:bg-gray-600 text-gray-200 font-semibold py-2 px-4 rounded transition">Fechar</button>
                </div>

                <div wire:loading wire:target="saveEvent" wire:loading.class='w-full p-2'>
                    <span class="font-semibold text-gray-400">Salvando evento...</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal para cadastrar equipes --}}
    @if ($showTeamModal)
        <div class="fixed p-6 inset-0 bg-black/70 flex items-center justify-center z-50">
            <div
                class="bg-gray-900 border border-gray-800 p-6 rounded-xl w-full max-w-md max-h-[90vh] overflow-y-auto text-center sm:max-w-xl md:max-w-2xl">
                <h2 class="text-xl font-bold mb-6 text-gray-100">Cadastrar Equipe</h2>

                <div class="grid gap-4 grid-cols-1 md:grid-cols-3">
                    <div class="mb-6 text-left lg:col-span-2">
                        <label for="selectedEventId" class="block font-semibold text-gray-300 mb-1">Selecione o Evento</label>
                        <select id="selectedEventId" wire:model="selectedEventId"
                            class="bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2 w-full">
                            <option value="">-- Selecione um evento --</option>
                            @foreach ($events as $event)
                                <option value="{{ $event['id'] }}">{{ $event['name'] }} ({{ $event['date'] }})
                                </option>
                            @endforeach
                        </select>
                        @error('selectedEventId')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6 text-left">
                        <label for="numTeams" class="block font-semibold text-gray-300 mb-1">Quantidade de equipes</label>
                        <input type="number" id="numTeams" min="1" wire:model.lazy="numTeams"
                            class="bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2 w-full" />
                    </div>
                </div>

                <form wire:submit.prevent="saveTeams" class="space-y-8">
                    @foreach ($teams as $index => $team)
                        <div class="border border-gray-700 rounded p-4 space-y-3">
                            <div class="grid gap-4 grid-cols-1 md:grid-cols-3 items-start">
                                <div class="md:col-span-2">
                                    <label for="teamName{{ $index }}" class="block font-semibold text-gray-300 mb-1">Nome da equipe <span class="text-red-400">*</span></label>
                                    <input id="teamName{{ $index }}"
                                        wire:model.defer="teams.{{ $index }}.name"
                                        placeholder="Nome da equipe" required
                                        class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
                                    @error("teams.$index.name")
                                        <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="teamCategory{{ $index }}"
                                        class="block font-semibold text-gray-300 mb-1">Categoria</label>
                                    <select id="teamCategory{{ $index }}"
                                        wire:model.defer="teams.{{ $index }}.category"
                                        class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category['slug'] }}">{{ ucfirst($category['slug']) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("teams.$index.category")
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <details class="border-t border-gray-700 pt-3">
                                <summary class="text-sm text-gray-400 cursor-pointer hover:text-gray-200 transition font-medium">
                                    Representante (opcional)
                                </summary>
                                <div class="grid gap-4 grid-cols-1 md:grid-cols-3 mt-3">
                                    <div>
                                        <label for="repName{{ $index }}" class="block font-semibold text-gray-300 mb-1">Nome</label>
                                        <input id="repName{{ $index }}"
                                            wire:model.defer="teams.{{ $index }}.representative_name"
                                            placeholder="Nome do representante"
                                            class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
                                        @error("teams.$index.representative_name")
                                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="repEmail{{ $index }}" class="block font-semibold text-gray-300 mb-1">E-mail</label>
                                        <input id="repEmail{{ $index }}" type="email"
                                            wire:model.defer="teams.{{ $index }}.representative_email"
                                            placeholder="email@exemplo.com"
                                            class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
                                        @error("teams.$index.representative_email")
                                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="repPhone{{ $index }}" class="block font-semibold text-gray-300 mb-1">Telefone</label>
                                        <input id="repPhone{{ $index }}" type="tel" maxlength="15"
                                            wire:model.defer="teams.{{ $index }}.representative_phone"
                                            placeholder="(99) 99999-9999"
                                            x-on:input="
                                                let val = $event.target.value.replace(/\D/g, '').substring(0, 11);
                                                val = val.replace(/^(\d{2})(\d)/, '($1) $2').replace(/(\d{5})(\d)/, '$1-$2');
                                                $event.target.value = val"
                                            class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
                                        @error("teams.$index.representative_phone")
                                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </details>
                        </div>
                    @endforeach

                    <div class="flex flex-wrap gap-2 justify-center mt-6">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-500 text-white px-6 py-2 rounded transition">
                            Cadastrar Equipes
                        </button>

                        <button type="button" wire:click="resetTeamForm"
                            class="bg-red-600 hover:bg-red-500 text-white px-6 py-2 rounded transition">
                            Limpar Formulário
                        </button>

                        <button wire:click="closeTeamModal"
                            class="bg-gray-700 hover:bg-gray-600 text-gray-200 font-semibold py-2 px-4 rounded transition">
                            Fechar
                        </button>
                    </div>

                    <div wire:loading wire:loading.target="saveTeams" wire:loading.class='w-full p-2'>
                        <span class="font-semibold text-gray-400">Salvando equipes...</span>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal de confirmação para limpar armazenamento --}}
    @if ($confirmClearStorage)
        <div class="fixed p-6 inset-0 bg-black/70 flex items-center justify-center z-50">
            <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl w-full max-w-md text-center">
                <h2 class="text-xl font-bold mb-4 text-gray-100">Tem certeza que deseja apagar todos os dados?</h2>
                <p class="mb-6 text-gray-400">Essa ação irá limpar todos os eventos e equipes salvos.</p>

                <div class="flex justify-center space-x-4">
                    <button wire:click="cancelClearStorage"
                        class="bg-gray-700 hover:bg-gray-600 text-gray-200 font-semibold py-2 px-4 rounded transition">Cancelar</button>

                    <button wire:click="confirmAndClearStorage"
                        class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded transition">Apagar Dados</button>
                </div>
            </div>
        </div>
    @endif
</div>
