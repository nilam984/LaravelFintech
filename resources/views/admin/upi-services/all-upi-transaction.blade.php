@extends('layouts.app')

@section('title', 'All UPI Transaction')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between mb-5">
            <h4 class="text-xl font-semibold text-gray-800">
                All UPI Transactions
            </h4>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-bordered w-full" id="allUpiTransactionTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Order ID</th>
                        <th>Reference ID</th>
                        <th>Mobile</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>



@section('scripts')
    <script>
        $(function() {

            $('#allUpiTransactionTable').DataTable({

                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('datatable', 'allUpiTransaction') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
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

                    {
                        data: 'user.name',
                        defaultContent: '-'
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
                        data: 'amount',
                        render: function(data) {
                            return '₹' + parseFloat(data).toFixed(2);
                        }
                    },

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
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${classes}">
                ${data}
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
                    }

                ]

            });

        });
    </script>
@endsection
@endsection
