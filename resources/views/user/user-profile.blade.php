@extends('layouts.app')
@section('title', 'User Profile')
@section('content')
    <div class="min-h-screen bg-slate-50 py-6">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Profile</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Manage your profile and account information.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-[260px_minmax(0,1fr)] gap-6">
                <div>
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        {{-- Profile Header --}}
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
                                <h2 class="mt-4 text-lg font-semibold text-white">{{ auth()->user()->name ?? 'N/A' }}</h2>
                                <p class="text-cyan-100 text-xs mt-1 truncate px-2">{{ auth()->user()->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="p-5">
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
                            <div class="border-t border-slate-100 my-4"></div>
                            <div class="space-y-3">
                                <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                                                Payin Wallet</p>
                                            <p class="mt-1 text-lg font-bold text-cyan-600">
                                                ₹ {{ number_format(auth()->user()->payin_wallet ?? 0, 2) }}
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
                                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                                                Payout Wallet</p>
                                            <p class="mt-1 text-lg font-bold text-cyan-600">
                                                ₹ {{ number_format(auth()->user()->payout_wallet ?? 0, 2) }}
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
                                                ₹ {{ number_format(auth()->user()->main_wallet ?? 0, 2) }}
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
                <div class="min-w-0">
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="border-b border-slate-100">
                            <div class="flex items-center gap-1 overflow-x-auto px-4 sm:px-6 scrollbar-hide">
                                <button type="button"
                                    class="profile-tab active whitespace-nowrap flex items-center gap-2 px-4 py-4
                                        text-sm font-medium border-b-2 border-cyan-500 text-cyan-600 transition-all duration-200"
                                    data-tab="business-details"><span>Business Info</span>
                                </button>
                                <button type="button"
                                    class="profile-tab whitespace-nowrap flex items-center gap-2 px-4 py-4
                                        text-sm font-medium border-b-2 border-transparent text-slate-400
                                        hover:text-cyan-600 transition-all duration-200"
                                    data-tab="bank-details">
                                    <span>Bank Details</span>
                                </button>
                                <button type="button"
                                    class="profile-tab whitespace-nowrap flex items-center gap-2 px-4 py-4
                                        text-sm font-medium border-b-2 border-transparent text-slate-400
                                        hover:text-cyan-600 transition-all duration-200"
                                    data-tab="user-onboarding">
                                    <span>User Onboarding</span>
                                </button>

                                <button type="button"
                                    class="profile-tab whitespace-nowrap flex items-center gap-2 px-4 py-4
                                        text-sm font-medium border-b-2 border-transparent text-slate-400
                                        hover:text-cyan-600 transition-all duration-200"
                                    data-tab="webhook-url">
                                    <span>WebHooks</span>
                                </button>
                                <button type="button"
                                    class="profile-tab whitespace-nowrap flex items-center gap-2 px-4 py-4
                                        text-sm font-medium border-b-2 border-transparent text-slate-400
                                        hover:text-cyan-600 transition-all duration-200"
                                    data-tab="kyc-details">
                                    <span>KYC Verification</span>
                                </button>
                            </div>
                        </div>

                        <div class="p-5 sm:p-6 lg:p-7">
                            <div id="business-details" class="tab-content">
                                @include('user.business-details')
                            </div>
                            <div id="bank-details" class="tab-content hidden">
                                @include('user.bank-details')
                            </div>
                            <div id="webhook-url" class="tab-content hidden">
                                @include('user.webhook-url')
                            </div>
                            <div id="kyc-details" class="tab-content hidden">
                                @include('user.kyc-details')
                            </div>

                            <div id="user-onboarding" class="tab-content hidden">
                                <form id="profileForm" action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div
                                        class="px-5 py-4 bg-amber-300 border-l-4 border-amber-500 my-4 rounded-r-lg shadow-sm transition-all duration-300 hover:shadow-md animate-pulse">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 text-amber-500">
                                                <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-amber-800 tracking-wide">
                                                    Important Notice
                                                </p>
                                                <p class="text-xs text-amber-800 mt-0.5">
                                                    You will not be able to change any fields after KYC is approved.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-white rounded-2xl shadow-md mb-6">
                                        <div class="px-5 py-3 border-b border-gray-100">
                                            <h3 class="text-lg font-bold text-gray-700">Business Details</h3>
                                        </div>
                                        <div class="p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Business Name</label>
                                                <input type="text" name="business_name"
                                                    placeholder="e.g. Acme Corporation"
                                                    value="{{ old('business_name', $business->business_name ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Business Email</label>
                                                <input type="email" name="business_email"
                                                    placeholder="e.g. contact@acme.com"
                                                    value="{{ old('business_email', $business->business_email ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Business Phone</label>
                                                <input type="text" name="business_phone"
                                                    placeholder="e.g. +91 98765 43210"
                                                    value="{{ old('business_phone', $business->business_phone ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Business Type</label>
                                                <select name="business_type"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                                    <option value="">Select Business Type</option>
                                                    <option value="Proprietorship"
                                                        {{ old('business_type', $business->business_type ?? '') == 'Proprietorship' ? 'selected' : '' }}>
                                                        Proprietorship
                                                    </option>
                                                    <option value="Partnership"
                                                        {{ old('business_type', $business->business_type ?? '') == 'Partnership' ? 'selected' : '' }}>
                                                        Partnership
                                                    </option>
                                                    <option value="Private Limited"
                                                        {{ old('business_type', $business->business_type ?? '') == 'Private Limited' ? 'selected' : '' }}>
                                                        Private Limited
                                                    </option>
                                                    <option value="LLP"
                                                        {{ old('business_type', $business->business_type ?? '') == 'LLP' ? 'selected' : '' }}>
                                                        LLP
                                                    </option>
                                                </select>
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Business Category</label>
                                                <input type="text" name="business_category"
                                                    placeholder="e.g. Retail, E-commerce, IT"
                                                    value="{{ old('business_category', $business->business_category ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Website URL</label>
                                                <input type="url" name="website_url"
                                                    placeholder="e.g. https://www.acme.com"
                                                    value="{{ old('website_url', $business->website_url ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-white rounded-2xl shadow-md mb-6">
                                        <div class="px-5 py-3 border-b border-gray-100">
                                            <h3 class="text-lg font-bold text-gray-700">KYC Details</h3>
                                        </div>
                                        <div class="p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Business PAN
                                                    Number</label>
                                                <input type="text" name="pan"
                                                    placeholder="10-digit PAN (e.g. ABCDE1234F)"
                                                    value="{{ old('pan', $business->pan ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">GST Number</label>
                                                <input type="text" name="gst" placeholder="15-digit GSTIN"
                                                    value="{{ old('gst', $business->gst ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Owner PAN</label>
                                                <input type="text" name="owner_pan" placeholder="Owner's 10-digit PAN"
                                                    value="{{ old('owner_pan', $business->owner_pan ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Owner Aadhaar
                                                    Number</label>
                                                <input type="text" name="owner_aadhar"
                                                    placeholder="12-digit Aadhaar Number"
                                                    value="{{ old('owner_aadhar', $business->owner_aadhar ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label class="text-sm font-medium text-gray-600">
                                                        Business PAN Image
                                                    </label>
                                                    @if (!empty($business->pan_image))
                                                        <button type="button"
                                                            class="previewImage text-cyan-600 hover:text-cyan-800"
                                                            data-title="Business PAN Image"
                                                            data-src="{{ asset('storage/' . $business->pan_image) }}">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <input type="file" name="pan_image"
                                                    class="w-full border rounded-lg p-1.5 text-sm
                                            file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold
                                            file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                                            </div>
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="owner_pan_image"
                                                        class="text-sm font-medium text-gray-600">
                                                        Owner PAN Image
                                                    </label>
                                                    @if (!empty($business->owner_pan_image))
                                                        <button type="button"
                                                            class="previewImage text-cyan-600 hover:text-cyan-800"
                                                            data-title="Owner PAN Image"
                                                            data-src="{{ asset('storage/' . $business->owner_pan_image) }}">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <input id="owner_pan_image" type="file" name="owner_pan_image"
                                                    class="w-full border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold
                                                  file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                                            </div>
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="owner_aadhar_image_front"
                                                        class="text-sm font-medium text-gray-600">
                                                        Aadhaar Front Image
                                                    </label>
                                                    @if (!empty($business->owner_aadhar_image_front))
                                                        <button type="button"
                                                            class="previewImage text-cyan-600 hover:text-cyan-800"
                                                            data-title="Aadhaar Front Image"
                                                            data-src="{{ asset('storage/' . $business->owner_aadhar_image_front) }}">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <input id="owner_aadhar_image_front" type="file"
                                                    name="owner_aadhar_image_front"
                                                    class="w-full border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700
                                                    hover:file:bg-cyan-100">
                                            </div>
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="owner_aadhar_image_back"
                                                        class="text-sm font-medium text-gray-600">
                                                        Aadhaar Back Image
                                                    </label>
                                                    @if (!empty($business->owner_aadhar_image_back))
                                                        <button type="button"
                                                            class="previewImage text-cyan-600 hover:text-cyan-800"
                                                            data-title="Aadhaar Back Image"
                                                            data-src="{{ asset('storage/' . $business->owner_aadhar_image_back) }}">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <input id="owner_aadhar_image_back" type="file"
                                                    name="owner_aadhar_image_back"
                                                    class="w-full border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                                            </div>
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="inside_image"
                                                        class="text-sm font-medium text-gray-600">
                                                        Inside Image
                                                    </label>
                                                    @if (!empty($business->inside_image))
                                                        <button type="button"
                                                            class="previewImage text-cyan-600 hover:text-cyan-800"
                                                            data-title="Inside Image"
                                                            data-src="{{ asset('storage/' . $business->inside_image) }}">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <input id="inside_image" type="file" name="inside_image"
                                                    class="w-full border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                                            </div>
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="outside_image"
                                                        class="text-sm font-medium text-gray-600">
                                                        Outside Image
                                                    </label>
                                                    @if (!empty($business->outside_image))
                                                        <button type="button"
                                                            class="previewImage text-cyan-600 hover:text-cyan-800"
                                                            data-title="Outside Image"
                                                            data-src="{{ asset('storage/' . $business->outside_image) }}">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <input id="outside_image" type="file" name="outside_image"
                                                    class="w-full border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                                            </div>
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="signed_moa_image"
                                                        class="text-sm font-medium text-gray-600">
                                                        Signed MOA Image
                                                    </label>
                                                    @if (!empty($business->signed_moa_image))
                                                        <button type="button"
                                                            class="previewImage text-cyan-600 hover:text-cyan-800"
                                                            data-title="Signed MOA Image"
                                                            data-src="{{ asset('storage/' . $business->signed_moa_image) }}">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <input id="signed_moa_image" type="file" name="signed_moa_image"
                                                    class="w-full border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                                            </div>
                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="signed_aoa_image"
                                                        class="text-sm font-medium text-gray-600">
                                                        Signed AOA Image
                                                    </label>
                                                    @if (!empty($business->signed_aoa_image))
                                                        <button type="button"
                                                            class="previewImage text-cyan-600 hover:text-cyan-800"
                                                            data-title="Signed AOA Image"
                                                            data-src="{{ asset('storage/' . $business->signed_aoa_image) }}">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <input id="signed_aoa_image" type="file" name="signed_aoa_image"
                                                    class="w-full border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                                            </div>


                                        </div>
                                    </div>

                                    <div class="bg-white rounded-2xl shadow-md mb-6">
                                        <div class="px-5 py-3 border-b border-gray-100">
                                            <h3 class="text-lg font-bold text-gray-700">Address Details</h3>
                                        </div>
                                        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4">
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">City</label>
                                                <input type="text" name="city" placeholder="e.g. Mumbai"
                                                    value="{{ old('city', $business->city ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-gray-600">State</label>
                                                <input type="text" name="state" placeholder="e.g. Maharashtra"
                                                    value="{{ old('state', $business->state ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Pin Code</label>
                                                <input type="text" name="pin_code" placeholder="6-digit ZIP/Pin code"
                                                    value="{{ old('pin_code', $business->pin_code ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>

                                            <div class="md:col-span-3">
                                                <label class="text-sm font-medium text-gray-600">Full Address</label>
                                                <textarea name="full_address" rows="2" class="w-full mt-1 border rounded-lg px-3 py-2 text-sm">{{ old('full_address', $business->full_address ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-white rounded-2xl shadow-md mb-6">
                                        <div class="px-5 py-3 border-b border-gray-100">
                                            <h3 class="text-lg font-bold text-gray-700">Bank Details</h3>
                                        </div>
                                        <div class="p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Bank Name</label>
                                                <input type="text" name="bank_name" placeholder="e.g. HDFC Bank"
                                                    value="{{ old('bank_name', $bank->bank_name ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Account Holder
                                                    Name</label>
                                                <input type="text" name="account_holder_name"
                                                    placeholder="Name as per bank records"
                                                    value="{{ old('account_holder_name', $bank->account_holder_name ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Account Number</label>
                                                <input type="text" name="account_number"
                                                    placeholder="Enter bank account number"
                                                    value="{{ old('account_number', $bank->account_number ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-gray-600">IFSC Code</label>
                                                <input type="text" name="ifsc_code"
                                                    placeholder="11-digit IFSC (e.g. HDFC0001234)"
                                                    value="{{ old('ifsc_code', $bank->ifsc_code ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-gray-600">Branch Name</label>
                                                <input type="text" name="branch_name"
                                                    placeholder="e.g. Connaught Place"
                                                    value="{{ old('branch_name', $bank->branch_name ?? '') }}"
                                                    class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                            </div>

                                            <div>
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="bank_docs" class="text-sm font-medium text-gray-600">
                                                        Cancelled Cheque / Passbook
                                                    </label>
                                                    @if (!empty($bank->bank_docs))
                                                        <button type="button"
                                                            class="previewImage text-cyan-600 hover:text-cyan-800"
                                                            data-title="Cancelled Cheque / Passbook"
                                                            data-src="{{ asset('storage/' . $bank->bank_docs) }}">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <input id="bank_docs" type="file" name="bank_docs"
                                                    class="w-full border rounded-lg p-1.5 text-sm
                                    file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700
                                hover:file:bg-cyan-100">
                                            </div>
                                        </div>
                                    </div>


                                    @if ($business?->kyc_status !== 'approved')
                                        <div class="mt-6 flex justify-end">
                                            <button type="submit"
                                                class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-md text-sm transition-colors duration-200">
                                                Save Profile
                                            </button>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $('.profile-tab').on('click', function() {
            let tab = $(this).data('tab');
            $('.profile-tab')
                .removeClass('text-cyan-600 border-cyan-500')
                .addClass('text-slate-400 border-transparent');
            $(this)
                .removeClass('text-slate-400 border-transparent')
                .addClass('text-cyan-600 border-cyan-500');
            $('.tab-content').addClass('hidden');
            $('#' + tab).removeClass('hidden');

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#profileForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('businessinfo.profile') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.errorText').remove();
                        $('button[type=submit]')
                            .prop('disabled', true)
                            .text('Please Wait...');
                    },
                    success: function(response) {
                        $('button[type=submit]')
                            .prop('disabled', false).text('Save Profile');
                        if (response.status) {
                            ToastEngine.show(response.message, "success");
                        } else {
                            ToastEngine.show(response.message, "error");
                        }
                    },
                    error: function(xhr) {
                        $('button[type=submit]')
                            .prop('disabled', false)
                            .text('Save Profile');
                        if (xhr.status == 422) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('[name="' + key + '"]').after(
                                    '<span class="text-red-500 errorText">' + value[
                                        0] +
                                    '</span>');
                            });
                        } else {
                            ToastEngine.show(xhr.responseJSON.message, "error");
                        }
                    }
                });
            });
        });
    </script>

    {{-- webhook Url Script code --}}
    <script>
        $(document).on('submit', '#webhookForm', function(e) {
            e.preventDefault();
            let form = $(this);
            let id = $('#webhook_id').val();
            let url = id ? "/user/webhookurl/update/" + id : "{{ route('webhookurl.store') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: form.serialize(),
                beforeSend: function() {
                    form.find('button[type="submit"]')
                        .prop('disabled', true)
                        .text(id ? 'Updating...' : 'Saving...');
                },
                success: function(response) {
                    form.find('button[type="submit"]')
                        .prop('disabled', false)
                        .text('Save Webhook');
                    if (response.status) {
                        ToastEngine.show(response.message, "success");
                        form.trigger('reset');
                        $('#webhook_id').val('');
                        $('#webhookModal h3').text('Add Webhook URL');
                        form.find('button[type="submit"]').text('Save Webhook');
                        closeWebhookModal();
                        $('#webhookTable').DataTable().ajax.reload(null, false);
                    } else {
                        ToastEngine.show(response.message, "error");
                    }
                },

                error: function(xhr) {
                    form.find('button[type="submit"]')
                        .prop('disabled', false)
                        .text('Save Webhook');
                    $('.text-danger').remove();
                    if (xhr.status == 422) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('[name="' + key + '"]').after(
                                '<span class="text-danger text-red-500 text-sm">' + value[
                                    0] + '</span>'
                            );
                        });
                    } else {
                        let message = "Something went wrong.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        ToastEngine.show(message, "error");
                    }
                }
            });
        });
        $(document).on('click', '.editWebhook', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('webhookurl.edit', ':id') }}".replace(':id', id),
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        $('#webhook_id').val(response.data.id);
                        $('[name="service_id"]').val(response.data.service_id);
                        $('[name="webhook_url"]').val(response.data.webhook_url);
                        $('[name="status"]').val(response.data.status);
                        $('#webhookModal h3').text('Update Webhook');
                        $('#webhookForm button[type="submit"]').text('Update Webhook');
                        $('#webhookModal').removeClass('hidden').addClass('flex');
                    }
                }
            });

        });
        $('#webhookTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('datatable', 'webHookUrls') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.table = "webHookUrls";
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'service.service_name',
                    name: 'service.service_name'
                },
                {
                    data: 'webhook_url',
                    name: 'webhook_url'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        return data == 1 ?
                            '<span class="px-2 py-1 rounded-full bg-green-100 text-green-700">Active</span>' :
                            '<span class="px-2 py-1 rounded-full bg-red-100 text-red-700">Inactive</span>';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {

                        console.log(row);

                        return `
                        <button
                            class="editWebhook bg-yellow-500 text-white px-3 py-2 rounded"
                            data-id="${row.id}">
                            <i class="bi bi-pencil"></i>
                        </button>
                    `;
                    }
                }
            ]
        });

        function openWebhookModal() {
            $('#webhookForm')[0].reset();
            $('#webhook_id').val('');
            $('#webhookModal h3').text('Add Webhook URL');
            $('#webhookForm button[type="submit"]').text('Save Webhook');
            $('#webhookModal').removeClass('hidden').addClass('flex');
        }

        function closeWebhookModal() {
            const modal = document.getElementById('webhookModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
        document.getElementById('webhookModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeWebhookModal();
            }
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeWebhookModal();
            }
        });
    </script>

    {{-- Raise Request for the bank updation --}}
    <script>
        document.getElementById('requestBankUpdateBtn')?.addEventListener('click', function() {
            Swal.fire({
                title: 'Request Bank Updation',
                text: 'Please provide a remark/reason why you want to change your bank details:',
                input: 'textarea',
                inputPlaceholder: 'Type your reason here...',
                inputAttributes: {
                    'aria-label': 'Type your reason here'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#06B6D4',
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write a remark!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('raise.request.bank.updation') }}",
                        type: 'POST',
                        data: {
                            remark: result.value,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {

                            if (response.status) {
                                ToastEngine.show(response.message, "success");
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else {
                                ToastEngine.show(response.message, "error");
                            }
                        },
                        error: function(xhr) {
                            ToastEngine.show(xhr.responseJSON?.message ||
                                'Something went wrong. Please try again.', "error");
                        }
                    });
                }
            });
        });
    </script>
@endsection
@endsection
