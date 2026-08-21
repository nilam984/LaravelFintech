@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <main class="p-4 sm:p-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Users
                </h1>

                <p class="text-sm text-fintechMutedText mt-1">
                    Manage all registered users.
                </p>
            </div>

            @if (Auth::user()->role === 'reseller')
                <a href="javascript:void(0)" id="btnAddUser"
                    class="bg-fintechCyan hover:bg-fintechCyanHover text-white px-4 py-2 rounded-lg">
                    <i class="bi bi-plus-lg"></i>
                    Add User
                </a>
            @endif
        </div>
        {{-- Filters --}}

        <div class="bg-white border border-slate-200 rounded-xl p-4">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div>
                    <input type="text" id="search" placeholder="Search..."
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">
                </div>

                <div>
                    <select id="status"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">

                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>
                </div>

                <div class="flex items-center gap-2">

                    {{-- <button id="btnSearch"
                        class="bg-fintechCyan hover:bg-fintechCyanHover text-white px-5 py-2 rounded-lg transition">

                        Search

                    </button> --}}

                    <button id="btnReset"
                        class="border border-slate-300 hover:bg-slate-100 px-5 py-2 rounded-lg transition">
                        Reset
                    </button>

                </div>

            </div>

        </div>


        {{-- DataTable --}}

        <div class="bg-white border rounded-xl overflow-hidden p-3">
            <table id="usersTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th class="min-w-[180px]">Email Verified</th>
                        <th class="min-w-[150px]">Registered By</th>
                        <th class="min-w-[150px]">Reseller Name</th>
                        <th>View</th>
                        <th class="min-w-[180px]">Created</th>
                        <th class="min-w-[180px]">Updated</th>
                        <th class="min-w-[100px]">Action</th>
                    </tr>
                </thead>
            </table>
        </div>


        {{-- Add User --}}
        <div id="addUserModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
            <div class="w-full max-w-4xl max-h-[92vh] overflow-y-auto rounded-xl bg-white shadow-xl">

                <div class="flex items-center justify-between border-b px-6 py-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">Add User</h2>
                        <p id="modalStepDescription" class="text-sm text-slate-500">Enter customer details.</p>
                    </div>
                    <button type="button" id="closeUserModal"
                        class="text-slate-500 hover:text-red-500 text-xl">&times;</button>
                </div>

                <div class="px-6 pt-5">
                    <div class="flex items-center">
                        {{-- Step 1 --}}
                        <div class="flex items-center flex-1">
                            <div id="stepIndicator1"
                                class="step-indicator w-8 h-8 rounded-full bg-cyan-600 text-white flex items-center justify-center text-sm font-semibold">
                                1
                            </div>
                            <div class="ml-2">
                                <p class="text-xs font-semibold text-slate-700">Customer</p>
                            </div>
                        </div>
                        <div id="stepLine1" class="h-1 flex-1 mx-3 bg-slate-200 rounded"></div>
                        {{-- Step 2 --}}
                        <div class="flex items-center flex-1">
                            <div id="stepIndicator2"
                                class="step-indicator w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-sm font-semibold">
                                2
                            </div>
                            <div class="ml-2">
                                <p class="text-xs font-semibold text-slate-500">Services</p>
                            </div>
                        </div>
                        <div id="stepLine2" class="h-1 flex-1 mx-3 bg-slate-200 rounded"></div>
                        {{-- Step 3 --}}
                        <div class="flex items-center">
                            <div id="stepIndicator3"
                                class="step-indicator w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-sm font-semibold">
                                3
                            </div>
                            <div class="ml-2">
                                <p class="text-xs font-semibold text-slate-500">Review & Pay</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="addUserForm" enctype="multipart/form-data">
                    @csrf
                    <div id="userStep1" class="user-step p-6">
                        <div class="mb-5">
                            <h3 class="text-base font-semibold text-slate-800">Customer Details</h3>
                            <p class="text-sm text-slate-500">Enter the details of the customer you are onboarding.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> Name </label>
                                <input type="text" name="name" id="user_name" placeholder="Enter name"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                <span class="text-red-500 text-xs error-name"></span>
                            </div>
                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> Email </label>
                                <input type="email" name="email" id="user_email" placeholder="Enter email"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                <span class="text-red-500 text-xs error-email"></span>
                            </div>
                            {{-- Mobile --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1"> Mobile </label>
                                <input type="text" name="mobile" id="user_mobile" placeholder="Enter mobile number"
                                    maxlength="10"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                <span class="text-red-500 text-xs error-mobile"></span>
                            </div>
                        </div>
                        {{-- PAN --}}
                        <div class="border-t pt-5 mt-5">
                            <h3 class="text-sm font-semibold text-slate-700 mb-3">PAN Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- PAN Number --}}
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1"> PAN Number </label>
                                    <input type="text" name="pan_no" id="pan_no" placeholder="Enter PAN number"
                                        maxlength="10"
                                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm uppercase focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                    <span class="text-red-500 text-xs error-pan_no"></span>
                                </div>
                                {{-- PAN Image --}}
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1"> PAN Image </label>
                                    <input type="file" name="pan_image" id="pan_image" accept="image/*"
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none" />
                                    <span class="text-red-500 text-xs error-pan_image"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="userStep2" class="user-step hidden p-6">
                        <div class="mb-5">
                            <h3 class="text-base font-semibold text-slate-800">Select Services</h3>
                            <p class="text-sm text-slate-500">Select one or more services required by the customer.</p>
                        </div>


                        <div id="serviceList" class="space-y-3">

                        </div>

                        <div class="mt-5 rounded-xl bg-slate-50 border border-slate-200 p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-slate-500">Selected Services</p>
                                    <p id="selectedServiceCount" class="text-sm font-semibold text-slate-800">0 Services
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-500">Total Setup Cost</p>
                                    <p id="serviceSelectionTotal" class="text-lg font-bold text-cyan-600">₹0.00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="userStep3" class="user-step hidden p-6">
                        <div class="mb-5">
                            <h3 class="text-base font-semibold text-slate-800">Review & Pay</h3>
                            <p class="text-sm text-slate-500">Verify the customer and service details before payment.</p>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-5 mb-5">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-slate-800">Customer Information</h4>
                                <button type="button" id="editCustomerDetails"
                                    class="text-xs text-cyan-600 hover:text-cyan-800">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs text-slate-500">Name</p>
                                    <p id="summaryName" class="text-sm font-medium text-slate-800">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Email</p>
                                    <p id="summaryEmail" class="text-sm font-medium text-slate-800 break-all">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Mobile</p>
                                    <p id="summaryMobile" class="text-sm font-medium text-slate-800">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">PAN Number</p>
                                    <p id="summaryPan" class="text-sm font-medium text-slate-800">-</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 overflow-hidden">
                            <div class="bg-slate-50 px-5 py-3 border-b">
                                <h4 class="text-sm font-semibold text-slate-800">Selected Services</h4>
                            </div>


                            <div id="finalServiceList" class="divide-y divide-slate-100">{{-- JS will populate this --}}</div>

                            {{-- Payment Summary --}}
                            <div class="bg-slate-50 px-5 py-4 space-y-3">

                                {{-- Service Setup Cost --}}
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-600">
                                        Service Setup Cost
                                    </span>

                                    <span id="finalSetupCost" class="text-sm font-semibold text-slate-800">
                                        ₹0.00
                                    </span>
                                </div>

                                {{-- GST --}}
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-600">
                                        GST (18%)
                                    </span>

                                    <span id="finalGst" class="text-sm font-semibold text-slate-800">
                                        ₹0.00
                                    </span>
                                </div>

                                {{-- Total Payable --}}
                                <div class="border-t border-slate-200 pt-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold text-slate-700">
                                            Total Payable
                                        </span>

                                        <span id="finalTotal" class="text-xl font-bold text-cyan-600">
                                            ₹0.00
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- Payment Notice --}}
                        <div class="mt-5 flex gap-3 rounded-lg border border-blue-200 bg-blue-50 p-4">
                            <div class="text-blue-600 text-lg"><i class="bi bi-shield-check"></i></div>
                            <div>
                                <p class="text-sm font-semibold text-blue-800">Secure Payment</p>
                                <p class="text-xs text-blue-700 mt-1">
                                    Your customer will be onboarded after successful payment verification.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3 border-t px-6 py-4 bg-slate-50 rounded-b-xl">
                        {{-- Left --}}
                        <div>
                            <button type="button" id="backUserStep"
                                class="hidden border border-slate-300 hover:bg-slate-100 px-5 py-2 rounded-lg">
                                <i class="bi bi-arrow-left"></i> Back
                            </button>
                        </div>
                        {{-- Right --}}
                        <div class="flex gap-3">
                            <button type="button" id="cancelUserModal"
                                class="border border-slate-300 hover:bg-slate-100 px-5 py-2 rounded-lg">
                                Cancel
                            </button>
                            <button type="button" id="nextUserStep"
                                class="bg-fintechCyan hover:bg-fintechCyanHover text-white px-4 py-2 rounded-lg">
                                Continue <i class="bi bi-arrow-right"></i>
                            </button>
                            <button type="button" id="payUserBtn"
                                class="hidden bg-fintechCyan hover:bg-fintechCyanHover text-white px-4 py-2 rounded-lg">
                                Pay <span id="payButtonAmount">₹0.00</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </main>

@section('scripts')
    <script>
        let table = null
        $(function() {
            table = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('datatable', 'users') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $('#status').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'email',
                        name: 'email'
                    },

                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            return data == 1 ?
                                '<span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">Active</span>'

                                :
                                '<span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs">Inactive</span>';
                        }
                    },
                    
                    {
                        data: 'email_verified_at',
                        name: 'email_verified_at',
                        render: function(data) {
                            return formatDateTime(data) == '----' ?
                                '<span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs">NO</span>' :
                                formatDateTime(data);
                        }
                    },
                    {
                        data: 'registered_by',
                        name: 'registered_by',
                        render: function(data) {
                            if (!data) return '';

                            let capitalized = data.charAt(0).toUpperCase() + data.slice(1);

                            let badgeClass = 'bg-gray-100 text-gray-800';
                            if (data === 'admin') {
                                badgeClass = 'bg-yellow-200 text-yellow-800';
                            } else if (data === 'reseller') {
                                badgeClass = 'bg-blue-200 text-blue-800';
                            } else if (data === 'self') {
                                badgeClass = 'bg-green-200 text-green-800';
                            }

                            return `<span class="px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeClass}">${capitalized}</span>`;
                        }
                    },
                    {
                        data: 'reseller.name',
                        name: 'reseller.name'
                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {

                            let url = "{{ route('user.detail', ['id' => ':id']) }}";
                            url = url.replace(':id', row.id);

                            return `
                                <a href="${url}" class="text-primary" title="View User">
                                    <i class="bi bi-eye-fill text-lg text-cyan-600"></i>
                                </a>
                            `;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            return formatDateTime(data);
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        render: function(data) {
                            return formatDateTime(data);
                        }
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `
                                    <select
                                        class="user-status w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 outline-none transition"
                                        data-id="${row.id}" 
                                        data-status="${data}">

                                        <option value="1" ${data == 1 ? 'selected' : ''}>
                                            Active
                                        </option>

                                        <option value="0" ${data == 0 ? 'selected' : ''}>
                                            Inactive
                                        </option>
                                    </select>
                                `;
                        }
                    }
                ]

            });

            $('#search').keyup(function() {
                table.search(this.value).draw();
            });

            $('#status').change(function() {
                table.ajax.reload();
            });

            $('#btnReset').click(function() {
                $('#search').val('');
                $('#status').val('');
                table.search('').ajax.reload();
            });
        });

        // For Change user status
        $(document).on('change', '.user-status', function() {
            changeStatus(this, "{{ route('users.change-status') }}", "User", table);
        });


        $('#btnAddUser').click(function() {
            $('#addUserForm')[0].reset();
            $('#addUserModal').removeClass('hidden').addClass('flex');
        });


        $('#closeUserModal, #cancelUserModal').click(function() {
            $('#addUserModal').removeClass('flex').addClass('hidden');
        });
        $('#addUserModal, #editUserModal').click(function(e) {
            if (e.target === this) {
                $(this).removeClass('flex').addClass('hidden');
            }
        });
    </script>

    <script>
        $(document).ready(function() {

            let currentStep = 1;

            //    OPEN MODAL
            $('#btnAddUser').on('click', function() {
                resetUserWizard();

                $('#addUserModal')
                    .removeClass('hidden')
                    .addClass('flex');
            });


            $('#closeUserModal, #cancelUserModal').on('click', function() {

                $('#addUserModal')
                    .removeClass('flex')
                    .addClass('hidden');
                resetUserWizard();
            });



            $('#nextUserStep').on('click', function() {
                if (currentStep === 1) {
                    if (!validateCustomerStep()) {
                        return;
                    }
                    validateUserOnServer();
                    loadServices();
                    return;
                }
                if (currentStep === 2) {
                    if (!validateServiceStep()) {
                        return;
                    }

                    prepareFinalSummary();
                    currentStep = 3;
                    updateUserWizard();
                }
            });


            $('#backUserStep').on('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    loadServices();
                    updateUserWizard();
                }
            });

            //  EDIT CUSTOMER DETAIL

            $('#editCustomerDetails').on('click', function() {
                currentStep = 1;
                updateUserWizard();
            });

            //  SERVICE CHECKBOX CHANGE

            $(document).on('change', '.service-checkbox', function() {
                updateServiceTotal();
            });

            //  UPDATE SERVICE TOTAL

            function updateServiceTotal() {

                let total = 0;
                let count = 0;

                $('.service-checkbox:checked').each(function() {

                    let amount = parseFloat(
                        $(this).data('service-amount')
                    ) || 0;

                    total += amount;
                    count++;
                });


                $('#selectedServiceCount').text(
                    count + (count === 1 ? ' Service' : ' Services')
                );

                $('#serviceSelectionTotal').text(
                    formatCurrency(total)
                );
            }

            // CUSTOMER VALIDATION

            function validateCustomerStep() {
                clearUserErrors();
                let valid = true;
                let name = $('#user_name').val().trim();
                let email = $('#user_email').val().trim();
                let mobile = $('#user_mobile').val().trim();
                let pan = $('#pan_no').val().trim().toUpperCase();

                let panImageInput = $('#pan_image')[0];
                let panImage = panImageInput && panImageInput.files.length > 0;

                if (name === '') {
                    $('.error-name').text(
                        'Please enter customer name.'
                    );
                    valid = false;
                }

                if (email === '') {
                    $('.error-email').text(
                        'Please enter email.'
                    );
                    valid = false;
                } else if (
                    !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
                ) {

                    $('.error-email').text(
                        'Please enter a valid email.'
                    );
                    valid = false;
                }

                // Mobile
                if (mobile === '') {
                    $('.error-mobile').text(
                        'Please enter mobile number.'
                    );
                    valid = false;
                } else if (!/^[6-9][0-9]{9}$/.test(mobile)) {
                    $('.error-mobile').text(
                        'Please enter a valid 10-digit mobile number.'
                    );
                    valid = false;
                }

                // PAN
                if (pan === '') {
                    $('.error-pan_no').text(
                        'Please enter PAN number.'
                    );
                    valid = false;
                } else if (
                    !/^[A-Z]{5}[0-9]{4}[A-Z]$/.test(pan)
                ) {
                    $('.error-pan_no').text(
                        'Please enter a valid PAN number.'
                    );
                    valid = false;
                }

                // PAN Image
                if (!panImage) {
                    $('.error-pan_image').text(
                        'Please upload PAN image.'
                    );
                    valid = false;
                }
                return valid;
            }

            //  SERVICE VALIDATION

            function validateServiceStep() {
                let selectedServices =
                    $('.service-checkbox:checked').length;
                if (selectedServices === 0) {
                    ToastEngine.show(
                        'Please select at least one service.',
                        'error'
                    );
                    return false;
                }
                return true;
            }


            //    PREPARE FINAL SUMMARY
            function prepareFinalSummary() {
                $('#summaryName')
                    .text($('#user_name').val());
                $('#summaryEmail')
                    .text($('#user_email').val());
                $('#summaryMobile')
                    .text($('#user_mobile').val());
                $('#summaryPan')
                    .text($('#pan_no').val().toUpperCase());

                let html = '';
                let total = 0;
                $('.service-checkbox:checked').each(function() {

                    let serviceName =
                        $(this).data('service-name');

                    let amount =
                        parseFloat(
                            $(this).data('service-amount')
                        ) || 0;

                    total += amount;

                    html += `
                                <div class="px-5 py-4 flex items-center justify-between">

                                    <div class="flex items-center gap-3">

                                        <div class="w-8 h-8 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center">
                                            <i class="bi bi-check-lg"></i>
                                        </div>

                                        <div>
                                            <p class="text-sm font-medium text-slate-800">
                                                ${serviceName}
                                            </p>

                                            <p class="text-xs text-slate-500">
                                                Setup Cost
                                            </p>
                                        </div>

                                    </div>

                                    <p class="text-sm font-semibold text-slate-800">
                                        ${formatCurrency(amount)}
                                    </p>

                                </div>
                            `;
                });


                $('#finalServiceList').html(html);

                // GST Calculation
                const gstRate = 18;
                const gstAmount = total * gstRate / 100;
                const grandTotal = total + gstAmount;

                // Service Setup Cost
                $('#finalSetupCost').text(
                    formatCurrency(total)
                );

                // GST Amount
                $('#finalGst').text(
                    formatCurrency(gstAmount)
                );

                // Final Payable Amount
                $('#finalTotal').text(
                    formatCurrency(grandTotal)
                );

                $('#payButtonAmount').text(
                    formatCurrency(grandTotal)
                );
            }

            //    UPDATE WIZARD UI
            function updateUserWizard() {

                // Hide all steps
                $('.user-step').addClass('hidden');

                // Show current step
                $('#userStep' + currentStep)
                    .removeClass('hidden');

                // Reset indicators
                $('.step-indicator')
                    .removeClass('bg-cyan-600 text-white')
                    .addClass('bg-slate-200 text-slate-500');

                // Activate indicators
                for (let i = 1; i <= currentStep; i++) {
                    $('#stepIndicator' + i)
                        .removeClass('bg-slate-200 text-slate-500')
                        .addClass('bg-cyan-600 text-white');
                }

                // Reset lines
                $('#stepLine1, #stepLine2')
                    .removeClass('bg-cyan-600')
                    .addClass('bg-slate-200');

                if (currentStep >= 2) {
                    $('#stepLine1')
                        .removeClass('bg-slate-200')
                        .addClass('bg-cyan-600');
                }

                if (currentStep >= 3) {
                    $('#stepLine2')
                        .removeClass('bg-slate-200')
                        .addClass('bg-cyan-600');
                }

                // Description
                if (currentStep === 1) {
                    $('#modalStepDescription').text(
                        'Enter customer details.'
                    );
                } else if (currentStep === 2) {
                    $('#modalStepDescription').text(
                        'Select the services required by the customer.'
                    );
                } else {
                    $('#modalStepDescription').text(
                        'Review details and proceed with payment.'
                    );
                }

                // Back button
                if (currentStep === 1) {
                    $('#backUserStep').addClass('hidden');
                } else {
                    $('#backUserStep').removeClass('hidden');
                }

                // Continue / Pay
                if (currentStep === 3) {
                    $('#nextUserStep').addClass('hidden');
                    $('#payUserBtn').removeClass('hidden');
                } else {
                    $('#nextUserStep').removeClass('hidden');
                    $('#payUserBtn').addClass('hidden');
                }
            }

            function loadServices() {
                $.ajax({
                    url: "{{ route('get.services') }}",
                    type: "GET",
                    success: function(response) {
                        if (response.status) {
                            $('#serviceList').html(response.html);
                            $('#selectedServiceCount').text('0 Services');
                            $('#serviceSelectionTotal').text('₹0.00');
                        }
                    },
                    error: function() {
                        $('#serviceList').html(`
                <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    Unable to load services. Please try again.
                </div>
            `);
                    }
                });
            }

            //  PAY BUTTON
            $('#payUserBtn').on('click', function() {

                let button = $(this);

                // 1. Validate Customer Details
                if (!validateCustomerStep()) {
                    currentStep = 1;
                    updateUserWizard();
                    return;
                }

                // 2. Validate Services
                let selectedServices = [];

                $('.service-checkbox:checked').each(function() {
                    selectedServices.push($(this).val());
                });

                if (selectedServices.length === 0) {
                    ToastEngine.show(
                        'Please select at least one service.',
                        'error'
                    );
                    currentStep = 2;
                    updateUserWizard();
                    return;
                }

                // 3. Calculate Total For UI

                let totalAmount = 0;
                $('.service-checkbox:checked').each(function() {
                    totalAmount += parseFloat(
                        $(this).data('service-amount')
                    ) || 0;

                });

                if (totalAmount <= 0) {
                    ToastEngine.show(
                        'Invalid payment amount.',
                        'error'
                    );
                    return;
                }

                // 4. Create FormData
                let form = $('#addUserForm')[0];
                let formData = new FormData(form);

                // 5. Add Selected Services
                // Remove any existing services first
                formData.delete('services[]');

                $('.service-checkbox:checked').each(function() {
                    formData.append(
                        'services[]',
                        $(this).val()
                    );
                });

                // 6. Disable Payment Button
                button.prop('disabled', true).html(
                    '<i class="bi bi-arrow-repeat animate-spin"></i> Initiating Payment...'
                );

                // 7. Create SabPaisa Payment
                $.ajax({

                    url: "{{ route('reseller.payment.create') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Payment Response:', response);
                        if (response.status) {

                            // SabPaisa Checkout URL

                            let checkoutUrl = response.checkout_url +
                                '?clientSecret=' +
                                encodeURIComponent(
                                    response.client_secret
                                );
                            console.log('SabPaisa Checkout URL:', checkoutUrl);

                            // Redirect To SabPaisa
                            window.location.href = checkoutUrl;
                        } else {
                            ToastEngine.show(
                                response.message ||
                                'Unable to initiate payment.',
                                'error'
                            );
                            resetPayButton();
                        }
                    },

                    error: function(xhr) {
                        console.error(
                            'Payment Error:',
                            xhr
                        );
                        let message =
                            xhr.responseJSON?.message ||
                            'Unable to initiate payment.';
                        ToastEngine.show(
                            message,
                            'error'
                        );
                        resetPayButton();
                    }
                });
            });

            function resetPayButton() {
                let button = $('#payUserBtn');
                button.prop('disabled', false).html('Pay <span id="payButtonAmount">' + $('#finalTotal').text() +
                    '</span>');
            }

            function clearUserErrors() {
                $('.error-name').text('');
                $('.error-email').text('');
                $('.error-mobile').text('');
                $('.error-pan_no').text('');
                $('.error-pan_image').text('');
            }

            function resetUserWizard() {
                currentStep = 1;
                $('#addUserForm')[0].reset();
                clearUserErrors();
                $('.service-checkbox').prop('checked', false);
                $('#selectedServiceCount').text('0 Services');
                $('#serviceSelectionTotal').text('₹0.00');
                $('#finalSetupCost').text('₹0.00');
                $('#finalGst').text('₹0.00');
                $('#finalTotal').text('₹0.00');
                $('#payButtonAmount').text('₹0.00');
                $('#finalServiceList').html('');
                updateUserWizard();
            }

            function formatCurrency(amount) {
                return '₹' + Number(amount).toLocaleString(
                    'en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );
            }

            updateUserWizard();

            function validateUserOnServer() {
                let button = $('#nextUserStep');
                let form = $('#addUserForm')[0];
                let formData = new FormData(form);
                button.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Checking...');
                $.ajax({
                    url: "{{ route('reseller.user.validate') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            currentStep = 2;
                            updateUserWizard();
                        } else {
                            ToastEngine.show(
                                response.message || 'Unable to validate customer.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        let message =
                            xhr.responseJSON?.message ||
                            'Unable to validate customer.';
                        ToastEngine.show(message, 'error');
                    },
                    complete: function() {
                        button.prop('disabled', false).html(
                            'Continue <i class="bi bi-arrow-right"></i>');
                    }
                });
            }
        });
    </script>

@endsection
@endsection
