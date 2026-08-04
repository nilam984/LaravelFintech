@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- ===================== -->
            <!-- User Detail Card (Left) -->
            <!-- ===================== -->
            <div class="lg:col-span-4 xl:col-span-3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">

                    <!-- Header Banner -->
                    <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 p-6 text-white text-center">
                        <div
                            class="w-20 h-20 mx-auto rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white text-3xl font-bold shadow-inner">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>

                        <h2 class="mt-4 text-lg font-semibold tracking-wide">
                            {{ $user->name ?? 'User Name' }}
                        </h2>

                        <p class="text-cyan-100 text-xs mt-1 truncate px-2">
                            {{ $user->email ?? 'user@email.com' }}
                        </p>
                    </div>

                    <!-- Body Details -->
                    <div class="p-6 space-y-4 text-sm">
                        <div class="flex justify-between items-center py-1">
                            <span class="text-gray-400 font-medium">Mobile</span>
                            <span class="text-gray-700 font-medium">
                                {{ $user->mobile ?? '-' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-1">
                            <span class="text-gray-400 font-medium">Status</span>
                            <span
                                class="px-2.5 py-0.5 rounded-full text-xs font-semibold
                                {{ ($user->status ?? 1) == 1 ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                {{ ($user->status ?? 1) == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <hr class="border-gray-100 my-2">

                        <div class="space-y-3">
                            <div class="bg-gray-50/70 p-3 rounded-xl border border-gray-100/80">
                                <span class="block text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Payin
                                    Wallet</span>
                                <span class="font-semibold text-cyan-600 text-base break-all block">
                                    ₹ {{ number_format($user->payin_wallet ?? 0, 2) }}
                                </span>
                            </div>

                            <div class="bg-gray-50/70 p-3 rounded-xl border border-gray-100/80">
                                <span class="block text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Payout
                                    Wallet</span>
                                <span class="font-semibold text-cyan-600 text-base break-all block">
                                    ₹ {{ number_format($user->payout_wallet ?? 0, 2) }}
                                </span>
                            </div>

                            <div class="bg-gray-50/70 p-3 rounded-xl border border-gray-100/80">
                                <span class="block text-gray-400 text-xs font-medium uppercase tracking-wider mb-1">Main
                                    Wallet</span>
                                <span class="font-semibold text-cyan-600 text-base break-all block">
                                    ₹ {{ number_format($user->main_wallet ?? 0, 2) }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- ===================== -->
            <!-- Right Side Content -->
            <!-- ===================== -->
            <div class="lg:col-span-8 xl:col-span-9">

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
                    <div id="kycVerification" class="tab-content hidden p-6 sm:p-8">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">
                                KYC Verification
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Manage and update the user's KYC verification status.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

                            {{-- Header --}}
                            <div class="p-6 border-b border-gray-100 flex items-center justify-between">

                                <div>
                                    <h3 class="text-base font-semibold text-gray-800">
                                        KYC Verification
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Review and verify user's submitted KYC documents.
                                    </p>
                                </div>


                                @php
                                    $kycStatus = $user->businessInfo?->kyc_status ?? 'pending';
                                @endphp


                                <div>
                                    @if ($kycStatus === 'approved')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full 
                    text-xs font-semibold bg-green-100 text-green-700">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Approved
                                        </span>
                                    @elseif($kycStatus === 'verification_rejected' || $kycStatus === 'admin_rejected')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full 
                    text-xs font-semibold bg-red-100 text-red-700">
                                            <i class="bi bi-x-circle-fill"></i>
                                            Rejected
                                        </span>
                                    @elseif($kycStatus === 'verification_approved')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full 
                    text-xs font-semibold bg-blue-100 text-blue-700">
                                            <i class="bi bi-hourglass-split"></i>
                                            Waiting Admin
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full 
                    text-xs font-semibold bg-yellow-100 text-yellow-700">
                                            <i class="bi bi-clock"></i>
                                            Pending
                                        </span>
                                    @endif
                                </div>

                            </div>



                            {{-- KYC Fields --}}
                            <div class="p-6 space-y-4">


                                @foreach ($kycFields as $key => $field)
                                    @php

                                        $businessInfo = $user->businessInfo;

                                        $value = $businessInfo?->$key;

                                        $verification = $businessInfo?->kyc_verification_data[$key]['verification'] ?? [
                                            'status' => 'pending',
                                            'remark' => null,
                                        ];

                                    @endphp



                                    <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-5">


                                        <div class="flex justify-between gap-4">


                                            {{-- Left --}}
                                            <div class="flex-1">


                                                <div class="flex items-center gap-2">

                                                    <h4 class="text-sm font-semibold text-gray-800">
                                                        {{ $field['label'] }}
                                                    </h4>


                                                    @if ($field['required'])
                                                        <span class="text-red-500 text-xs">
                                                            Required
                                                        </span>
                                                    @endif

                                                </div>



                                                <div class="mt-3">


                                                    @if ($field['type'] === 'file')
                                                        @if ($value)
                                                            <a href="{{ asset($value) }}" target="_blank"
                                                                class="inline-flex items-center gap-2 
                                       text-sm text-blue-600 hover:text-blue-800">

                                                                <i class="bi bi-file-earmark-text"></i>
                                                                View Document

                                                            </a>
                                                        @else
                                                            <span class="text-sm text-gray-400">
                                                                Document not uploaded
                                                            </span>
                                                        @endif
                                                    @else
                                                        <p class="text-sm text-gray-600">
                                                            {{ $value ?: '-' }}
                                                        </p>
                                                    @endif


                                                </div>



                                                @if ($verification['remark'])
                                                    <div class="mt-3 p-3 rounded-lg bg-red-50 text-sm text-red-700">

                                                        <span class="font-medium">
                                                            Remark:
                                                        </span>

                                                        {{ $verification['remark'] }}

                                                    </div>
                                                @endif


                                            </div>




                                            {{-- Right --}}
                                            <div class="flex flex-col items-end gap-3">


                                                @if ($verification['status'] === 'approved')
                                                    <span
                                                        class="px-3 py-1 rounded-full text-xs font-medium
                                bg-green-100 text-green-700">

                                                        Approved

                                                    </span>
                                                @elseif($verification['status'] === 'rejected')
                                                    <span
                                                        class="px-3 py-1 rounded-full text-xs font-medium
                                bg-red-100 text-red-700">

                                                        Rejected

                                                    </span>
                                                @else
                                                    <span
                                                        class="px-3 py-1 rounded-full text-xs font-medium
                                bg-yellow-100 text-yellow-700">

                                                        Pending

                                                    </span>
                                                @endif



                                                @if ($verification['status'] !== 'approved')
                                                    <div class="flex gap-2">


                                                        <button
                                                            class="verify-btn px-3 py-1.5 rounded-lg
                                    text-xs font-medium
                                    bg-green-600 text-white hover:bg-green-700"
                                                            data-field="{{ $key }}" data-status="approved">

                                                            Approve

                                                        </button>


                                                        <button
                                                            class="verify-btn px-3 py-1.5 rounded-lg
                                    text-xs font-medium
                                    bg-red-600 text-white hover:bg-red-700"
                                                            data-field="{{ $key }}" data-status="rejected">

                                                            Reject

                                                        </button>


                                                    </div>
                                                @endif


                                            </div>


                                        </div>


                                    </div>
                                @endforeach


                            </div>

                        </div>
                    </div>

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
    @endsection
@endsection
