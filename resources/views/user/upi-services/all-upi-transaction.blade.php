@extends('layouts.app')

@section('title', 'All UPI Transaction')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between mb-5">
            <h4 class="text-xl font-semibold text-gray-800">
                All UPI Transactions
            </h4>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Current Balance</p>
                        <h2 class="text-3xl font-bold text-gray-800 mt-2">₹ 0.00</h2>
                    </div>
                </div>
            </div>


            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Settlement Due Today</p>
                        <h2 class="text-3xl font-bold text-orange-600 mt-2">₹ 0.00</h2>
                    </div>

                </div>
            </div>

            <!-- Previous Settlement -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Previous Settlement</p>
                        <h2 class="text-3xl font-bold text-green-600 mt-2">0</h2>
                        <p class="text-xs text-gray-400 mt-1">Processed Transactions</p>
                    </div>

                </div>
            </div>

            <!-- Upcoming Settlement -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Upcoming Settlement</p>
                        <h2 class="text-3xl font-bold text-purple-600 mt-2">0</h2>
                        <p class="text-xs text-gray-400 mt-1">Pending Transactions</p>
                    </div>

                </div>
            </div>

        </div>



        <div class="overflow-x-auto">
            <div class="bg-white border border-slate-200 rounded-xl p-4 mb-3">

                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">

                    <input type="text" id="search_key" placeholder="Name / Mobile / Order ID / UTR"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">

                    <select id="user_id" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">
                        <option value="">All Users</option>

                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>

                    <select id="status" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">
                        <option value="">All Status</option>
                        <option value="initiated">Initiated</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="success">Success</option>
                        <option value="failed">Failed</option>
                        <option value="expired">Expired</option>
                    </select>

                    <input type="date" id="from_date"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">

                    <input type="date" id="to_date"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">

                    <button id="resetBtn" class="border border-slate-300 hover:bg-slate-100 rounded-lg">
                        Reset
                    </button>

                </div>

            </div>
            <div class="bg-white border rounded-xl overflow-hidden p-3">
                <table class="min-w-full" id="allUpiTransactionTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th>#</th>
                            <th class="min-w-[180px]">Client Name</th>
                            <th>Email</th>
                            <th>Order ID</th>
                            <th>Reference ID</th>
                            <th>Mobile</th>
                            <th>Amount</th>
                            <th>Fee</th>
                            <th>Tax</th>
                            <th>Status</th>
                            <th>Gateway Type</th>
                            <th class="min-w-[180px]">Created At</th>
                            <th class="min-w-[180px]">Updated At</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>



@section('scripts')

    <script>
        let table;

        $(function() {

            table = $('#allUpiTransactionTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,
                autowidth: false,
                ajax: {
                    url: "{{ route('datatable', 'allUpiTransaction') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.search_key = $('#search_key').val();
                        d.user_id = $('#user_id').val();
                        d.status = $('#status').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },

                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },

                    // {
                    //     data: 'user.name',
                    //     defaultContent: '--'
                    // },

                    {data: 'payer_name'},
                    {data: 'payer_email'},
                    {data: 'user_order_id'},
                    {data: 'payment_reference_id'},
                    {data: 'payer_mobile'},
                    {
                        data: 'amount',
                        render: function(data) {
                            return parseFloat(data).toFixed(2);
                        }
                    },

                    {data: 'fee'},
                    {data: 'tax'},
                    {
                        data: 'status',
                        render: function(data) {

                            let classes = 'bg-gray-100 text-gray-700';

                            switch (data.toLowerCase()) {

                                case 'success':
                                    classes = 'bg-green-100 text-green-700';
                                    break;

                                case 'initiated':
                                    classes = 'bg-blue-100 text-blue-700';
                                    break;

                                case 'pending':
                                    classes = 'bg-yellow-100 text-yellow-700';
                                    break;

                                case 'processing':
                                    classes = 'bg-indigo-100 text-indigo-700';
                                    break;

                                case 'failed':
                                    classes = 'bg-red-100 text-red-700';
                                    break;

                                case 'expired':
                                    classes = 'bg-gray-200 text-gray-800';
                                    break;
                            }

                            return `
                            <span class="px-2 py-1 rounded text-xs ${classes}">
                                ${data}
                            </span>
                        `;
                        }
                    },

                    {data: 'gateway_type'},

                    {
                        data: 'created_at',
                        render: function(data) {
                            return formatDateTime(data);
                        }
                    },

                    {
                        data: 'updated_at',
                        render: function(data) {
                            return formatDateTime(data);
                        }
                    }

                ]

            });


            $('#search_key').keyup(function() {
                table.ajax.reload();
            });
            $('#user_id').change(function() {
                table.ajax.reload();
            });
            $('#status').change(function() {
                table.ajax.reload();
            });
            $('#from_date, #to_date').change(function() {
                table.ajax.reload();
            });
            $('#resetBtn').click(function() {
                $('#search_key').val('');
                $('#user_id').val('');
                $('#status').val('');
                $('#from_date').val('');
                $('#to_date').val('');
                table.ajax.reload();
            });
        });
    </script>

@endsection
@endsection
