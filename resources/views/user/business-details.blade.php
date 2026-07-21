<div class="bg-white rounded-2xl  overflow-hidden">
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            <div class="bg-gray-50 rounded-xl p-5 border">
                <p class="text-xs uppercase text-gray-500">Business Name</p>
                <h4 class="text-lg font-semibold mt-2">
                    {{ $business->business_name ?? 'N/A' }}
                </h4>
            </div>
            <div class="bg-gray-50 rounded-xl p-5 border">
                <p class="text-xs uppercase text-gray-500">Business Email</p>
                <h4 class="text-lg font-semibold mt-2 break-all">
                    {{ $business->business_email ?? 'N/A' }}
                </h4>
            </div>
            <div class="bg-gray-50 rounded-xl p-5 border">
                <p class="text-xs uppercase text-gray-500">Business Phone</p>
                <h4 class="text-lg font-semibold mt-2">
                    {{ $business->business_phone ?? 'N/A' }}
                </h4>
            </div>
            <div class="bg-gray-50 rounded-xl p-5 border">
                <p class="text-xs uppercase text-gray-500">Business Type</p>
                <h4 class="text-lg font-semibold mt-2">
                    {{ $business->business_type ?? 'N/A' }}
                </h4>
            </div>
            <div class="bg-gray-50 rounded-xl p-5 border">
                <p class="text-xs uppercase text-gray-500">Category</p>
                <h4 class="text-lg font-semibold mt-2">
                    {{ $business->business_category ?? 'N/A' }}
                </h4>
            </div>
            <div class="bg-gray-50 rounded-xl p-5 border">
                <p class="text-xs uppercase text-gray-500">Website</p>
                <h4 class="text-lg font-semibold mt-2 break-all">
                    {{ $business->website_url ?? 'N/A' }}
                </h4>
            </div>
        </div>
    </div>
    <div class="border-t">
        <div class="px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                KYC Information
            </h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="bg-cyan-50 rounded-xl p-5">
                <p class="text-xs text-gray-500">PAN Number</p>
                <h5 class="font-semibold mt-2">{{ $business->pan ?? 'N/A' }}</h5>
            </div>
            <div class="bg-cyan-50 rounded-xl p-5">
                <p class="text-xs text-gray-500">GST Number</p>
                <h5 class="font-semibold mt-2">{{ $business->gst ?? 'N/A' }}</h5>
            </div>
            <div class="bg-cyan-50 rounded-xl p-5">
                <p class="text-xs text-gray-500">Owner PAN</p>
                <h5 class="font-semibold mt-2">{{ $business->owner_pan ?? 'N/A' }}</h5>
            </div>
            <div class="bg-cyan-50 rounded-xl p-5">
                <p class="text-xs text-gray-500">Owner Aadhaar</p>
                <h5 class="font-semibold mt-2">{{ $business->owner_aadhar ?? 'N/A' }}</h5>
            </div>
        </div>

    </div>
    <div class="border-t">
        <div class="px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                Address Information
            </h3>
        </div>
        <div class="p-6">
            <div class="grid md:grid-cols-3 gap-5">
                <div class="bg-gray-50 rounded-xl p-5 border">
                    <p class="text-xs text-gray-500">City</p>
                    <h5 class="font-semibold mt-2">{{ $business->city ?? 'N/A' }}</h5>
                </div>
                <div class="bg-gray-50 rounded-xl p-5 border">
                    <p class="text-xs text-gray-500">State</p>
                    <h5 class="font-semibold mt-2">{{ $business->state ?? 'N/A' }}</h5>
                </div>
                <div class="bg-gray-50 rounded-xl p-5 border">
                    <p class="text-xs text-gray-500">Pin Code</p>
                    <h5 class="font-semibold mt-2">{{ $business->pin_code ?? 'N/A' }}</h5>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-5 border mt-5">
                <p class="text-xs text-gray-500 mb-2">
                    Full Address
                </p>
                <p class="font-medium text-gray-800">
                    {{ $business->full_address ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>
</div>