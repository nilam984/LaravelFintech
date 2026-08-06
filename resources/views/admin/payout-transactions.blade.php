@extends('layouts.app')

@section('title', 'Payout Transactions')

@section('content')
    <main class="p-4 sm:p-8 space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Payout Transactions
                </h1>
                <p class="text-sm text-fintechMutedText mt-1">
                    View and manage all payout transactions.
                </p>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" id="search_key" placeholder="Search..."class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">
                <select id="status" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">
                    <option value="">All Status</option>
                    <option value="initiated">Initiated</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="success">Success</option>
                    <option value="failed">Failed</option>
                </select>
                <input type="date" id="from_date" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">
                <input type="date" id="to_date" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">
                <button id="btnReset" class="border border-slate-300 hover:bg-slate-100 rounded-lg">
                    Reset
                </button>

            </div>

        </div>

        <div class="bg-white border rounded-xl overflow-hidden p-3">
            <table id="payoutTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="min-w-[150px]">User</th>
                        <th class="min-w-[180px]">Beneficiary</th>
                        <th class="min-w-[100px]">Client Ref</th>
                        <th class="min-w-[100px]">Bank</th>
                        <th class="min-w-[150px]">Account</th>
                        <th class="min-w-[100px]">IFSC</th>
                        <th>Amount</th>
                        <th>Fee</th>
                        <th>GST</th>
                        <th class="min-w-[120px]">Final Amount</th>
                        <th>UTR</th>
                        <th>Status</th>
                        <th class="min-w-[200px]">Created At</th>
                        <th>View</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>
@endsection


@section('scripts')

    <script>
        let table;

        $(function() {

            table = $("#payoutTable").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('datatable', 'payoutTransactions') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $("#status").val();
                        d.search_key = $("#search_key").val();
                        d.from_date = $("#from_date").val();
                        d.to_date = $("#to_date").val();

                    }
                },

                columns: [
                    {data: 'id'},
                    {data: 'user.name', defaultContent: '--'},
                    {data: 'beneficiary_name'},
                    {data: 'client_ref_id', defaultContent: '--'},
                    {data: 'bank_name'},
                    {
                        data: 'account_number',
                        render: function(data) {
                            if (data == null) return "--";
                            return "XXXXXX" + data.slice(-4);

                        }
                    },
                    {data: 'ifsc_code'},
                    {data: 'amount'},
                    {data: 'fee'},
                    {data: 'tax'},
                    {data: 'final_amount'},
                    {data: 'utr', defaultContent: '--'},

                    {
                        data: 'status',
                        render: function(data) {
                            if (data == "success")
                                return '<span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">Success</span>';
                            if (data == "failed")
                                return '<span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs">Failed</span>';
                            if (data == "processing")
                                return '<span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs">Processing</span>';
                            if (data == "pending")
                                return '<span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs">Pending</span>';
                            return '<span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-xs">Initiated</span>';
                        }
                    },
                    {
                        data: 'created_at',
                        render: function(data) {
                            return formatDateTime(data);

                        }

                    },

                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<a href="javascript:void(0)"><i class="bi bi-eye-fill text-cyan-600"></i></a>`;
                        }
                    }
                ]
            });


            $("#search_key").keyup(function() {
                table.ajax.reload();
            });
            $("#status").change(function() {
                table.ajax.reload();
            });
            $("#from_date,#to_date").change(function() {
                table.ajax.reload();
            });
            $("#btnReset").click(function() {
                $("#search_key").val("");
                $("#status").val("");
                $("#from_date").val("");
                $("#to_date").val("");
                table.ajax.reload();
            });
        });
    </script>

@endsection
