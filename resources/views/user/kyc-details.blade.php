@php
    $statusConfig = [
        'pending' => [
            'badge' => 'bg-yellow-100 text-yellow-700',
            'icon' => 'bi-clock',
            'title' => 'Pending',
            'heading' => 'Verification Pending',
            'message' => 'Your submitted KYC details are being reviewed by our verification team.',
            'box' => 'bg-yellow-50 border-yellow-100',
            'text' => 'text-yellow-700',
            'desc' => 'text-yellow-600',
        ],

        'verification_approved' => [
            'badge' => 'bg-blue-100 text-blue-700',
            'icon' => 'bi-hourglass-split',
            'title' => 'Approval Pending',
            'heading' => 'Approval Pending for Admin Authority',
            'message' => 'Your KYC has been verified and awaiting final approval from the Admin Authority.',
            'box' => 'bg-blue-50 border-blue-100',
            'text' => 'text-blue-700',
            'desc' => 'text-blue-600',
        ],

        'verification_rejected' => [
            'badge' => 'bg-red-100 text-red-700',
            'icon' => 'bi-x-circle-fill',
            'title' => 'Rejected',
            'heading' => 'Verification Rejected',
            'message' => 'Some KYC documents were rejected by the verification team. Please update them and resubmit.',
            'box' => 'bg-red-50 border-red-100',
            'text' => 'text-red-700',
            'desc' => 'text-red-600',
        ],

        'admin_rejected' => [
            'badge' => 'bg-red-100 text-red-700',
            'icon' => 'bi-shield-x',
            'title' => 'Rejected',
            'heading' => 'Admin Authority Rejected',
            'message' =>
                'Your KYC was rejected during the final review by the Admin Authority. Please update the rejected documents.',
            'box' => 'bg-red-50 border-red-100',
            'text' => 'text-red-700',
            'desc' => 'text-red-600',
        ],

        'approved' => [
            'badge' => 'bg-green-100 text-green-700',
            'icon' => 'bi-check-circle-fill',
            'title' => 'KYC Approved',
            'heading' => 'KYC Completed',
            'message' => 'Congratulations! Your KYC has been approved successfully.',
            'box' => 'bg-green-50 border-green-100',
            'text' => 'text-green-700',
            'desc' => 'text-green-600',
        ],
    ];

    $status = $statusConfig[$kycSummary['status']] ?? $statusConfig['pending'];
@endphp

<div id="kyc-details" class="p-6 sm:p-8">

    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800">
            KYC Verification Status
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Check your KYC verification progress and status.
        </p>
    </div>

    <div class="overflow-hidden bg-white border border-gray-100 shadow-sm rounded-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-100">

            <div>
                <h3 class="font-semibold text-gray-800">
                    Your KYC Status
                </h3>

                <p class="text-sm text-gray-500">
                    Track your submitted documents.
                </p>
            </div>

            <span
                class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $status['badge'] }}">

                <i class="bi {{ $status['icon'] }}"></i>

                {{ $status['title'] }}

            </span>

        </div>

        <div class="p-6">

            <div class="p-5 border rounded-xl {{ $status['box'] }}">

                <div class="flex items-center gap-2 font-semibold {{ $status['text'] }}">

                    <i class="bi {{ $status['icon'] }}"></i>

                    {{ $status['heading'] }}

                </div>

                <p class="mt-2 text-sm {{ $status['desc'] }}">
                    {{ $status['message'] }}
                </p>

                {{-- Pending Documents --}}
                @if ($kycSummary['status'] == 'pending' && count($kycSummary['pending_fields']))

                    <div class="mt-5">

                        <h5 class="mb-2 text-sm font-semibold text-gray-700">
                            Pending Documents
                        </h5>

                        <ul class="space-y-2 text-sm text-gray-600">

                            @foreach ($kycSummary['pending_fields'] as $field)
                                <li class="flex items-center gap-2">

                                    <i class="bi bi-dot"></i>

                                    {{ $field }}

                                </li>
                            @endforeach

                        </ul>

                    </div>

                @endif

                {{-- Rejected Documents --}}
                @if (in_array($kycSummary['status'], ['verification_rejected', 'admin_rejected']) &&
                        count($kycSummary['rejected_fields']))

                    <div class="mt-5 space-y-3">

                        @foreach ($kycSummary['rejected_fields'] as $field)
                            <div class="p-4 bg-white border border-red-100 rounded-lg">

                                <div class="font-semibold text-gray-800">

                                    {{ $field['field'] }}

                                </div>

                                @if ($field['remark'])
                                    <div class="mt-2 text-sm text-red-600">

                                        <strong>Reason :</strong>

                                        {{ $field['remark'] }}

                                    </div>
                                @endif

                            </div>
                        @endforeach

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>
