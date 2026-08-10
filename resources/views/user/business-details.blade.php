<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <i class="bi bi-building text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Business Information</h3>
                    <p class="text-xs text-slate-400">Registered business details </p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Business Name</p>
                    <h5 class="font-semibold text-slate-800 break-words">
                        {{ $business->business_name ?? 'N/A' }}
                    </h5>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Business Email</p>
                    <h5 class="font-semibold text-slate-800 break-all">
                        {{ $business->business_email ?? 'N/A' }}
                    </h5>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Business Phone</p>
                    <h5 class="font-semibold text-slate-800">
                        {{ $business->business_phone ?? 'N/A' }}
                    </h5>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Business Type</p>
                    <h5 class="font-semibold text-slate-800">
                        {{ $business->business_type ?? 'N/A' }}
                    </h5>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Business Category</p>
                    <h5 class="font-semibold text-slate-800 break-words">
                        {{ $business->business_category ?? 'N/A' }}
                    </h5>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Website URL</p>
                    @if (!empty($business->website_url))
                        <a href="{{ $business->website_url }}"  target="_blank" class="font-semibold text-cyan-600 hover:text-cyan-700 break-all">
                            {{ $business->website_url }}
                        </a>
                    @else
                        <h5 class="font-semibold text-slate-800">N/A</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <i class="bi bi-shield-check text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">KYC Information</h3>
                    <p class="text-xs text-slate-400">Business and owner verification details</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1"> Business PAN</p>
                    <h5 class="font-semibold text-slate-800">{{ $business->pan ?? 'N/A' }}</h5>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1">GST Number</p>
                    <h5 class="font-semibold text-slate-800">{{ $business->gst ?? 'N/A' }}</h5>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1"> Owner PAN</p>
                    <h5 class="font-semibold text-slate-800"> {{ $business->owner_pan ?? 'N/A' }}</h5>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1"> Owner Aadhaar</p>
                    <h5 class="font-semibold text-slate-800">{{ $business->owner_aadhar ?? 'N/A' }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <i class="bi bi-file-earmark-image text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">KYC Documents</h3>
                    <p class="text-xs text-slate-400">Uploaded verification documents</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                    <div class="p-3 border-b bg-white">
                        <p class="text-sm font-semibold text-slate-700"> Business PAN </p>
                    </div>
                    @if (!empty($business->pan_image))
                        <button type="button" class="previewImage w-full p-4 text-cyan-600 hover:text-cyan-700"
                            data-title="Business PAN Image" data-src="{{ asset('storage/' . $business->pan_image) }}">
                            <i class="bi bi-eye text-2xl"></i>
                            <span class="block text-xs mt-1"> View Document</span>
                        </button>
                    @else
                        <div class="p-6 text-center text-slate-400">
                            <i class="bi bi-file-earmark-x text-2xl"></i>
                            <p class="text-xs mt-2"> Not Uploaded</p>
                        </div>
                    @endif
                </div>
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                    <div class="p-3 border-b bg-white">
                        <p class="text-sm font-semibold text-slate-700">Owner PAN</p>
                    </div>
                    @if (!empty($business->owner_pan_image))
                        <button type="button"class="previewImage w-full p-4 text-cyan-600 hover:text-cyan-700"
                            data-title="Owner PAN Image" data-src="{{ asset('storage/' . $business->owner_pan_image) }}">
                            <i class="bi bi-eye text-2xl"></i>
                            <span class="block text-xs mt-1">View Document</span>
                        </button>
                    @else
                        <div class="p-6 text-center text-slate-400"><i class="bi bi-file-earmark-x text-2xl"></i>
                            <p class="text-xs mt-2">Not Uploaded</p>
                        </div>
                    @endif

                </div>
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                    <div class="p-3 border-b bg-white">
                        <p class="text-sm font-semibold text-slate-700">Aadhaar Front</p>
                    </div>

                    @if (!empty($business->owner_aadhar_image_front))
                        <button type="button" class="previewImage w-full p-4 text-cyan-600 hover:text-cyan-700" data-title="Aadhaar Front Image"
                            data-src="{{ asset('storage/' . $business->owner_aadhar_image_front) }}">
                            <i class="bi bi-eye text-2xl"></i>
                            <span class="block text-xs mt-1">View Document</span>
                        </button>
                    @else
                        <div class="p-6 text-center text-slate-400">
                            <i class="bi bi-file-earmark-x text-2xl"></i>
                            <p class="text-xs mt-2"> Not Uploaded</p>
                        </div>
                    @endif
                </div>
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                    <div class="p-3 border-b bg-white">
                        <p class="text-sm font-semibold text-slate-700">Aadhaar Back</p>
                    </div>
                    @if (!empty($business->owner_aadhar_image_back))
                        <button type="button"
                            class="previewImage w-full p-4 text-cyan-600 hover:text-cyan-700"
                            data-title="Aadhaar Back Image"
                            data-src="{{ asset('storage/' . $business->owner_aadhar_image_back) }}">
                            <i class="bi bi-eye text-2xl"></i>
                            <span class="block text-xs mt-1">View Document</span>
                        </button>
                    @else
                        <div class="p-6 text-center text-slate-400">
                            <i class="bi bi-file-earmark-x text-2xl"></i>
                            <p class="text-xs mt-2">Not Uploaded</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <i class="bi bi-geo-alt text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Address Information</h3>
                    <p class="text-xs text-slate-400">
                        Registered business address
                    </p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1">City</p>
                    <h5 class="font-semibold text-slate-800">{{ $business->city ?? 'N/A' }}</h5>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1">State</p>
                    <h5 class="font-semibold text-slate-800">{{ $business->state ?? 'N/A' }}</h5>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p class="text-xs text-slate-400 mb-1"> Pin Code </p>
                    <h5 class="font-semibold text-slate-800">{{ $business->pin_code ?? 'N/A' }}</h5>
                </div>
            </div>
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 mt-5">
                <p class="text-xs text-slate-400 mb-2"> Full Address</p>
                <p class="font-medium text-slate-700 leading-6 break-words">{{ $business->full_address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>