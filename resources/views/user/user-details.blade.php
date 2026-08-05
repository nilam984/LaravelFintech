<div class="bg-white rounded-2xl  overflow-hidden">
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center gap-4 p-4  rounded-xl hover:shadow-md transition">
                <div class="w-12 h-12 rounded-lg bg-cyan-100 flex items-center justify-center">
                    <i class="bi bi-person-fill text-cyan-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Full Name</p>
                    <h4 class="font-semibold text-gray-800">
                        {{ auth()->user()->name ?? 'N/A' }}
                    </h4>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4  rounded-xl hover:shadow-md transition">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="bi bi-envelope-fill text-blue-600 text-xl"></i>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Email Address</p>
                    <h4 class="font-semibold text-gray-800 break-all">
                        {{ auth()->user()->email ?? 'N/A' }}
                    </h4>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4  rounded-xl hover:shadow-md transition">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <i class="bi bi-phone-fill text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mobile Number</p>
                    <h4 class="font-semibold text-gray-800">
                        {{ auth()->user()->mobile ?? 'N/A' }}
                    </h4>
                </div>
            </div>

            @php
                $role = false;
                if (Auth::check() && Auth::user()->role === 'admin') {
                    $role = true;
                }
            @endphp

            @if ($role)
                <div class="flex items-center gap-4 p-4  rounded-xl hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="bi bi-phone-fill text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Main Wallet</p>
                        <h4 class="font-semibold text-gray-800">
                            {{ auth()->user()->main_wallet ?? 'N/A' }}
                        </h4>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4  rounded-xl hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="bi bi-cash-stack text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Payouts</p>
                        <h4 class="font-semibold text-gray-800">
                            {{ auth()->user()->payout_wallet ?? 'N/A' }}
                        </h4>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
