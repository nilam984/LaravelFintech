@extends('layouts.app')
@section('title', 'User Profile')
@section('content')
    <div class="min-h-screen bg-gray-100 py-6">
        <div class="flex items-center justify-between">
            <div class="mb-5 ms-5">
                <h1 class="text-2xl font-bold text-fintechDarkText"> Profile </h1>
                <p class="text-sm text-fintechMutedText mt-1"> Manage Profile. </p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4">
            <form id="profileForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white rounded-2xl shadow-md mb-6">
                    <div class="px-5 py-3 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-700">Business Details</h3>
                    </div>
                    <div class="p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Business Name</label>
                            <input type="text" name="business_name" placeholder="e.g. Acme Corporation"
                                value="{{ old('business_name', $business->business_name ?? '') }}"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Business Email</label>
                            <input type="email" name="business_email" placeholder="e.g. contact@acme.com"
                                value="{{ old('business_email', $business->business_email ?? '') }}"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Business Phone</label>
                            <input type="text" name="business_phone" placeholder="e.g. +91 98765 43210"
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
                            <input type="text" name="business_category" placeholder="e.g. Retail, E-commerce, IT"
                                value="{{ old('business_category', $business->business_category ?? '') }}"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Website URL</label>
                            <input type="url" name="website_url" placeholder="e.g. https://www.acme.com"
                                value="{{ old('website_url', $business->website_url ?? '') }}"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>
                    </div>
                </div>

                <!-- 2. KYC Details -->
                <div class="bg-white rounded-2xl shadow-md mb-6">
                    <div class="px-5 py-3 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-700">KYC Details</h3>
                    </div>
                    <div class="p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Business PAN Number</label>
                            <input type="text" name="pan" placeholder="10-digit PAN (e.g. ABCDE1234F)"
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
                            <label class="text-sm font-medium text-gray-600">Owner Aadhaar Number</label>
                            <input type="text" name="owner_aadhar" placeholder="12-digit Aadhaar Number"
                                value="{{ old('owner_aadhar', $business->owner_aadhar ?? '') }}"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-gray-600">
                                    Business PAN Image
                                </label>

                                @if (!empty($business->pan_image))
                                    <button type="button" class="previewImage text-cyan-600 hover:text-cyan-800"
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
                                <label for="owner_pan_image" class="text-sm font-medium text-gray-600">
                                    Owner PAN Image
                                </label>

                                @if (!empty($business->owner_pan_image))
                                    <button type="button" class="previewImage text-cyan-600 hover:text-cyan-800"
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
                                <label for="owner_aadhar_image_front" class="text-sm font-medium text-gray-600">
                                    Aadhaar Front Image
                                </label>

                                @if (!empty($business->owner_aadhar_image_front))
                                    <button type="button" class="previewImage text-cyan-600 hover:text-cyan-800"
                                        data-title="Aadhaar Front Image"
                                        data-src="{{ asset('storage/' . $business->owner_aadhar_image_front) }}">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                @endif
                            </div>

                            <input id="owner_aadhar_image_front" type="file" name="owner_aadhar_image_front"
                                class="w-full border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3
                                file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700
                                hover:file:bg-cyan-100">
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="owner_aadhar_image_back" class="text-sm font-medium text-gray-600">
                                    Aadhaar Back Image
                                </label>

                                @if (!empty($business->owner_aadhar_image_back))
                                    <button type="button" class="previewImage text-cyan-600 hover:text-cyan-800"
                                        data-title="Aadhaar Back Image"
                                        data-src="{{ asset('storage/' . $business->owner_aadhar_image_back) }}">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                @endif
                            </div>

                            <input id="owner_aadhar_image_back" type="file" name="owner_aadhar_image_back"
                                class="w-full border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3
                                file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700
                                hover:file:bg-cyan-100">
                        </div>
                    </div>
                </div>

                <!-- 3. Address Details -->
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

                <!-- 4. Bank Details -->
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
                            <label class="text-sm font-medium text-gray-600">Account Holder Name</label>
                            <input type="text" name="account_holder_name" placeholder="Name as per bank records"
                                value="{{ old('account_holder_name', $bank->account_holder_name ?? '') }}"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Account Number</label>
                            <input type="text" name="account_number" placeholder="Enter bank account number"
                                value="{{ old('account_number', $bank->account_number ?? '') }}"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">IFSC Code</label>
                            <input type="text" name="ifsc_code" placeholder="11-digit IFSC (e.g. HDFC0001234)"
                                value="{{ old('ifsc_code', $bank->ifsc_code ?? '') }}"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Branch Name</label>
                            <input type="text" name="branch_name" placeholder="e.g. Connaught Place"
                                value="{{ old('branch_name', $bank->branch_name ?? '') }}"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="bank_docs" class="text-sm font-medium text-gray-600">
                                    Cancelled Cheque / Passbook
                                </label>
                                @if (!empty($bank->bank_docs))
                                    <button type="button" class="previewImage text-cyan-600 hover:text-cyan-800"
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

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-md text-sm transition-colors duration-200">
                        Save Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Image Preview Modal --}}
    <div id="imagePreviewModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-11/12 md:w-3/4 lg:w-1/2 relative">
            <div class="flex justify-between items-center border-b p-4">
                <h3 id="previewTitle" class="text-lg font-semibold"></h3>
                <button type="button" id="closePreview" class="text-gray-500 hover:text-red-500 text-2xl">
                    &times;
                </button>
            </div>
            <div id="previewBody" class="p-4 text-center">
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $(document).on('click', '.previewImage', function() {
            let src = $(this).data('src');
            let title = $(this).data('title');
            $('#previewTitle').text(title);
            let extension = src.split('.').pop().toLowerCase();
            if (extension === 'pdf') {
                $('#previewBody').html(`
            <iframe src="${src}"
                class="w-[700px] h-[600px] mx-auto rounded-lg border">
            </iframe>
        `);
            } else {

                $('#previewBody').html(`
            <div class="flex justify-center items-center p-4">
                <img src="${src}"
                    class="w-[450px] h-[300px] object-contain border rounded-lg bg-gray-100">
            </div>
        `);
            }
            $('#imagePreviewModal')
                .removeClass('hidden')
                .addClass('flex');

        });
        $('#closePreview').click(function() {

            $('#imagePreviewModal')
                .removeClass('flex')
                .addClass('hidden');
        });
        $('#imagePreviewModal').click(function(e) {
            if (e.target === this) {

                $(this)
                    .removeClass('flex')
                    .addClass('hidden');

            }
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
                        $('.text-danger').remove();
                        $('button[type=submit]')
                            .prop('disabled', true)
                            .text('Please Wait...');
                    },
                    success: function(response) {
                        $('button[type=submit]')
                            .prop('disabled', false).text('Save Profile');
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        $('button[type=submit]')
                            .prop('disabled', false)
                            .text('Save Profile');
                        if (xhr.status == 422) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('[name="' + key + '"]').after(
                                    '<span class="text-danger">' + value[0] +
                                    '</span>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
@endsection
