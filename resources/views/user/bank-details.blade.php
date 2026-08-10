@php
    $isKycApproved = $business?->kyc_status === 'approved';
    $isLastRequestApproved = $lastBankRequest && $lastBankRequest->status === 'approved';
    $isRejectedOrUpdated = $lastBankRequest && in_array($lastBankRequest->status, ['rejected', 'updated']);
@endphp

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <i class="bi bi-bank2 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Bank Details</h3>
                    <p class="text-sm text-slate-500 mt-0.5">Manage and view your registered bank account information.</p>
                </div>
            </div>
        </div>
        <div>
            @if ($isKycApproved)
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    KYC Approved
                </span>
            @else
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold  bg-amber-50 text-amber-700 border border-amber-100">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    KYC Pending
                </span>
            @endif
        </div>
    </div>
    @if ($isKycApproved && $isLastRequestApproved)
        <form id="bankUpdateForm" action="{{ route('bank.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="bank_request_id" id="bank_request_id" value="{{ old('bank_request_id', $lastBankRequest?->id) }}">
            <div class="flex items-start gap-3 p-4 rounded-xl bg-cyan-50 border border-cyan-100 mb-6">
                <div class="w-9 h-9 rounded-lg bg-white text-cyan-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-cyan-800">Bank Update Available</p>
                    <p class="text-xs text-cyan-700 mt-1">
                        Your bank update request has been approved.
                        You can now update your bank details.
                    </p>
                </div>
            </div>
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center">
                        <i class="bi bi-credit-card-2-front"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-800">Account Information</h4>
                        <p class="text-xs text-slate-500">Enter your updated bank account details.</p>
                    </div>

                </div>

                <div class="p-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Bank Name</label>
                            <div class="relative">
                                <i class="bi bi-bank absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="bank_name" value="{{ old('bank_name', $bank->bank_name ?? '') }}" placeholder="Enter bank name" required class="w-full pl-10 pr-3 py-2.5  border border-slate-200 rounded-xl bg-slate-50/50 text-sm text-slate-700 focus:bg-white focus:border-cyan-500
                                           focus:ring-2 focus:ring-cyan-100 outline-none transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Account Holder Name </label>
                            <div class="relative">
                                <i class="bi bi-person absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="account_holder_name" value="{{ old('account_holder_name', $bank->account_holder_name ?? '') }}" placeholder="Enter account holder name" required class="w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-slate-50/50 text-sm text-slate-700
                                           focus:bg-white focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100 outline-none transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Account Number
                            </label>
                            <div class="relative">
                                <i class="bi bi-credit-card absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="account_number" value="{{ old('account_number', $bank->account_number ?? '') }}" placeholder="Enter account number" required class="w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-slate-50/50 text-sm text-slate-700 focus:bg-white focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100 outline-none transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">IFSC Code</label>
                            <div class="relative">
                                <i class="bi bi-upc-scan absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="ifsc_code" value="{{ old('ifsc_code', $bank->ifsc_code ?? '') }}" placeholder="e.g. HDFC0001234" required class="w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-slate-50/50 text-sm text-slate-700 uppercase
                                           focus:bg-white focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100 outline-none transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2"> Branch Name </label>
                            <div class="relative">
                                <i class="bi bi-geo-alt absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="branch_name" value="{{ old('branch_name', $bank->branch_name ?? '') }}" placeholder="Enter branch name"
                                    required class="w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-slate-50/50 text-sm text-slate-700 focus:bg-white focus:border-cyan-500 focus:ring-2 focus:ring-cyan-100 outline-none transition">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-slate-600">Bank Document</label>
                                @if (!empty($bank?->bank_docs))
                                    <button type="button" class="previewImage inline-flex items-center gap-1 text-xs font-medium text-cyan-600 hover:text-cyan-800 transition"
                                        data-title="Bank Document" data-src="{{ asset('storage/' . $bank->bank_docs) }}">
                                        <i class="bi bi-eye-fill"></i> View
                                    </button>
                                @endif
                            </div>
                            <input type="file" name="bank_docs" accept="image/*,.pdf" class="w-full border border-slate-200 rounded-xl bg-slate-50/50 px-3 py-2 text-sm
                                       text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0
                                       file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                            <p class="text-[11px] text-slate-400 mt-1.5"> Upload cancelled cheque or passbook. </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-5">
                <button type="submit" class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2.5
                           rounded-xl text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                    <i class="bi bi-check2-circle"></i>
                    Update Bank Details
                </button>
            </div>
        </form>

    @else
        @if ($isKycApproved && ($isRejectedOrUpdated || !$lastBankRequest))
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 rounded-2xl bg-gradient-to-r from-cyan-50 to-white border border-cyan-100">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-800">Need to update your bank details?</h4>
                        <p class="text-xs text-slate-500 mt-1">Submit a request to update your registered bank account.</p>
                    </div>
                </div>
                <button type="button" id="requestBankUpdateBtn" class="inline-flex items-center justify-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:shadow-md transition whitespace-nowrap">
                    <i class="bi bi-send"></i>
                    Request Bank Updation
                </button>
            </div>
        @endif
        @if ($lastBankRequest)
            @php
                $status = $lastBankRequest->status;
                $statusConfig = match ($status) {
                    'pending' => ['bg' => 'bg-amber-50','border' => 'border-amber-200','text' => 'text-amber-800','iconBg' => 'bg-amber-100','icon' => 'bi-hourglass-split','label' => 'Pending'],
                    'approved' => ['bg' => 'bg-emerald-50','border' => 'border-emerald-200','text' => 'text-emerald-800', 'iconBg' => 'bg-emerald-100','icon' => 'bi-check-circle-fill','label' => 'Approved'],
                    'rejected' => ['bg' => 'bg-rose-50','border' => 'border-rose-200','text' => 'text-rose-800','iconBg' => 'bg-rose-100','icon' => 'bi-x-circle-fill','label' => 'Rejected'],
                    'updated' => ['bg' => 'bg-blue-50','border' => 'border-blue-200','text' => 'text-blue-800','iconBg' => 'bg-blue-100','icon' => 'bi-arrow-repeat','label' => 'Updated'],
                    default => ['bg' => 'bg-slate-50','border' => 'border-slate-200','text' => 'text-slate-800','iconBg' => 'bg-slate-100','icon' => 'bi-info-circle-fill','label' => ucfirst($status),],
                };
            @endphp
            <div class="flex items-start gap-3 p-4 rounded-2xl {{ $statusConfig['bg'] }} border {{ $statusConfig['border'] }}">
                <div class="w-10 h-10 rounded-xl  {{ $statusConfig['iconBg'] }} {{ $statusConfig['text'] }} flex items-center justify-center flex-shrink-0">
                    <i class="bi {{ $statusConfig['icon'] }}"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold {{ $statusConfig['text'] }}">Bank Update Request</p>
                    <p class="text-xs {{ $statusConfig['text'] }} mt-1"> Your recent bank update request status is
                        <strong>{{ $statusConfig['label'] }}</strong>.
                    </p>
                </div>
            </div>
        @endif
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    <div class="group rounded-xl border border-slate-100 bg-slate-50/70 p-4 hover:bg-white hover:border-cyan-100 hover:shadow-sm transition">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="bi bi-bank text-cyan-600"></i>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Bank Name</p>
                        </div>
                        <p class="font-semibold text-slate-800 break-words">{{ $bank->bank_name ?? 'N/A' }}</p>
                    </div>

                    <div class="group rounded-xl border border-slate-100  bg-slate-50/70 p-4 hover:bg-white hover:border-cyan-100 hover:shadow-sm transition">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="bi bi-person text-cyan-600"></i>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Account Holder</p>
                        </div>
                        <p class="font-semibold text-slate-800 break-words">{{ $bank->account_holder_name ?? 'N/A' }}</p>
                    </div>
                    <div class="group rounded-xl border border-slate-100 bg-slate-50/70 p-4 hover:bg-white hover:border-cyan-100 hover:shadow-sm transition">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="bi bi-credit-card text-cyan-600"></i>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Account Number</p>
                        </div>
                        <p class="font-semibold text-slate-800 break-all">{{ $bank->account_number ?? 'N/A' }}</p>
                    </div>
                    <div class="group rounded-xl border border-slate-100 bg-slate-50/70 p-4  hover:bg-white hover:border-cyan-100  hover:shadow-sm transition">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="bi bi-upc-scan text-cyan-600"></i>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                IFSC Code
                            </p>
                        </div>
                        <p class="font-semibold text-slate-800 uppercase">{{ $bank->ifsc_code ?? 'N/A' }} </p>
                    </div>

                    {{-- Branch --}}
                    <div class="group rounded-xl border border-slate-100 bg-slate-50/70 p-4 hover:bg-white hover:border-cyan-100 hover:shadow-sm transition">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="bi bi-geo-alt text-cyan-600"></i>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400"> Branch Name </p>
                        </div>
                        <p class="font-semibold text-slate-800 break-words"> {{ $bank->branch_name ?? 'N/A' }}</p>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-4 hover:bg-white hover:border-cyan-100 hover:shadow-sm transition">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="bi bi-file-earmark-text text-cyan-600"></i>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Bank Document
                            </p>
                        </div>

                        @if (!empty($bank?->bank_docs))
                            <button type="button" class="previewImage inline-flex items-center gap-2  px-3 py-2 rounded-lg bg-cyan-50 text-cyan-700 hover:bg-cyan-100 text-xs font-semibold transition" data-title="Bank Document"
                                data-src="{{ asset('storage/' . $bank->bank_docs) }}">
                                <i class="bi bi-eye-fill"></i>
                                View Document
                            </button>
                        @else
                            <p class="text-sm font-medium text-slate-400">
                                No document uploaded
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>