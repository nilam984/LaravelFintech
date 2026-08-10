@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- ===================== -->
            <!-- User Detail Card (Left) -->
            <!-- ===================== -->
            <div class="lg:col-span-4 xl:col-span-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">



                    <div
                        class="relative bg-gradient-to-br from-cyan-500 via-cyan-600 to-cyan-700 px-6 pt-7 pb-8 text-center">
                        {{-- Decorative circles --}}
                        <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-white/10"></div>
                        <div class="absolute -bottom-12 -left-12 w-36 h-36 rounded-full bg-white/10"></div>
                        <div class="relative">
                            <div
                                class="w-20 h-20 mx-auto rounded-full bg-white/15 backdrop-blur-md border border-white/30 flex items-center justify-center
                                        text-white text-3xl font-bold shadow-lg">
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>
                            <h2 class="mt-4 text-lg font-semibold text-white">{{ $user->name ?? 'User Name' }}</h2>
                            <p class="text-cyan-100 text-xs mt-1 truncate px-2">{{ $user->email ?? 'user@email.com' }}</p>
                        </div>
                    </div>
                    <!-- Header Banner -->


                    <!-- Body Details -->
                    <div class="p-6 space-y-4 text-sm">
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-2 text-slate-400">
                                <i class="bi bi-phone"></i>
                                <span class="text-sm font-medium">Mobile</span>
                            </div>
                            <span class="text-sm font-semibold text-slate-700">
                                {{ auth()->user()->mobile ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center gap-2 text-slate-400">
                                <i class="bi bi-shield-check"></i>
                                <span class="text-sm font-medium">Status</span>
                            </div>

                            @if (($user->status ?? 1) == 1)
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <hr class="border-gray-100 my-2">

                        


                        <div class="space-y-3">
                            <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400"> Payin
                                            Wallet</p>
                                        <p class="mt-1 text-lg font-bold text-cyan-600">
                                            ₹ {{ number_format($user->payin_wallet ?? 0, 2) }}
                                        </p>
                                    </div>
                                    <div
                                        class="w-9 h-9 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Payout
                                            Wallet</p>
                                        <p class="mt-1 text-lg font-bold text-cyan-600">
                                            ₹ {{ number_format($user->payout_wallet ?? 0, 2) }}
                                        </p>
                                    </div>
                                    <div
                                        class="w-9 h-9 rounded-lg bg-cyan-50 text-cyan-600  flex items-center justify-center">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-xl border border-cyan-100 bg-cyan-50/50 p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p
                                            class="text-[11px] font-semibold  uppercase tracking-wider
                                                  text-slate-400">
                                            Main Wallet
                                        </p>
                                        <p class="mt-1 text-lg font-bold text-cyan-600">
                                             ₹ {{ number_format($user->main_wallet ?? 0, 2) }}
                                        </p>
                                    </div>
                                    <div
                                        class="w-9 h-9 rounded-lg bg-white text-cyan-600 flex items-center justify-center
                                                shadow-sm">
                                        <i class="bi bi-wallet-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- ===================== -->
            <!-- Right Side Content -->
            <!-- ===================== -->
            <div class="lg:col-span-8 xl:col-span-8">

                <!-- Tabs Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-100 bg-gray-50/50 px-4 pt-2">
                        <nav class="flex space-x-6 overflow-x-auto">
                            <button
                                class="tab-btn pb-4 pt-3 text-cyan-600 border-b-2 border-cyan-500 font-medium text-sm whitespace-nowrap transition-colors"
                                data-tab="business">
                                Business Info
                            </button>

                            <button
                                class="tab-btn pb-4 pt-3 text-gray-400 hover:text-gray-600 font-medium text-sm whitespace-nowrap transition-colors"
                                data-tab="bank">
                                Bank Details
                            </button>

                            <button
                                class="tab-btn pb-4 pt-3 text-gray-400 hover:text-gray-600 font-medium text-sm whitespace-nowrap transition-colors"
                                data-tab="api">
                                API Keys
                            </button>

                            <button
                                class="tab-btn pb-4 pt-3 text-gray-400 hover:text-gray-600 font-medium text-sm whitespace-nowrap transition-colors"
                                data-tab="webhook">
                                WebHooks
                            </button>

                            <button
                                class="tab-btn pb-4 pt-3 text-gray-400 hover:text-gray-600 font-medium text-sm whitespace-nowrap transition-colors"
                                data-tab="kycVerification">
                                KYC Verification
                            </button>
                        </nav>
                    </div>

                    <!-- ===================== -->
                    <!-- Business Info Tab -->
                    <!-- ===================== -->
                    <div id="business" class="tab-content p-6 sm:p-8 space-y-8">

                        <div>

                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Business
                                        Name</span>
                                    <p class="text-gray-800 font-medium text-sm">{{ $business->business_name ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Business
                                        Email</span>
                                    <p class="text-gray-800 font-medium text-sm break-all">
                                        {{ $business->business_email ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Business
                                        Phone</span>
                                    <p class="text-gray-800 font-medium text-sm">{{ $business->business_phone ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Business
                                        Type</span>
                                    <p class="text-gray-800 font-medium text-sm">{{ $business->business_type ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Business
                                        Category</span>
                                    <p class="text-gray-800 font-medium text-sm">{{ $business->business_category ?? '-' }}
                                    </p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Website</span>
                                    <p class="text-cyan-600 font-medium text-sm break-all">
                                        {{ $business->website_url ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- KYC Information -->
                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-base font-semibold text-gray-800 mb-4">
                                KYC Information
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">PAN
                                        Number</span>
                                    <p class="text-gray-800 font-mono text-sm">{{ $business->pan ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">GST
                                        Number</span>
                                    <p class="text-gray-800 font-mono text-sm">{{ $business->gst ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Owner
                                        PAN</span>
                                    <p class="text-gray-800 font-mono text-sm">{{ $business->owner_pan ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Owner
                                        Aadhaar</span>
                                    <p class="text-gray-800 font-mono text-sm">{{ $business->owner_aadhar ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Business
                                        PAN Image</span>
                                    <p class="text-gray-800 font-mono text-sm">
                                        @if (!empty($business->pan_image))
                                            <button type="button" class="previewImage text-cyan-600 hover:text-cyan-800"
                                                data-title="Business PAN Image"
                                                data-src="{{ asset('storage/' . $business->pan_image) }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        @endif
                                    </p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Owner
                                        PAN Image</span>
                                    <p class="text-gray-800 font-mono text-sm">
                                        @if (!empty($business->owner_pan_image))
                                            <button type="button" class="previewImage text-cyan-600 hover:text-cyan-800"
                                                data-title="Owner PAN Image"
                                                data-src="{{ asset('storage/' . $business->owner_pan_image) }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        @endif
                                    </p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Aadhaar
                                        Front Image</span>
                                    <p class="text-gray-800 font-mono text-sm">
                                        @if (!empty($business->owner_aadhar_image_front))
                                            <button type="button" class="previewImage text-cyan-600 hover:text-cyan-800"
                                                data-title="Aadhaar Front Image"
                                                data-src="{{ asset('storage/' . $business->owner_aadhar_image_front) }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        @endif
                                    </p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Aadhaar
                                        Back Image</span>
                                    <p class="text-gray-800 font-mono text-sm">
                                        @if (!empty($business->owner_aadhar_image_back))
                                            <button type="button" class="previewImage text-cyan-600 hover:text-cyan-800"
                                                data-title="Aadhaar Back Image"
                                                data-src="{{ asset('storage/' . $business->owner_aadhar_image_back) }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-base font-semibold text-gray-800 mb-4">
                                Address Information
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">City</span>
                                    <p class="text-gray-800 font-medium text-sm">{{ $business->city ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span
                                        class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">State</span>
                                    <p class="text-gray-800 font-medium text-sm">{{ $business->state ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                    <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Pin
                                        Code</span>
                                    <p class="text-gray-800 font-medium text-sm">{{ $business->pin_code ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Full
                                    Address</span>
                                <p class="text-gray-800 font-medium text-sm mt-1">
                                    {{ $business->full_address ?? '-' }}
                                </p>
                            </div>
                        </div>

                    </div>


                    <!-- ===================== -->
                    <!-- Bank Details Tab -->
                    <!-- ===================== -->
                    <div id="bank" class="tab-content hidden p-6 sm:p-8">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Account
                                    Holder</span>
                                <p class="text-gray-800 font-medium text-sm">
                                    {{ $bank->account_holder_name ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Account
                                    Number</span>
                                <p class="text-gray-800 font-mono text-sm">
                                    {{ $bank->account_number ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">IFSC
                                    Code</span>
                                <p class="text-gray-800 font-mono text-sm">
                                    {{ $bank->ifsc_code ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80">
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Bank
                                    Name</span>
                                <p class="text-gray-800 font-medium text-sm">
                                    {{ $bank->bank_name ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80 md:col-span-2">
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Branch
                                    Name</span>
                                <p class="text-gray-800 font-medium text-sm">
                                    {{ $bank->branch_name ?? '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50/60 p-4 rounded-xl border border-gray-100/80 md:col-span-2">
                                <span class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Bank
                                    Doc</span>
                                <p class="text-gray-800 font-medium text-sm">
                                    @if (!empty($bank->bank_docs))
                                        <button type="button" class="previewImage text-cyan-600 hover:text-cyan-800"
                                            data-title="Cancelled Cheque / Passbook"
                                            data-src="{{ asset('storage/' . $bank->bank_docs) }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>



                    <!-- ===================== -->
                    <!-- API Keys Tab (Untouched structure) -->
                    <!-- ===================== -->
                    <div id="api" class="tab-content hidden p-6 sm:p-8">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">
                                Service API Keys
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                API credentials assigned to this user.
                            </p>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <div class="max-h-[420px] overflow-y-auto">
                                <table class="min-w-full">
                                    <thead class="bg-cyan-50 sticky top-0 z-10">
                                        <tr>
                                            <th
                                                class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Service</th>
                                            <th
                                                class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Client Key</th>
                                            <th
                                                class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Secret Key</th>
                                            <th
                                                class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @forelse ($keyDetails as $key)
                                            <tr class="hover:bg-cyan-50/50 transition-colors duration-150">
                                                <td class="px-5 py-4 font-medium text-gray-800 whitespace-nowrap">
                                                    {{ $key->service?->service_name ?? '-' }}
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span class="font-mono text-sm text-gray-700 break-all">
                                                        {{ $key->client_id ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span class="font-mono text-sm text-gray-700 break-all">
                                                        {{ Str::limit($key->client_secret, 30) ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4 text-center">
                                                    @if ($key->status == 1)
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-5 py-10 text-center text-gray-500">
                                                    No API keys found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- ===================== -->
                    <!-- Webhook Tab (Untouched structure) -->
                    <!-- ===================== -->
                    <div id="webhook" class="tab-content hidden p-6 sm:p-8">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">
                                WebHook Details
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                WebHook Details of User.
                            </p>
                        </div>

                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <div class="max-h-[420px] overflow-y-auto">
                                <table class="min-w-full">
                                    <thead class="bg-cyan-50 sticky top-0 z-10">
                                        <tr>
                                            <th
                                                class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Service</th>
                                            <th
                                                class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                URL</th>
                                            <th
                                                class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @forelse ($webhooks as $hook)
                                            <tr class="hover:bg-cyan-50/50 transition-colors duration-150">
                                                <td class="px-5 py-4 font-medium text-gray-800 whitespace-nowrap">
                                                    {{ $hook->service?->service_name ?? '-' }}
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span class="font-mono text-sm text-gray-700 break-all">
                                                        {{ $hook->webhook_url ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4 text-center">
                                                    @if ($hook->status == 1)
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-5 py-10 text-center text-gray-500">
                                                    No webhooks found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <!-- ===================== -->
                    <!-- KYC Verification -->
                    <!-- ===================== -->
                    @if (Auth::user()->role === 'admin')
                        @include('admin.kyc.admin-kyc-card')
                    @elseif (Auth::user()->role === 'verification')
                        @include('admin.kyc.verification-kyc-card')
                    @endif


                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            const tabs = document.querySelectorAll('.tab-btn');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(btn => {
                        btn.classList.remove('border-cyan-500', 'text-cyan-600', 'font-medium');
                        btn.classList.add('text-gray-400');
                    });

                    contents.forEach(content => content.classList.add('hidden'));

                    tab.classList.add('border-cyan-500', 'text-cyan-600', 'font-medium');
                    tab.classList.remove('text-gray-400');

                    document.getElementById(tab.dataset.tab).classList.remove('hidden');
                });
            });
        </script>


        {{-- Admin js for the kyc --}}
        <script>
            $(document).on('click', '.verify-btn', function() {

                let button = $(this);

                let user_id = button.data('user');
                let field = button.data('field');
                let status = button.data('status');
                let remark = null;

                function submitRequest() {

                    $.ajax({

                        url: "{{ route('user.kyc.verify') }}",

                        type: "POST",

                        data: {

                            _token: "{{ csrf_token() }}",

                            user_id: user_id,

                            field: field,

                            status: status,

                            remark: remark

                        },

                        beforeSend: function() {

                            button.prop('disabled', true);

                        },

                        success: function(response) {

                            Swal.fire({

                                icon: 'success',

                                title: 'Success',

                                text: response.message,

                                timer: 1500,

                                showConfirmButton: false

                            }).then(() => {

                                location.reload();

                            });

                        },

                        error: function(xhr) {

                            button.prop('disabled', false);

                            Swal.fire({

                                icon: 'error',

                                title: 'Error',

                                text: xhr.responseJSON?.message ?? 'Something went wrong.'

                            });

                        }

                    });

                }

                // Final Approval
                if (status === 'approved') {

                    Swal.fire({

                        title: 'Final KYC Approval?',

                        html: `
                <p class="text-sm text-gray-600">
                    You are about to <b>finally approve</b> this KYC field.
                    <br><br>
                    This action will mark this field as approved by Admin.
                </p>
            `,

                        icon: 'question',

                        showCancelButton: true,

                        confirmButtonText: 'Yes, Approve',

                        cancelButtonText: 'Cancel',

                        confirmButtonColor: '#16a34a'

                    }).then((result) => {

                        if (result.isConfirmed) {

                            submitRequest();

                        }

                    });

                }

                // Final Reject
                else {

                    Swal.fire({

                        title: 'Reject KYC Field',

                        input: 'textarea',

                        inputLabel: 'Reason for rejection',

                        inputPlaceholder: 'Enter rejection reason...',

                        inputAttributes: {
                            required: true
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Reject',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#dc2626',
                        preConfirm: (value) => {
                            if (!value) {
                                Swal.showValidationMessage('Remark is required.');
                            }
                            return value;
                        }

                    }).then((result) => {
                        if (result.isConfirmed) {
                            remark = result.value;
                            submitRequest();
                        }
                    });
                }
            });
        </script>

        {{-- Verification js for the kyc --}}
        <script>
            $(document).on('click', '.verify-btn', function() {

                let button = $(this);

                let user_id = button.data('user');
                let field = button.data('field');
                let status = button.data('status');
                let remark = null;

                function submitRequest() {

                    $.ajax({

                        url: "{{ route('user.kyc.verify') }}",

                        type: "POST",

                        data: {

                            _token: "{{ csrf_token() }}",

                            user_id: user_id,

                            field: field,

                            status: status,

                            remark: remark

                        },

                        beforeSend: function() {

                            button.prop('disabled', true);

                        },

                        success: function(response) {

                            Swal.fire({

                                icon: 'success',

                                title: 'Success',

                                text: response.message,

                                timer: 1500,

                                showConfirmButton: false

                            }).then(() => {
                                location.reload();
                            });
                        },

                        error: function(xhr) {
                            button.prop('disabled', false);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message ?? 'Something went wrong.'
                            });
                        }
                    });
                }

                if (status == 'approved') {
                    Swal.fire({
                        title: 'Approve this field?',
                        text: 'The field will move to Admin for final approval.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Approve',
                        confirmButtonColor: '#16a34a',
                        didOpen: () => {
                            document.body.classList.remove('swal2-height-auto');
                        }

                    }).then((result) => {
                        if (result.isConfirmed) {
                            submitRequest();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Reject Field',
                        input: 'textarea',
                        inputPlaceholder: 'Enter rejection reason',
                        inputLabel: 'Remark',
                        showCancelButton: true,
                        confirmButtonText: 'Reject',
                        confirmButtonColor: '#dc2626',
                        didOpen: () => {
                            document.body.classList.remove('swal2-height-auto');
                        },
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Remark is required';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            remark = result.value;
                            submitRequest();
                        }
                    });
                }
            });
        </script>

    @endsection
@endsection
