<!-- ===================== -->
<!-- Admin KYC Approval -->
<!-- ===================== -->
<div id="kycVerification" class="tab-content hidden p-6 sm:p-8">

    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800">
            Final KYC Approval
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Review the verification officer's decisions and provide the final
            approval.
        </p>
    </div>

    @php
        $businessInfo = $user->businessInfo;
        $kycStatus = $businessInfo?->kyc_status ?? 'pending';
    @endphp

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

        {{-- Header --}}
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">

            <div>

                <h3 class="font-semibold text-gray-800">
                    Admin Approval Panel
                </h3>

                <p class="text-sm text-gray-500">
                    Final review after verification approval.
                </p>

            </div>

            <div>

                @switch($kycStatus)
                    @case('approved')
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            <i class="bi bi-check-circle-fill"></i>
                            Fully Approved
                        </span>
                    @break

                    @case('admin_rejected')
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                            <i class="bi bi-x-circle-fill"></i>
                            Admin Rejected
                        </span>
                    @break

                    @case('verification_approved')
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                            <i class="bi bi-hourglass-split"></i>
                            Awaiting Final Approval
                        </span>
                    @break

                    @case('verification_rejected')
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                            <i class="bi bi-exclamation-circle"></i>
                            Verification Rejected
                        </span>
                    @break

                    @default
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                            Pending
                        </span>
                @endswitch

            </div>

        </div>

        {{-- Fields --}}
        <div class="p-6 space-y-5">

            @foreach ($kycFields as $key => $field)
                @php

                    $value = $businessInfo?->$key;

                    $verification = $businessInfo?->kyc_verification_data[$key]['verification'] ?? [
                        'status' => 'pending',
                        'remark' => null,
                    ];

                    $admin = $businessInfo?->kyc_verification_data[$key]['admin'] ?? [
                        'status' => 'pending',
                        'remark' => null,
                    ];

                @endphp

                <div class="rounded-xl border border-cyan-500 p-5">

                    <div class="flex justify-between gap-6">

                        {{-- Left --}}
                        <div class="flex-1">

                            <div class="flex items-center gap-2">

                                <h4 class="font-semibold text-cyan-500">

                                    <i class="bi bi-arrow-right-circle-fill"></i> {{ $field['label'] }}

                                </h4>

                                @if ($field['required'])
                                    <span class="rounded-full bg-red-100 px-2 py-0.5 text-[11px] text-red-600">

                                        Required

                                    </span>
                                @endif

                            </div>

                            <div class="mt-3">

                                @if ($field['type'] == 'file')
                                    @if ($value)
                                        <a href="{{ asset('/storage/' . $value) }}" target="_blank"
                                            class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800">

                                            <i class="bi bi-file-earmark-text"></i>

                                            View Document

                                        </a>
                                    @else
                                        <span class="text-gray-400">

                                            Not Uploaded

                                        </span>
                                    @endif
                                @else
                                    <p class="text-gray-700">

                                        {{ $value ?: '-' }}

                                    </p>
                                @endif

                            </div>

                            {{-- Verification Result --}}
                            <div class="mt-5 rounded-lg bg-gray-50 border p-3">

                                <div class="font-semibold text-sm text-gray-700 inline">

                                    Verification Review

                                </div>

                                @if ($verification['status'] == 'approved')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                        <i class="bi bi-check-circle-fill text-green-600"></i>
                                        Approved
                                    </span>
                                @elseif($verification['status'] == 'rejected')
                                    <div class="space-y-1">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                            <i class="bi bi-x-circle-fill text-red-600"></i>
                                            Rejected
                                        </span>
                                        @if (!empty($verification['rejection_reason']))
                                            <p class="text-xs text-gray-500 pl-1 italic">
                                                Reason: {{ $verification['rejection_reason'] }}
                                            </p>
                                        @endif
                                    </div>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="bi bi-clock-history text-amber-500"></i>
                                        Pending
                                    </span>
                                @endif

                                @if (!empty($verification['remark']))
                                    <div class="mt-2 text-sm text-red-600">

                                        <strong>Reason:</strong>

                                        {{ $verification['remark'] }}

                                    </div>
                                @endif

                            </div>

                            {{-- Admin Remark --}}
                            @if (!empty($admin['remark']))
                                <div class="mt-4 rounded-lg border border-red-100 bg-gray-50 p-3">

                                    <div class="font-semibold text-red-700 text-sm">

                                        Admin Remark

                                    </div>

                                    <div class="text-sm text-red-600 mt-1">

                                        {{ $admin['remark'] }}

                                    </div>

                                </div>
                            @endif

                        </div>

                        {{-- Right --}}
                        <div class="w-44 flex flex-col items-end">

                            {{-- Verification rejected --}}
                            @if ($verification['status'] == 'rejected')
                                <div
                                    class="rounded-xl bg-red-50 border border-red-100 p-4 text-xs text-red-700 leading-relaxed">

                                    <div class="flex items-center gap-2 font-semibold mb-2">

                                        <i class="bi bi-exclamation-triangle-fill"></i>

                                        Verification Failed

                                    </div>

                                    This field cannot be approved until the user updates it.

                                </div>
                            @else
                                {{-- Admin Status --}}
                                <div class="mb-4">

                                    @if ($admin['status'] == 'approved')
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">

                                            <i class="bi bi-check-circle-fill"></i>

                                            Approved

                                        </span>
                                    @elseif($admin['status'] == 'rejected')
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">

                                            <i class="bi bi-x-circle-fill"></i>

                                            Rejected

                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">

                                            <i class="bi bi-clock"></i>

                                            Pending

                                        </span>
                                    @endif

                                </div>



                                {{-- Admin Actions --}}
                                @if ($verification['status'] == 'approved' && $admin['status'] != 'approved')
                                    <div class="flex items-center gap-2">


                                        <button title="Approve"
                                            class="verify-btn h-9 w-9 rounded-full bg-green-100 text-green-700 hover:bg-green-600 hover:text-white transition"
                                            data-role="admin" data-user="{{ $user->id }}"
                                            data-field="{{ $key }}" data-status="approved">

                                            <i class="bi bi-check-lg"></i>

                                        </button>



                                        <button title="Reject"
                                            class="verify-btn h-9 w-9 rounded-full bg-red-100 text-red-700 hover:bg-red-600 hover:text-white transition"
                                            data-role="admin" data-user="{{ $user->id }}"
                                            data-field="{{ $key }}" data-status="rejected">

                                            <i class="bi bi-x-lg"></i>

                                        </button>


                                    </div>
                                @endif
                            @endif


                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

</div>
