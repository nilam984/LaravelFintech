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
            <table class="table table-bordered w-full" id="upiInitiationTable">
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

            $('#upiInitiationTable').DataTable({

                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('datatable', 'upiInitiation') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
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
