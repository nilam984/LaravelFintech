<!-- ===================== -->
<!-- KYC Verification -->
<!-- ===================== -->
<div id="kycVerification" class="tab-content hidden p-6 sm:p-8">

    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800">
            KYC Verification
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Review and verify the submitted KYC documents.
        </p>
    </div>

    @php
        $businessInfo = $user->businessInfo;
        $kycStatus = $businessInfo?->kyc_status ?? 'pending';
    @endphp

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

        <!-- Header -->
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">

            <div>

                <h3 class="font-semibold text-gray-800">
                    Verification Panel
                </h3>

                <p class="text-sm text-gray-500">
                    Verify each submitted KYC field individually.
                </p>

            </div>

            <div>

                @switch($kycStatus)
                    @case('approved')
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                            <i class="bi bi-check-circle-fill"></i>
                            Fully Approved
                        </span>
                    @break

                    @case('verification_approved')
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                            <i class="bi bi-hourglass-split"></i>
                            Waiting Admin Approval
                        </span>
                    @break

                    @case('verification_rejected')
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                            <i class="bi bi-x-circle-fill"></i>
                            Verification Rejected
                        </span>
                    @break

                    @case('admin_rejected')
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                            <i class="bi bi-x-circle-fill"></i>
                            Admin Rejected
                        </span>
                    @break

                    @default
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                            <i class="bi bi-clock-history"></i>
                            Pending Verification
                        </span>
                @endswitch

            </div>

        </div>

        <!-- Fields -->
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

                <div class="border border-cyan-500 rounded-xl p-5">

                    <div class="flex justify-between gap-6">

                        <!-- Left -->
                        <div class="flex-1">

                            <div class="flex items-center gap-2">

                                <h4 class="font-semibold text-cyan-500">

                                    <i class="bi bi-arrow-right-circle-fill"></i> {{ $field['label'] }}

                                </h4>

                                @if ($field['required'])
                                    <span class="text-[11px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full">
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
                                        <span class="text-sm text-gray-400">

                                            Document not uploaded

                                        </span>
                                    @endif
                                @else
                                    <p class="text-gray-700">

                                        {{ $value ?: '-' }}

                                    </p>
                                @endif

                            </div>

                            @if (!empty($verification['remark']))
                                <div class="mt-4 bg-red-50 border border-red-100 rounded-lg p-3">

                                    <div class="text-xs font-semibold text-red-700">

                                        Rejection Remark

                                    </div>

                                    <div class="text-sm text-red-600 mt-1">

                                        {{ $verification['remark'] }}

                                    </div>

                                </div>
                            @endif

                            @if ($admin['status'] != 'pending')
                                @php
                                    $isApproved = $admin['status'] == 'approved';
                                    // Dynamic color mapping based on status
                                    $containerClass = $isApproved
                                        ? 'border-green-200 bg-green-50/50 text-green-900'
                                        : 'border-red-200 bg-red-50/50 text-red-900';

                                    $headerClass = $isApproved ? 'text-green-800' : 'text-red-800';
                                    $badgeClass = $isApproved
                                        ? 'bg-green-100 text-green-700 border-green-200'
                                        : 'bg-red-100 text-red-700 border-red-200';
                                    $iconClass = $isApproved
                                        ? 'bi-check-circle-fill text-green-600'
                                        : 'bi-x-circle-fill text-red-600';
                                @endphp

                                <div class="mt-4 rounded-xl border {{ $containerClass }} p-4 shadow-sm transition-all">
                                    <!-- Header / Status Badge -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2 text-sm font-bold {{ $headerClass }}">
                                            <i class="bi bi-shield-check text-base"></i>
                                            Admin Review
                                        </div>

                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                            <i class="bi {{ $iconClass }}"></i>
                                            {{ $isApproved ? 'Approved by Admin' : 'Rejected by Admin' }}
                                        </span>
                                    </div>

                                    <!-- Admin Remark / Reason -->
                                    @if (!empty($admin['remark']))
                                        <div class="mt-3 pt-3 border-t border-gray-200/60 text-sm text-gray-600">
                                            <span class="font-semibold text-gray-700">Reason:</span>
                                            <p class="mt-0.5 italic text-gray-500">{{ $admin['remark'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>

                        <!-- Right -->
                        <div class="w-44 flex flex-col items-end">

                            {{-- Current Status --}}
                            <div class="mb-4">

                                @if ($verification['status'] == 'approved')
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">

                                        <i class="bi bi-patch-check-fill"></i>

                                        Approved

                                    </span>
                                @elseif($verification['status'] == 'rejected')
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">

                                        <i class="bi bi-x-octagon-fill"></i>

                                        Rejected

                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">

                                        <i class="bi bi-hourglass-split"></i>

                                        Pending

                                    </span>
                                @endif

                            </div>

                            {{-- Actions --}}
                            @if ($verification['status'] != 'approved')
                                <div class="flex items-center gap-2">

                                    <button
                                        class="verify-btn flex items-center gap-1 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100"
                                        data-role="verification" data-user="{{ $user->id }}"
                                        data-field="{{ $key }}" data-status="approved">

                                        <i class="bi bi-check-lg"></i>

                                        Approve

                                    </button>

                                    <button
                                        class="verify-btn flex items-center gap-1 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100"
                                        data-role="verification" data-user="{{ $user->id }}"
                                        data-field="{{ $key }}" data-status="rejected">

                                        <i class="bi bi-x-lg"></i>

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
