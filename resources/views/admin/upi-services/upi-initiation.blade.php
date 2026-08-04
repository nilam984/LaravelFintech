@extends('layouts.app')

@section('title', 'UPI Initiation')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between mb-5">
            <h4 class="text-xl font-semibold text-gray-800">
                UPI Initiation
            </h4>
        </div>

        <div class="overflow-x-auto">

            <!-- Filters -->
            <!-- Filters -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 mb-3">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                    <!-- User -->
                    <select id="user_id" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm bg-white">
                        <option value="">All Users</option>

                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>

                    <!-- Search -->
                    <input type="text" id="search_key" placeholder="Search..."
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">

                    <!-- From Date -->
                    <input type="date" id="from_date"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">

                    <!-- To Date -->
                    <input type="date" id="to_date"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">

                    <!-- Reset -->
                    <button id="resetBtn" class="border border-slate-300 hover:bg-slate-100 rounded-lg">
                        Reset
                    </button>

                </div>
            </div>

            <!-- Table -->
            <div class="bg-white border rounded-xl overflow-hidden p-3">

                <table class="min-w-full" id="upiInitiationTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th>#</th>
                            <th>Client Name</th>
                            <th>Email</th>
                            <th>Order ID</th>
                            <th>Reference ID</th>
                            <th>Mobile</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="min-w-[180px]">Created At</th>
                        </tr>
                    </thead>
                </table>

            </div>

        </div>

    </div>

@endsection


@section('scripts')

    <script>
        let table;

        $(function() {
            table = $('#upiInitiationTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('datatable', 'upiInitiation') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.user_id = $('#user_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.search_key = $('#search_key').val();

                    }
                },

                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
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
                        data: 'status',
                        render: function() {

                            return `
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                            Initiated
                        </span>
                    `;

                        }
                    },

                    {
                        data: 'created_at',
                        render: function(data) {
                            return formatDateTime(data);
                        }
                    }

                ]

            });
            $('#user_id').change(function() {
                table.ajax.reload();
            });
            $('#search_key').keyup(function() {
                table.ajax.reload();
            });
            $('#from_date, #to_date').change(function() {
                table.ajax.reload();
            });
            $('#resetBtn').click(function() {
                $('#user_id').val('');
                $('#search_key').val('');
                $('#from_date').val('');
                $('#to_date').val('');
                table.ajax.reload();

            });

        });
    </script>

@endsection
