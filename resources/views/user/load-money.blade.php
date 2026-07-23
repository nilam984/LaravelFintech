@extends('layouts.app')

@section('title', 'Services Request')

@section('content')
    <main class="p-4 sm:p-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Load Money Request
                </h1>

                <p class="text-sm text-fintechMutedText mt-1">
                    Manage Load Money Request.
                </p>
            </div>
            <button id="openLoadMoneyModal"
                class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2.5 rounded-lg shadow transition">
                <i class="bi bi-plus-circle"></i>
                Add Request
            </button>


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

                        <option value="">-- All Status --</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>

                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button id="btnReset"
                        class="border border-slate-300 hover:bg-slate-100 px-5 py-2 rounded-lg transition">
                        Reset
                    </button>

                </div>

            </div>

        </div>


        {{-- DataTable --}}

        <div class="bg-white border rounded-xl overflow-hidden p-3">
            <table id="requestTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Utr</th>
                        <th>Mode</th>
                        <th>Receipt</th>
                        <th>Created</th>
                        <th>Remark</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>



    {{-- load money request modal --}}
    <div id="loadMoneyModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl">
            <div class="flex items-center justify-between border-b px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-800">Load Money Request</h2>
                <button id="closeLoadMoneyModal" class="text-gray-500 hover:text-red-500 text-xl">
                    &times;
                </button>
            </div>
            <form id="loadMoneyForm" enctype="multipart/form-data">
                @csrf
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Amount</label>
                        <input type="number" name="amount"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-cyan-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">UTR</label>
                        <input type="text"
                            name="utr"class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-cyan-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Mode</label>
                        <select name="mode"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-cyan-500 outline-none">
                            <option value="select payment mode">Select Payment Mode</option>
                            <option value="online">Online</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1"> Payment Receipt</label>
                        <input type="file" name="pay_receipt" class="w-full rounded-lg border border-gray-300 px-4 py-2">
                    </div>
                </div>
                <div class="border-t px-6 py-4 flex justify-end gap-3">
                    <button type="button" id="cancelLoadMoneyModal"
                        class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2.5 rounded-lg shadow transition">
                        Save Request
                    </button>
                </div>
            </form>
        </div>
    </div>


@section('scripts')
    <script>
        let table = null
        $(function() {
            table = $('#requestTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                ajax: {
                    url: "{{ route('datatable', 'loadMoney') }}",
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
                        data: 'amount',
                        name: 'amount',
                        render: function(data) {
                            return Number(data).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    {
                        data: 'utr',
                        name: 'utr'
                    },
                    {
                        data: 'mode',
                        name: 'mode',
                        render: function(data) {
                            return data.toUpperCase()
                        }
                    },
                    {
                        data: 'receipt_image',
                        name: 'receipt_image',
                        render: function(data) {

                            if (!data) {
                                return '<span class="text-gray-400">No Receipt</span>';
                            }

                            return `
                            <span class="previewImage cursor-pointer text-cyan-600"
                                data-title="Payment Receipt"
                                data-src="${data}">
                                <i class="bi bi-eye-fill text-lg"></i>
                            </span>
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
                        data: 'rejection_remark',
                        name: 'rejection_remark'
                    },
                    {
                        data: 'status',
                        className: 'text-center',
                        render: function(data, type, row) {

                            let badgeClass = '';
                            let label = data.charAt(0).toUpperCase() + data.slice(1);

                            if (data === 'approved') {
                                badgeClass = 'bg-green-100 text-green-700 border-green-200';
                            } else if (data === 'rejected') {
                                badgeClass = 'bg-red-100 text-red-700 border-red-200';
                            } else {
                                badgeClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                            }

                            return `
                                <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold ${badgeClass}">
                                    ${label}
                                </span>
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
    </script>

    <script>
        $(document).ready(function() {
            $('#openLoadMoneyModal').click(function() {
                $('#loadMoneyModal').removeClass('hidden').addClass('flex');
            });
            $('#closeLoadMoneyModal, #cancelLoadMoneyModal').click(function() {
                $('#loadMoneyModal').removeClass('flex').addClass('hidden');
                $('#loadMoneyForm')[0].reset();
            });
            $('#loadMoneyModal').click(function(e) {
                if ($(e.target).is('#loadMoneyModal')) {
                    $('#loadMoneyModal').removeClass('flex').addClass('hidden');
                    $('#loadMoneyForm')[0].reset();
                }
            });
            $('#loadMoneyForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('load-money.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#loadMoneyForm button[type="submit"]')
                            .prop('disabled', true)
                            .text('Saving...');
                    },
                    success: function(response) {
                        if (response.status) {
                            ToastEngine.show(response.message, "success");
                            $('#loadMoneyModal')
                                .removeClass('flex')
                                .addClass('hidden');
                            $('#loadMoneyForm')[0].reset();
                            if (typeof table !== 'undefined') {
                                table.ajax.reload(null, false);
                            }
                        } else {
                            ToastEngine.show(response.message, "error");
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorText = '';
                            $.each(errors, function(key, value) {
                                errorText += value[0] + '<br>';
                            });
                            ToastEngine.show(errorText, "error");
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            ToastEngine.show(xhr.responseJSON.message, "error");
                        } else {
                            ToastEngine.show("Something went wrong!", "error");
                        }
                    },
                    complete: function() {
                        $('#loadMoneyForm button[type="submit"]')
                            .prop('disabled', false)
                            .text('Save Request');

                    }
                });
            });

        });
    </script>
@endsection
@endsection
