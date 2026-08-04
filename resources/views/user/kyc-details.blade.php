<div id="kyc-details" class="tab-content p-6 sm:p-8">

    <div class="mb-6">

        <h3 class="text-lg font-semibold text-gray-800">
            KYC Verification Status
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Check your KYC verification progress and status.
        </p>

    </div>


    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">


        {{-- Header --}}
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">


            <div>

                <h3 class="font-semibold text-gray-800">
                    Your KYC Status
                </h3>

                <p class="text-sm text-gray-500">
                    Track your submitted documents.
                </p>

            </div>


            <div>

                @switch($kycSummary['status'])
                    @case('approved')
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">

                            <i class="bi bi-check-circle-fill"></i>

                            KYC Approved

                        </span>
                    @break

                    @case('rejected')
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">

                            <i class="bi bi-x-circle-fill"></i>

                            KYC Rejected

                        </span>
                    @break

                    @case('authority_pending')
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">

                            <i class="bi bi-hourglass-split"></i>

                            Approval Pending

                        </span>
                    @break

                    @default
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">

                            <i class="bi bi-clock"></i>

                            Verification Pending

                        </span>
                @endswitch


            </div>


        </div>



        <div class="p-6">


            {{-- Rejected Fields --}}
            @if ($kycSummary['status'] == 'rejected')


                <div class="rounded-xl bg-red-50 border border-red-100 p-5">


                    <div class="flex items-center gap-2 font-semibold text-red-700">

                        <i class="bi bi-exclamation-triangle-fill"></i>

                        Action Required

                    </div>


                    <p class="text-sm text-red-600 mt-2">

                        Some KYC details need to be updated.

                    </p>



                    <div class="mt-4 space-y-3">


                        @foreach ($kycSummary['rejected_fields'] as $field)
                            <div class="rounded-lg bg-white border border-red-100 p-4">


                                <div class="font-semibold text-gray-800">

                                    {{ $field['field'] }}

                                </div>


                                @if ($field['remark'])
                                    <div class="mt-2 text-sm text-red-600">

                                        <strong>Reason:</strong>

                                        {{ $field['remark'] }}

                                    </div>
                                @endif


                            </div>
                        @endforeach


                    </div>


                </div>



                {{-- Pending --}}
            @elseif($kycSummary['status'] == 'pending')
                <div class="rounded-xl bg-yellow-50 border border-yellow-100 p-5">


                    <div class="flex items-center gap-2 font-semibold text-yellow-700">

                        <i class="bi bi-clock-fill"></i>

                        Verification Pending

                    </div>


                    <p class="text-sm text-yellow-600 mt-2">

                        Your submitted KYC details are being reviewed.

                    </p>



                    @if (count($kycSummary['pending_fields']) > 0)

                        <div class="mt-4">


                            <p class="text-sm font-medium text-gray-700">

                                Pending Documents:

                            </p>


                            <ul class="mt-2 space-y-1 text-sm text-gray-600">


                                @foreach ($kycSummary['pending_fields'] as $field)
                                    <li class="flex items-center gap-2">

                                        <i class="bi bi-dot"></i>

                                        {{ $field }}

                                    </li>
                                @endforeach


                            </ul>


                        </div>

                    @endif


                </div>



                {{-- Admin Pending --}}
            @elseif($kycSummary['status'] == 'authority_pending')
                <div class="rounded-xl bg-blue-50 border border-blue-100 p-5">


                    <div class="flex items-center gap-2 font-semibold text-blue-700">

                        <i class="bi bi-shield-check"></i>

                        Awaiting Final Approval

                    </div>


                    <p class="text-sm text-blue-600 mt-2">

                        Your documents have been verified successfully
                        and are waiting for final approval from the authority.

                    </p>


                </div>



                {{-- Approved --}}
            @elseif($kycSummary['status'] == 'approved')
                <div class="rounded-xl bg-green-50 border border-green-100 p-5">


                    <div class="flex items-center gap-2 font-semibold text-green-700">

                        <i class="bi bi-patch-check-fill"></i>

                        KYC Completed

                    </div>


                    <p class="text-sm text-green-600 mt-2">

                        Congratulations! Your KYC verification has been approved.

                    </p>


                </div>


            @endif


        </div>


    </div>


</div>
