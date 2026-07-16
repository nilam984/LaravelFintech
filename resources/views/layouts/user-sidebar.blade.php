<!-- ==================== SIDEBAR MASTER COMPONENT WITH SUBMENUS ==================== -->
<aside id="sidebarPanel"
    class="fixed inset-y-0 left-0 z-40 w-64 h-full fintech-gradient text-white border-r border-white/10 transform -translate-x-full lg:translate-x-0 lg:static flex flex-col transition-transform duration-300 ease-in-out flex-shrink-0">
    <!-- Brand Area -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-white/10 flex-shrink-0">
        <div class="flex items-center gap-2">
            <i class="bi bi-cpu text-fintechCyan text-2xl"></i>
            <span class="text-xl font-bold tracking-tight">APEX (User)<span class="text-fintechCyan"></span></span>
        </div>
        <button onclick="toggleSidebar()"
            class="lg:hidden text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10">
            <i class="bi bi-x-lg text-lg"></i>
        </button>
    </div>

    <!-- Navigation Links Container -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
        <div class="text-xs font-semibold text-white/30 px-3 mb-2 tracking-wider uppercase">Overview</div>

        <a href="{{ route('user.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl to-transparent text-white font-medium transition duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-fintechCyan text-white' : 'text-white/60 hover:text-fintechCyan' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <!-- PARENT MENU ITEM: Ledger Accounts -->
        <div class="space-y-1">
            <button onclick="toggleSubmenu(this)"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-white/70 hover:text-white hover:bg-white/5 transition duration-200 group">
                <div class="flex items-center gap-3">
                    <i class="bi bi-wallet2"></i>
                    <span>Ledger Accounts</span>
                </div>
                <i
                    class="bi bi-chevron-down text-xs text-white/40 group-hover:text-white/80 transition-transform duration-200 submenu-chevron"></i>
            </button>
            <!-- CHILD MENU HIERARCHY -->
            <div class="hidden pl-9 pr-2 space-y-1 overflow-hidden transition-all duration-300 submenu-container">
                <a href="{{ route('user.service-request') }}" class="block py-2 text-sm text-white/60 hover:text-fintechCyan transition">Service Request</a>
            </div>
        </div>


        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/70 hover:text-white hover:bg-white/5 transition duration-200">
            <i class="bi bi-shield-check"></i> Security Protocols
        </a>

    </nav>

    <!-- Status Box Footer -->
    <div class="p-4 border-t border-white/10 flex-shrink-0">
        <div class="bg-white/[0.03] border border-white/10 p-3.5 rounded-xl flex items-center gap-3">
            <div class="w-2.5 h-2.5 bg-fintechGreen rounded-full animate-pulse"></div>
            <div class="text-xs">
                <p class="font-medium text-white/90">Node Status: Secure</p>
                <p class="text-white/40 text-[10px]">API Delay: 14ms</p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Overlay Layer -->
<div id="sidebarOverlay" onclick="toggleSidebar()"
    class="fixed inset-0 bg-black/60 z-30 hidden lg:hidden backdrop-blur-sm"></div>
