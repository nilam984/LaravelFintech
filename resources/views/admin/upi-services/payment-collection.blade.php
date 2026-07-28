@extends('layouts.app')

@section('title', 'UPI Payment Collection')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between mb-5">
            <h4 class="text-xl font-semibold text-gray-800">
                UPI Payment Collection
            </h4>
        </div>

        <div class="overflow-x-auto">

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 mb-6">

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-8 gap-4">

                    <!-- User -->
                    <div class="xl:col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            User
                        </label>

                        <select id="user_id"
                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Users</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Any Key -->
                    <div class="xl:col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Any Key
                        </label>

                        <input type="text" id="search_key" placeholder="Name / Mobile / Order ID / UTR"
                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5">
                    </div>

                    <!-- From Date -->
                    <div class="xl:col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            From Date
                        </label>

                        <input type="date" id="from_date" class="w-full rounded-xl border border-gray-300 px-4 py-2.5">
                    </div>

                    <!-- To Date -->
                    <div class="xl:col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            To Date
                        </label>

                        <input type="date" id="to_date" class="w-full rounded-xl border border-gray-300 px-4 py-2.5">
                    </div>

                    <!-- Search Button -->
                    <div class="xl:col-span-2 flex items-end gap-3">
                        <button id="searchBtn" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg">
                            Search
                        </button>

                        <button id="resetBtn"
                            class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition">
                            Reset
                        </button>
                    </div>

                </div>
            </div>

            <div class="bg-white border rounded-xl overflow-hidden p-3">
                <table class="min-w-full" id="upiCollectionTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th>#</th>
                            <th>Client Name</th>
                            <th>Email</th>
                            <th>Order ID</th>
                            <th>Reference ID</th>
                            <th>Mobile</th>
                            <th>Amount</th>
                            <th>Fee</th>
                            <th>Tax</th>
                            <th>Utr</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>



@section('scripts')
    <script>
        $(function() {

            $('#upiCollectionTable').DataTable({

                processing: true,
                serverSide: true,
                scrollX: true,

                ajax: {
                    url: "{{ route('datatable', 'upiCollection') }}",
                    type: "POST",
                    data: function(d) {

                        d._token = "{{ csrf_token() }}";
                        d.user_id = $('#user_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.search_key = $('#search_key').val();
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
                    //     defaultContent: '-'
                    // },
                    {
                        data: 'payer_name'
                    },
                    {
                        data: 'payer_email'
                    },

                    {
                        data: 'user_order_id'
                    },

                    {
                        data: 'payment_reference_id'
                    },

                    {
                        data: 'payer_mobile'
                    },

                    {
                        data: 'amount'
                    },
                    {
                        data: 'fee'
                    },
                    {
                        data: 'tax'
                    },
                    {
                        data: 'utr'
                    },

                    {
                        data: 'status',
                        render: function() {
                            return `<span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                    Success
                </span>`;
                        }
                    },

                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            return formatDateTime(data);
                        }
                    }

                ]

            });

            $('#searchBtn').click(function() {
                $('#upiCollectionTable').DataTable().draw();
            });

            $('#resetBtn').click(function() {

                $('#user_id').val('');
                $('#from_date').val('');
                $('#to_date').val('');
                $('#search_key').val('');

                $('#upiCollectionTable').DataTable().draw();

            });

        });
    </script>
@endsection
@endsection
