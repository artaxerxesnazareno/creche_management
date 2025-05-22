<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                        Sistema de Gestão de Creche
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('criancas.index')" :active="request()->routeIs('criancas.*')">
                        {{ __('Crianças') }}
                    </x-nav-link>
                    <x-nav-link :href="route('responsaveis.index')" :active="request()->routeIs('responsaveis.*')">
                        {{ __('Responsáveis') }}
                    </x-nav-link>
                    <x-nav-link :href="route('turmas.index')" :active="request()->routeIs('turmas.*')">
                        {{ __('Turmas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('matriculas.index')" :active="request()->routeIs('matriculas.*')">
                        {{ __('Matrículas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('presencas.index')" :active="request()->routeIs('presencas.*')">
                        {{ __('Presenças') }}
                    </x-nav-link>
                    <x-nav-link :href="route('relatorios.index')" :active="request()->routeIs('relatorios.*')">
                        {{ __('Relatórios') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative" x-data="{ open: false }">
                    <div>
                        <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-600">
                                <span class="text-sm font-medium leading-none text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                            </span>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </div>

                    <div x-show="open"
                         @click.away="open = false"
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                         role="menu"
                         aria-orientation="vertical"
                         aria-labelledby="user-menu-button"
                         tabindex="-1">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                           role="menuitem"
                           tabindex="-1"
                           id="user-menu-item-2">
                            Sair
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Abrir menu principal</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('criancas.index')" :active="request()->routeIs('criancas.*')">
                {{ __('Crianças') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('responsaveis.index')" :active="request()->routeIs('responsaveis.*')">
                {{ __('Responsáveis') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('turmas.index')" :active="request()->routeIs('turmas.*')">
                {{ __('Turmas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('matriculas.index')" :active="request()->routeIs('matriculas.*')">
                {{ __('Matrículas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('presencas.index')" :active="request()->routeIs('presencas.*')">
                {{ __('Presenças') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('relatorios.index')" :active="request()->routeIs('relatorios.*')">
                {{ __('Relatórios') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ auth()->user()->name ?? 'Usuário' }}</div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email ?? 'email@exemplo.com' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form-responsive').submit();">
                    {{ __('Sair') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}" id="logout-form-responsive" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
