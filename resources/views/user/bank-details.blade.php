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