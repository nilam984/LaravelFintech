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

    @php
        $role = null;
        if (Auth::check()) {
            $role = Auth::user()->role;
        }
    @endphp

    <div class="flex items-center gap-3 sm:gap-4">

        {{-- Wallet Balance Badges --}}
        <div class="flex items-center gap-2">

            {{-- Main Wallet (Always Visible) --}}
            @if ($role == 'admin' || $role == 'user')
                <div class="flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-2"
                    title="Main Wallet">
                    <i class="bi bi-wallet2 text-fintechCyan"></i>
                    <div class="text-xs">
                        {{-- <p class="text-white/40">Main</p> --}}
                        <p class="font-semibold text-white">
                            ₹{{ number_format(optional(auth()->user())->wallet_summary['main_wallet'], 2) }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Payin Wallet (Hidden Mobile) --}}
            @if ($role == 'admin' || $role == 'user')
                <div class="hidden md:flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-2"
                    title="Payin">
                    <i class="bi bi-arrow-down-circle text-fintechGreen"></i>
                    <div class="text-xs">
                        {{-- <p class="text-white/40">Payin</p> --}}
                        <p class="font-semibold text-white">
                            ₹{{ number_format(optional(auth()->user())->wallet_summary['payin_wallet'], 2) }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Payout Wallet (Hidden Mobile) --}}
            @if ($role == 'admin' || $role == 'user')
                <div class="hidden md:flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-2"
                    title="Payout Wallet">
                    <i class="bi bi-arrow-up-circle text-yellow-400"></i>
                    <div class="text-xs">
                        {{-- <p class="text-white/40">Payout</p> --}}
                        <p class="font-semibold text-white">
                            ₹{{ number_format(optional(auth()->user())->wallet_summary['payout_wallet'] ?? 0, 2) }}
                        </p>
                    </div>
                </div>
            @endif

        </div>

        <div class="relative">
            <button onclick="toggleProfileMenu()"
                class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-white/5 transition text-left">
                <div
                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-fintechCyan to-fintechGreen flex items-center justify-center font-bold text-fintechDark text-sm">
                    @if (auth()->check())
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="hidden sm:block text-xs">
                    <p class="font-bold leading-none text-white/90">
                        @if (auth()->check())
                            {{ Auth::user()->name }}
                        @endif
                    </p>
                    {{-- <p class="text-[10px] text-white/40 mt-0.5">Premium Account</p> --}}
                </div>
                <i class="bi bi-chevron-down text-xs text-white/40 hidden sm:block"></i>
            </button>

            @php
                if (auth()->check() && auth()->user()->role == 'admin') {
                    $route = route('admin.profile');
                } elseif (auth()->check() && auth()->user()->role == 'user') {
                    $route = route('user.user-profile');
                } elseif (auth()->check() && auth()->user()->role == 'verification') {
                    $route = route('admin.profile');
                } elseif (auth()->check() && auth()->user()->role == 'reseller') {
                    $route = route('admin.profile');
                }
            @endphp

            <div id="profileMenu"
                class="hidden absolute right-0 mt-3 w-56 bg-fintechDropdownBg border border-white/10 rounded-2xl shadow-2xl p-2 z-50">
                <a href="{{ $route }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-white/70 hover:text-white hover:bg-white/5 transition">
                    <i class="bi bi-person text-base text-fintechCyan"></i> Profile Config
                </a>
                @if (auth()->check() && auth()->user()->role == 'user')
                    <a href="{{ route('user.oauthuser') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-white/70 hover:text-white hover:bg-white/5 transition">
                        <i class="bi bi-shield-lock text-base text-fintechCyan"></i> API Access Keys
                    </a>
                @endif

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
