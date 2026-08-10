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
        $menus = app(\App\Services\MenuService::class)->getMenusForCurrentUser();
    @endphp

    <!-- Navigation Links Container -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">

        @foreach ($menus as $menu)

            @php

                $hasChildren = $menu->children->isNotEmpty();

                $menuActive = false;

                if ($menu->route) {
                    $menuActive = request()->routeIs($menu->route);
                }

                $childActive = false;

                foreach ($menu->children as $child) {
                    if ($child->route && request()->routeIs($child->route)) {
                        $childActive = true;
                        break;
                    }
                }

                $isActive = $menuActive || $childActive;
            @endphp

            {{-- ========================================================= --}}
            {{-- PARENT MENU WITH SUBMENUS --}}
            {{-- ========================================================= --}}

            @if ($hasChildren)
                <div class="space-y-1">

                    <button type="button" onclick="toggleSubmenu(this)"
                        class="w-full flex items-center justify-between
                    px-3 py-2.5 rounded-xl transition duration-200 group
                    {{ $isActive ? 'bg-white/10 text-white' : 'text-white/70 hover:text-white hover:bg-white/5' }}">

                        <div class="flex items-center gap-3">

                            @if ($menu->icon)
                                <i class="bi {{ $menu->icon }}"></i>
                            @endif

                            <span>
                                {{ $menu->name }}
                            </span>

                        </div>

                        <i
                            class="bi bi-chevron-down text-xs
                        text-white/40 group-hover:text-white/80
                        transition-transform duration-200
                        submenu-chevron
                        {{ $isActive ? 'rotate-180' : '' }}">
                        </i>

                    </button>


                    {{-- ================================================= --}}
                    {{-- SUBMENU CONTAINER --}}
                    {{-- ================================================= --}}

                    <div
                        class="pl-9 pr-2 space-y-1
                    overflow-hidden transition-all duration-300
                    submenu-container
                    {{ $isActive ? '' : 'hidden' }}">

                        @foreach ($menu->children as $child)
                            @if ($child->route)
                                <a href="{{ route($child->route) }}"
                                    class="block px-3 py-2 rounded-lg
                                text-sm transition
                                {{ request()->routeIs($child->route) ? 'bg-fintechCyan text-white' : 'text-white/60 hover:text-fintechCyan' }}">

                                    {{ $child->name }}

                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- NORMAL MENU WITHOUT SUBMENUS --}}
                {{-- ========================================================= --}}
            @else
                @if ($menu->route)
                    <a href="{{ route($menu->route) }}"
                        class="flex items-center gap-3
                    px-3 py-2.5 rounded-xl
                    text-white font-medium
                    transition duration-200
                    {{ request()->routeIs($menu->route) ? 'bg-fintechCyan text-white' : 'text-white/60 hover:text-fintechCyan' }}">

                        @if ($menu->icon)
                            <i class="bi {{ $menu->icon }}"></i>
                        @endif

                        {{ $menu->name }}

                    </a>
                @endif
            @endif
        @endforeach
    </nav>
</aside>
<!-- Mobile Overlay Layer -->
<div id="sidebarOverlay" onclick="toggleSidebar()"
    class="fixed inset-0 bg-black/60 z-30 hidden lg:hidden backdrop-blur-sm"></div>
