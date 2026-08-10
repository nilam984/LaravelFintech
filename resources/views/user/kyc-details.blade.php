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


{{-- ========================================================= --}}
{{-- KYC VERIFICATION --}}
{{-- ========================================================= --}}

<div class="space-y-5">

    {{-- Section Heading --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        <div>
            <div class="flex items-center gap-3">

                <div
                    class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600
                           flex items-center justify-center">

                    <i class="bi bi-shield-check text-lg"></i>

                </div>

                <div>
                    <h3 class="text-lg font-bold text-slate-800">
                        KYC Verification Status
                    </h3>

                    <p class="mt-0.5 text-sm text-slate-500">
                        Check your KYC verification progress and status.
                    </p>
                </div>

            </div>
        </div>

    </div>


    {{-- Main Card --}}
    <div
        class="overflow-hidden bg-white
               border border-slate-100
               shadow-sm rounded-2xl">

        {{-- ================================================= --}}
        {{-- Header --}}
        {{-- ================================================= --}}

        <div
            class="flex flex-col sm:flex-row
                   sm:items-center sm:justify-between
                   gap-4 px-5 sm:px-6 py-5
                   border-b border-slate-100">

            <div class="flex items-center gap-3">

                <div
                    class="w-10 h-10 rounded-xl
                           bg-slate-50
                           text-slate-500
                           flex items-center justify-center">

                    <i class="bi bi-file-earmark-check text-lg"></i>

                </div>

                <div>

                    <h3 class="font-semibold text-slate-800">
                        Your KYC Status
                    </h3>

                    <p class="text-xs text-slate-500 mt-0.5">
                        Track your submitted documents.
                    </p>

                </div>

            </div>


            {{-- Status Badge --}}
            <span
                class="inline-flex items-center gap-2
                       rounded-full px-3.5 py-1.5
                       text-xs font-semibold
                       {{ $status['badge'] }}">

                <span class="flex items-center justify-center">
                    <i class="bi {{ $status['icon'] }}"></i>
                </span>

                {{ $status['title'] }}

            </span>

        </div>


        {{-- ================================================= --}}
        {{-- Content --}}
        {{-- ================================================= --}}

        <div class="p-5 sm:p-6">

            <div
                class="relative overflow-hidden
                       p-5 sm:p-6
                       border rounded-2xl
                       {{ $status['box'] }}">

                {{-- Decorative Circle --}}
                <div
                    class="absolute -right-10 -top-10
                           w-28 h-28 rounded-full
                           bg-white/40 pointer-events-none">
                </div>


                {{-- Status Content --}}
                <div class="relative">

                    <div class="flex items-start gap-4">

                        {{-- Status Icon --}}
                        <div
                            class="w-11 h-11 rounded-xl
                                   bg-white shadow-sm
                                   {{ $status['text'] }}
                                   flex items-center justify-center
                                   flex-shrink-0">

                            <i class="bi {{ $status['icon'] }} text-xl"></i>

                        </div>


                        <div class="min-w-0">

                            {{-- Heading --}}
                            <h4
                                class="text-base sm:text-lg
                                       font-bold {{ $status['text'] }}">

                                {{ $status['heading'] }}

                            </h4>


                            {{-- Message --}}
                            <p
                                class="mt-1.5 text-sm leading-6
                                       {{ $status['desc'] }}">

                                {{ $status['message'] }}

                            </p>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- Pending Documents --}}
                    {{-- ================================================= --}}

                    @if ($kycSummary['status'] == 'pending' && count($kycSummary['pending_fields']))

                        <div
                            class="mt-6 pt-5
                                   border-t border-black/5">

                            <div class="flex items-center gap-2 mb-3">

                                <div
                                    class="w-8 h-8 rounded-lg
                                           bg-white
                                           text-yellow-600
                                           flex items-center justify-center
                                           shadow-sm">

                                    <i class="bi bi-hourglass-split"></i>

                                </div>

                                <div>

                                    <h5 class="text-sm font-semibold text-slate-700">
                                        Pending Documents
                                    </h5>

                                    <p class="text-xs text-slate-500">
                                        Documents required to complete verification
                                    </p>

                                </div>

                            </div>


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                                @foreach ($kycSummary['pending_fields'] as $field)

                                    <div
                                        class="flex items-center gap-3
                                               p-3.5
                                               bg-white/80
                                               border border-yellow-100
                                               rounded-xl">

                                        <div
                                            class="w-8 h-8 rounded-lg
                                                   bg-yellow-100
                                                   text-yellow-600
                                                   flex items-center justify-center
                                                   flex-shrink-0">

                                            <i class="bi bi-file-earmark-text"></i>

                                        </div>

                                        <span
                                            class="text-sm font-medium text-slate-700">

                                            {{ $field }}

                                        </span>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @endif


                    {{-- ================================================= --}}
                    {{-- Rejected Documents --}}
                    {{-- ================================================= --}}

                    @if (
                        in_array($kycSummary['status'], ['verification_rejected', 'admin_rejected']) &&
                            count($kycSummary['rejected_fields'])
                    )

                        <div
                            class="mt-6 pt-5
                                   border-t border-black/5">

                            <div class="flex items-center gap-2 mb-4">

                                <div
                                    class="w-8 h-8 rounded-lg
                                           bg-white
                                           text-red-600
                                           flex items-center justify-center
                                           shadow-sm">

                                    <i class="bi bi-exclamation-triangle"></i>

                                </div>

                                <div>

                                    <h5 class="text-sm font-semibold text-slate-700">
                                        Rejected Documents
                                    </h5>

                                    <p class="text-xs text-slate-500">
                                        Please review the rejection reason and update the documents.
                                    </p>

                                </div>

                            </div>


                            <div class="space-y-3">

                                @foreach ($kycSummary['rejected_fields'] as $field)

                                    <div
                                        class="bg-white
                                               border border-red-100
                                               rounded-xl
                                               p-4
                                               hover:shadow-sm
                                               transition">

                                        <div
                                            class="flex flex-col sm:flex-row
                                                   sm:items-center
                                                   sm:justify-between
                                                   gap-2">

                                            {{-- Field Name --}}
                                            <div class="flex items-center gap-3">

                                                <div
                                                    class="w-9 h-9 rounded-lg
                                                           bg-red-50
                                                           text-red-500
                                                           flex items-center justify-center
                                                           flex-shrink-0">

                                                    <i class="bi bi-file-earmark-x"></i>

                                                </div>

                                                <div>

                                                    <p class="text-sm font-semibold text-slate-800">
                                                        {{ $field['field'] }}
                                                    </p>

                                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                                        Document requires attention
                                                    </p>

                                                </div>

                                            </div>


                                            {{-- Rejected Badge --}}
                                            <span
                                                class="inline-flex items-center gap-1.5
                                                       px-2.5 py-1
                                                       rounded-full
                                                       bg-red-50
                                                       text-red-600
                                                       text-[11px]
                                                       font-semibold
                                                       self-start sm:self-auto">

                                                <span
                                                    class="w-1.5 h-1.5
                                                           rounded-full
                                                           bg-red-500">
                                                </span>

                                                Rejected

                                            </span>

                                        </div>


                                        {{-- Remark --}}
                                        @if ($field['remark'])

                                            <div
                                                class="mt-4
                                                       p-3
                                                       rounded-lg
                                                       bg-red-50
                                                       border border-red-100">

                                                <div
                                                    class="flex items-start gap-2">

                                                    <i
                                                        class="bi bi-chat-left-text
                                                               text-red-500 mt-0.5">
                                                    </i>

                                                    <div>

                                                        <p
                                                            class="text-xs
                                                                   font-semibold
                                                                   text-red-700">

                                                            Reason

                                                        </p>

                                                        <p
                                                            class="mt-1 text-sm
                                                                   leading-5
                                                                   text-red-600">

                                                            {{ $field['remark'] }}

                                                        </p>

                                                    </div>

                                                </div>

                                            </div>

                                        @endif

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>