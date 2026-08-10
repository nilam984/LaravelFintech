@php
    $isKycApproved = $business?->kyc_status === 'approved';
    $isLastRequestApproved = $lastBankRequest && $lastBankRequest->status === 'approved';
    $isRejectedOrUpdated = $lastBankRequest && in_array($lastBankRequest->status, ['rejected', 'updated']);
@endphp

@if ($isKycApproved && $isLastRequestApproved)
    {{-- ========================================== --}}
    {{-- 1. EDITABLE FORM (KYC approved & Last Request Approved) --}}
    {{-- ========================================== --}}
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border">
        <form action="#" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                <!-- Bank Name -->
                <div class="bg-gray-50 border rounded-xl p-5">
                    <label class="block text-xs uppercase tracking-wide text-gray-500 mb-2">
                        Bank Name
                    </label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $bank->bank_name ?? '') }}"
                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Account Holder -->
                <div class="bg-gray-50 border rounded-xl p-5">
                    <label class="block text-xs uppercase tracking-wide text-gray-500 mb-2">
                        Account Holder
                    </label>
                    <input type="text" name="account_holder_name"
                        value="{{ old('account_holder_name', $bank->account_holder_name ?? '') }}"
                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Account Number -->
                <div class="bg-gray-50 border rounded-xl p-5">
                    <label class="block text-xs uppercase tracking-wide text-gray-500 mb-2">
                        Account Number
                    </label>
                    <input type="text" name="account_number"
                        value="{{ old('account_number', $bank->account_number ?? '') }}"
                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- IFSC -->
                <div class="bg-gray-50 border rounded-xl p-5">
                    <label class="block text-xs uppercase tracking-wide text-gray-500 mb-2">
                        IFSC Code
                    </label>
                    <input type="text" name="ifsc_code" value="{{ old('ifsc_code', $bank->ifsc_code ?? '') }}"
                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Branch -->
                <div class="bg-gray-50 border rounded-xl p-5">
                    <label class="block text-xs uppercase tracking-wide text-gray-500 mb-2">
                        Branch Name
                    </label>
                    <input type="text" name="branch_name" value="{{ old('branch_name', $bank->branch_name ?? '') }}"
                        class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-gray-800 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

            </div>

            <!-- Submit Button for Form -->
            <div class="mt-6 flex justify-end">
                <button type="submit"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2.5 rounded-lg shadow transition">
                    Update Bank
                </button>
            </div>
        </form>
    </div>
@else
    {{-- ========================================== --}}
    {{-- 2. SIMPLE DESIGN (Null request, pending, rejected, updated, or KYC not approved) --}}
    {{-- ========================================== --}}

    {{-- Show request button if KYC is approved and last request was rejected, updated, or doesn't exist yet --}}
    @if ($isKycApproved && ($isRejectedOrUpdated || !$lastBankRequest))
        <div class="mb-4 flex justify-end">
            <button type="button" id="requestBankUpdateBtn"
                class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2.5 rounded-lg shadow transition">
                <i class="bi bi-arrow-up-circle-fill"></i> Request for Bank Updation
            </button>
        </div>
    @endif

    @if ($lastBankRequest)
        <div
            class="mb-4 p-4 rounded-xl text-sm 
            @if ($lastBankRequest->status === 'pending') bg-yellow-50 text-yellow-800 border border-yellow-200
            @elseif($lastBankRequest->status === 'rejected') bg-red-50 text-red-800 border border-red-200
            @elseif($lastBankRequest->status === 'updated') bg-blue-50 text-blue-800 border border-blue-200 @endif">
            Your recent bank update request status is: <strong>{{ ucfirst($lastBankRequest->status) }}</strong>.
        </div>
    @endif

    <div class="bg-white rounded-2xl overflow-hidden">
        <!-- Details -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                <!-- Bank Name -->
                <div class="bg-gray-50 border rounded-xl p-5">
                    <p class="text-xs uppercase tracking-wide text-gray-500">
                        Bank Name
                    </p>
                    <h4 class="text-lg font-semibold text-gray-800 mt-2">
                        {{ $bank->bank_name ?? 'N/A' }}
                    </h4>
                </div>

                <!-- Account Holder -->
                <div class="bg-gray-50 border rounded-xl p-5">
                    <p class="text-xs uppercase tracking-wide text-gray-500">
                        Account Holder
                    </p>
                    <h4 class="text-lg font-semibold text-gray-800 mt-2">
                        {{ $bank->account_holder_name ?? 'N/A' }}
                    </h4>
                </div>

                <!-- Account Number -->
                <div class="bg-gray-50 border rounded-xl p-5">
                    <p class="text-xs uppercase tracking-wide text-gray-500">
                        Account Number
                    </p>
                    <h4 class="text-lg font-semibold text-gray-800 mt-2">
                        {{ $bank->account_number ?? 'N/A' }}
                    </h4>
                </div>

                <!-- IFSC -->
                <div class="bg-gray-50 border rounded-xl p-5">
                    <p class="text-xs uppercase tracking-wide text-gray-500">
                        IFSC Code
                    </p>
                    <h4 class="text-lg font-semibold text-gray-800 mt-2">
                        {{ $bank->ifsc_code ?? 'N/A' }}
                    </h4>
                </div>

                <!-- Branch -->
                <div class="bg-gray-50 border rounded-xl p-5">
                    <p class="text-xs uppercase tracking-wide text-gray-500">
                        Branch Name
                    </p>
                    <h4 class="text-lg font-semibold text-gray-800 mt-2">
                        {{ $bank->branch_name ?? 'N/A' }}
                    </h4>
                </div>

            </div>
        </div>
    </div>

  
@endif
