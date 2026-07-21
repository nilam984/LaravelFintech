<!-- ==================== TOP HEADER MASTER COMPONENT ==================== -->
<header
    class="h-20 fintech-gradient text-white flex items-center justify-between px-4 sm:px-8 z-20 flex-shrink-0 border-b border-white/10">
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()"
            class="text-white/80 hover:text-white p-2 rounded-xl hover:bg-white/5 transition">
            <i class="bi bi-list text-2xl"></i>
        </button>
        <div class="hidden md:flex items-center gap-2 text-sm text-white/40">
            {{-- <span>Enterprise Secure Portal</span>
            <i class="bi bi-chevron-right text-xs"></i>
            <span class="text-white/80 font-medium">Core Console</span> --}}
        </div>
    </div>

    <div class="flex items-center gap-3 sm:gap-4">

        <!-- Notifications Menu Menu Dropdown Anchor -->
        <div class="relative">
            <button onclick="toggleNotificationMenu()"
                class="w-10 h-10 rounded-full flex items-center justify-center relative hover:bg-white/5 transition text-white/80 hover:text-white">
                <i class="bi bi-bell text-xl"></i>
                <span class="absolute top-2 right-2.5 w-2 h-2 bg-fintechCyan rounded-full"></span>
            </button>

            <!-- Popover Menu Box Content -->
            <div id="notificationMenu"
                class="hidden absolute right-0 mt-3 w-80 sm:w-96 bg-fintechDropdownBg border border-white/10 rounded-2xl shadow-2xl p-4 z-50">
                <div class="flex justify-between items-center pb-3 border-b border-white/10 mb-2">
                    <h4 class="font-bold text-sm text-white">System Alerts</h4>
                    <span class="text-xs text-fintechCyan cursor-pointer hover:underline">Clear Logs</span>
                </div>
                <div class="space-y-2 max-h-64 overflow-y-auto custom-scrollbar pr-1">
                    <div class="p-2.5 rounded-xl hover:bg-white/5 transition flex gap-3 text-xs">
                        <i class="bi bi-shield-fill-check text-fintechGreen text-base"></i>
                        <div>
                            <p class="text-white/90 font-medium">IP Authorization Verified</p>
                            <p class="text-white/40 mt-0.5">Device authenticated securely from 192.168.1.90</p>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl hover:bg-white/5 transition flex gap-3 text-xs">
                        <i class="bi bi-arrow-repeat text-fintechCyan text-base animate-spin"></i>
                        <div>
                            <p class="text-white/90 font-medium">Rebalancing Auto-Portfolio</p>
                            <p class="text-white/40 mt-0.5">Asset distributions optimized successfully.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom User Profile Menu Dropdown Anchor -->
        <div class="relative">
            <button onclick="toggleProfileMenu()"
                class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-white/5 transition text-left">
                <div
                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-fintechCyan to-fintechGreen flex items-center justify-center font-bold text-fintechDark text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="hidden sm:block text-xs">
                    <p class="font-bold leading-none text-white/90">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-white/40 mt-0.5">Premium Account</p>
                </div>
                <i class="bi bi-chevron-down text-xs text-white/40 hidden sm:block"></i>
            </button>

            @php
                if (auth()->user()->role == 'admin') {
                    $route = 'javascript:void(0)';
                } else {
                    $route = route('user.user-profile');
                }
            @endphp

            <div id="profileMenu"
                class="hidden absolute right-0 mt-3 w-56 bg-fintechDropdownBg border border-white/10 rounded-2xl shadow-2xl p-2 z-50">
                <a href="{{ $route }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-white/70 hover:text-white hover:bg-white/5 transition">
                    <i class="bi bi-person text-base text-fintechCyan"></i> Profile Config
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-white/70 hover:text-white hover:bg-white/5 transition">
                    <i class="bi bi-shield-lock text-base text-fintechCyan"></i> API Access Keys
                </a>
                <hr class="border-white/10 my-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition text-left">
                        <i class="bi bi-box-arrow-right text-base"></i> Close Secure Session
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>

<!-- ==================== TAILWIND OFFICIAL DESIGN TOASTER ==================== -->
<div id="toastContainer" aria-live="assertive"
    class="pointer-events-none fixed inset-0 flex items-start justify-end px-4 py-6 sm:p-6 z-[9999] flex-col gap-3 max-w-sm ml-auto">
    <!-- Dynamic notifications inject cleanly here -->
</div>
