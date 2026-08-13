<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl bg-white border border-gray-100 shadow-sm">
        @php
            $user = auth()->user();
            $isAdmin = auth()->check() && $user->role === 'admin';

            $mainWallet = (float) ($user->main_wallet ?? 0);
            $payoutWallet = (float) ($user->payout_wallet ?? 0);
        @endphp
        @if ($isAdmin)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <i class="bi bi-wallet2 text-emerald-600"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-800">Wallet Information</h3>
                            <p class="text-xs text-gray-400">Current wallet balances</p>
                        </div>
                    </div>
                    <span class="text-xs font-medium text-gray-400">Available Balance</span>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600
                        p-5 text-white shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="absolute -right-8 -top-8 w-28 h-28 rounded-full bg-white/10">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center">
                                        <i class="bi bi-wallet2 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-cyan-100 text-xs uppercase tracking-wider"> Main Wallet</p>
                                        <p class="text-xs text-white/70 mt-0.5">Primary balance</p>
                                    </div>
                                </div>
                                <i class="bi bi-arrow-up-right text-white/70"></i>
                            </div>
                            <div class="mt-6">
                                <p class="text-xs text-cyan-100 mb-1">Available Balance</p>
                                <p class="text-2xl font-bold">₹ {{ number_format($mainWallet, 2) }}</p>
                            </div>
                        </div>

                    </div>
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600
                        p-5 text-white shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="absolute -right-8 -top-8 w-28 h-28 rounded-full bg-white/10"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center">
                                        <i class="bi bi-cash-stack text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-emerald-100 text-xs uppercase tracking-wider">Payout Wallet</p>
                                        <p class="text-xs text-white/70 mt-0.5">Payout balance</p>
                                    </div>
                                </div>
                                <i class="bi bi-arrow-up-right text-white/70"></i>
                            </div>


                            {{-- Balance --}}
                            <div class="mt-6">
                                <p class="text-xs text-emerald-100 mb-1">
                                    Available Balance
                                </p>
                                <p class="text-2xl font-bold">
                                    ₹ {{ number_format($payoutWallet, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-cyan-50 flex items-center justify-center">
                <i class="bi bi-person-lines-fill text-cyan-600"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-800">Personal Information</h3>
                <p class="text-xs text-gray-400">Your basic account information</p>
            </div>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100
                bg-gray-50/50 hover:bg-cyan-50/50 hover:border-cyan-100 transition-all duration-300">
                <div class="w-12 h-12 shrink-0 rounded-xl bg-cyan-100flex items-center justify-center">
                    <i class="bi bi-envelope-fill text-cyan-600 text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                        Email Address
                    </p>
                    <h4 class="mt-1 font-semibold text-gray-800 break-all">
                        {{ $user->email ?? 'N/A' }}
                    </h4>
                </div>
            </div>
            <div class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100 bg-gray-50/50 hover:bg-green-50/50 hover:border-green-100 transition-all duration-300">
                <div class="w-12 h-12 shrink-0 rounded-xl bg-green-100 flex items-center justify-center">
                    <i class="bi bi-phone-fill text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Mobile Number</p>
                    <h4 class="mt-1 font-semibold text-gray-800">{{ $user->mobile ?? 'N/A' }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl border border-gray-100 p-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i class="bi bi-shield-check text-blue-600 text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800"> Account Status</p>
                    <p class="text-xs text-gray-500 mt-0.5">Your account is protected with secure access.</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="font-medium text-emerald-600">
                    {{ ($user->status ?? 1) == 1 ? 'Account Active' : 'Account Inactive' }}
                </span>
            </div>
        </div>
    </div>
</div>