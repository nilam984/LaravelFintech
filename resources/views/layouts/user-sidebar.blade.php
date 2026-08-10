<aside id="sidebarPanel"
    class="fixed inset-y-0 left-0 z-40 w-64 h-full fintech-gradient text-white border-r border-white/10 transform -translate-x-full lg:translate-x-0 lg:static flex flex-col transition-transform duration-300 ease-in-out flex-shrink-0">
    <!-- Brand Area -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-white/10 flex-shrink-0">
        <div class="flex items-center gap-2">
            <i class="bi bi-cpu text-fintechCyan text-2xl"></i>
            <span class="text-xl font-bold tracking-tight">Fintech<span class="text-fintechCyan"></span></span>
        </div>
        <button onclick="toggleSidebar()"
            class="lg:hidden text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10">
            <i class="bi bi-x-lg text-lg"></i>
        </button>
    </div>


    @php
        $menus = [
            [
                'name' => 'Dashboard',
                'icon' => 'bi-grid-1x2-fill',
                'route' => 'user.dashboard',
            ],

            [
                'name' => 'Service',
                'icon' => 'bi-gear-fill',
                'submenu' => [
                    [
                        'name' => 'Service Request',
                        'route' => 'user.service-request',
                    ],
                ],
            ],

            [
                'name' => 'Load Money',
                'icon' => 'bi-wallet2',
                'route' => 'user.load.money',
            ],

            [
                'name' => 'Bank Update Request',
                'icon' => 'bi-bank',
                'route' => 'user.bank.update.request',
            ],

            [
                'name' => 'Security Protocols',
                'icon' => 'bi-shield-check',
                'route' => '#',
            ],

            // More menus can be added here...
            /*
        [
            'name' => 'Transactions',
            'icon' => 'bi-arrow-left-right',
            'route' => 'user.transactions',
        ],

        [
            'name' => 'Reports',
            'icon' => 'bi-bar-chart',
            'submenu' => [
                [
                    'name' => 'Transaction Report',
                    'route' => 'user.transaction.report',
                ],
                [
                    'name' => 'Payment Report',
                    'route' => 'user.payment.report',
                ],
            ],
        ],
        */
        ];
    @endphp


    <!-- Navigation Links Container -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">

        <div class="text-xs font-semibold text-white/30 px-3 mb-2 tracking-wider uppercase">
            Overview
        </div>

        @foreach ($menus as $menu)
            @php
                $hasSubmenu = !empty($menu['submenu']);

                // Check whether current route belongs to this menu
                $menuActive = false;

                if (!empty($menu['route']) && $menu['route'] !== '#') {
                    $menuActive = request()->routeIs($menu['route']);
                }

                // Check whether any submenu is active
                $submenuActive = false;

                if ($hasSubmenu) {
                    foreach ($menu['submenu'] as $submenu) {
                        if (request()->routeIs($submenu['route'])) {
                            $submenuActive = true;
                            break;
                        }
                    }
                }

                $isActive = $menuActive || $submenuActive;
            @endphp


            @if ($hasSubmenu)
                {{-- Parent Menu --}}
                <div class="space-y-1">

                    <button type="button" onclick="toggleSubmenu(this)"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition duration-200 group
                    {{ $isActive ? 'bg-white/10 text-white' : 'text-white/70 hover:text-white hover:bg-white/5' }}">

                        <div class="flex items-center gap-3">
                            <i class="bi {{ $menu['icon'] }}"></i>
                            <span>{{ $menu['name'] }}</span>
                        </div>

                        <i
                            class="bi bi-chevron-down text-xs text-white/40 group-hover:text-white/80
                        transition-transform duration-200 submenu-chevron
                        {{ $isActive ? 'rotate-180' : '' }}">
                        </i>

                    </button>


                    {{-- Submenu --}}
                    <div
                        class="pl-9 pr-2 space-y-1 overflow-hidden transition-all duration-300
                    submenu-container {{ $isActive ? '' : 'hidden' }}">

                        @foreach ($menu['submenu'] as $submenu)
                            <a href="{{ $submenu['route'] === '#' ? '#' : route($submenu['route']) }}"
                                class="block px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs($submenu['route']) ? 'bg-fintechCyan text-white' : 'text-white/60 hover:text-fintechCyan' }}">

                                {{ $submenu['name'] }}

                            </a>
                        @endforeach

                    </div>

                </div>
            @else
                {{-- Normal Menu --}}
                <a href="{{ $menu['route'] === '#' ? '#' : route($menu['route']) }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white font-medium
                transition duration-200
                {{ $menuActive ? 'bg-fintechCyan text-white' : 'text-white/60 hover:text-fintechCyan' }}">

                    <i class="bi {{ $menu['icon'] }}"></i>

                    {{ $menu['name'] }}

                </a>
            @endif
        @endforeach

    </nav>

</aside>

<div id="sidebarOverlay" onclick="toggleSidebar()"
    class="fixed inset-0 bg-black/60 z-30 hidden lg:hidden backdrop-blur-sm"></div>
