@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
    <div class="min-h-screen bg-gray-100 py-6">
        <div class="flex items-center justify-between">

            <div class="mb-5 ms-5">
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Profile
                </h1>
                <p class="text-sm text-fintechMutedText mt-1">
                    Manage Profile.
                </p>
            </div>
        </div>


        <div class="max-w-7xl mx-auto px-4">

            <form action="" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 1. Business Details -->
                <div class="bg-white rounded-2xl shadow-md mb-6">
                    <div class="px-5 py-3 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-700">Business Details</h3>
                    </div>
                    <div class="p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Business Name</label>
                            <input type="text" name="business_name" placeholder="e.g. Acme Corporation"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Business Email</label>
                            <input type="email" name="business_email" placeholder="e.g. contact@acme.com"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Business Phone</label>
                            <input type="text" name="business_phone" placeholder="e.g. +91 98765 43210"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Business Type</label>
                            <select name="business_type"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                                <option value="">Select Business Type</option>
                                <option>Proprietorship</option>
                                <option>Partnership</option>
                                <option>Private Limited</option>
                                <option>LLP</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Business Category</label>
                            <input type="text" name="business_category" placeholder="e.g. Retail, E-commerce, IT"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Website URL</label>
                            <input type="url" name="website_url" placeholder="e.g. https://www.acme.com"
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
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">GST Number</label>
                            <input type="text" name="gst" placeholder="15-digit GSTIN"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Owner PAN</label>
                            <input type="text" name="owner_pan" placeholder="Owner's 10-digit PAN"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Owner Aadhaar Number</label>
                            <input type="text" name="owner_aadhar" placeholder="12-digit Aadhaar Number"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Business PAN Image</label>
                            <input type="file" name="pan_image"
                                class="w-full mt-1 border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Owner PAN Image</label>
                            <input type="file" name="owner_pan_image"
                                class="w-full mt-1 border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Aadhaar Front Image</label>
                            <input type="file" name="owner_aadhar_image_front"
                                class="w-full mt-1 border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Aadhaar Back Image</label>
                            <input type="file" name="owner_aadhar_image_back"
                                class="w-full mt-1 border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
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
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">State</label>
                            <input type="text" name="state" placeholder="e.g. Maharashtra"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Pin Code</label>
                            <input type="text" name="pin_code" placeholder="6-digit ZIP/Pin code"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div class="md:col-span-3">
                            <label class="text-sm font-medium text-gray-600">Full Address</label>
                            <textarea name="full_address" rows="2" placeholder="Building, Street Name, Area, Landmark..."
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none resize-none"></textarea>
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
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Account Holder Name</label>
                            <input type="text" name="account_holder_name" placeholder="Name as per bank records"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Account Number</label>
                            <input type="text" name="account_number" placeholder="Enter bank account number"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">IFSC Code</label>
                            <input type="text" name="ifsc_code" placeholder="11-digit IFSC (e.g. HDFC0001234)"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Branch Name</label>
                            <input type="text" name="branch_name" placeholder="e.g. Connaught Place"
                                class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 outline-none">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Cancelled Cheque / Passbook</label>
                            <input type="file" name="bank_docs"
                                class="w-full mt-1 border rounded-lg p-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-6 flex justify-end">
                    <button
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2.5 rounded-xl font-semibold shadow-md text-sm transition-colors duration-200">
                        Save Profile
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection
