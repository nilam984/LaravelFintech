@extends('layouts.app')

@section('title', 'Ledger Transactions')

@section('content')

    <main class="p-4 sm:p-8 space-y-6">
        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">Ledger Transactions</h1>
                <p class="text-sm text-fintechMutedText mt-1">Manage all ledger transactions.</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                {{-- User --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">User</label>
                    <select id="user_id" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm bg-white
                        focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">
                        <option value="">All Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        From Date
                    </label>
                    <input type="date" id="from_date" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm
                        focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">
                </div>

                {{-- To Date --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">To Date</label>
                    <input type="date" id="to_date" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm
                        focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">
                </div>
                {{-- Reset --}}
                <div class="flex items-end">
                    <button type="button" id="btnReset" class="border border-slate-300 hover:bg-slate-100 px-5 py-2 rounded-lg transition">
                        Reset
                    </button>
                </div>
            </div>
        </div>


        {{-- DataTable --}}
        <div class="bg-white border rounded-xl overflow-hidden p-3">
            <table id="ledgerTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="min-w-[150px]">User Name</th>
                        <th>Transaction ID</th>
                        <th>Reference ID</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th class="min-w-[150px]">Opening Balance</th>
                        <th class="min-w-[150px]">Closing Balance</th>
                        <th class="min-w-[200px]">Narration</th>
                        <th class="min-w-[180px]">Transaction Date</th>
                        <th class="min-w-[180px]">Created At</th>
                        <th class="min-w-[180px]">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#ledgerTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                scrollX: true,
                ajax: {
                    url: "{{ route('datatable', 'ledgerTransactions') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.user_id = $('#user_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },

                columns: [
                    {data: 'id',name: 'id'},
                    {data: 'user.name',name: 'user.name',defaultContent: '-'},
                    {data: 'transaction_id',name: 'transaction_id',defaultContent: '-'},
                    {data: 'reference_id',name: 'reference_id',defaultContent: '-'},
                    {data: 'amount',name: 'amount',defaultContent: '0.00',
                        render: function(data) {
                            if (data === null || data === undefined) {
                                return '₹0.00';
                            }
                            return '₹' + parseFloat(data).toFixed(2);
                        }
                    },

                    {data: 'transaction_type',name: 'transaction_type',
                        render: function(data) {
                            if (data === 'credit') {
                                return `<span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Credit</span>`;

                            }
                            if (data === 'debit') {
                                return `
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                bg-red-100 text-red-700">
                                    Debit
                                </span>`;

                            }
                            return data ?? '-';
                        }
                    },

                    {
                        data: 'opening_balance',
                        name: 'opening_balance',
                        defaultContent: '0.00',
                        render: function(data) {
                            if (data === null || data === undefined) {
                                return '₹0.00';
                            }
                            return '₹' + parseFloat(data).toFixed(2);
                        }
                    },

                    {data: 'closing_balance',name: 'closing_balance',defaultContent: '0.00',
                        render: function(data) {
                            if (data === null || data === undefined) {
                                return '₹0.00';
                            }
                            return '₹' + parseFloat(data).toFixed(2);
                        }
                    },
                    {data: 'narration',name: 'narration',defaultContent: '-'},
                    {data: 'transaction_date', name: 'transaction_date',
                        render: function(data) {
                            if (!data) {
                                return '-';
                            }
                            return formatDateTime(data);
                        }
                    },


                    // Created At
                    {data: 'created_at',name: 'created_at',
                        render: function(data) {
                            if (!data) {
                                return '-';
                            }
                            return formatDateTime(data);
                        }
                    },


                    // Updated At
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        render: function(data) {
                            if (!data) {
                                return '-';
                            }
                            return formatDateTime(data);
                        }
                    }

                ],
                order: [
                    [0, 'desc']
                ]
            });

            $('#user_id').change(function() {
                table.ajax.reload();
            });

            let searchTimer;
            $('#search_key').keyup(function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function() {
                    table.ajax.reload();
                }, 500);

            });

            $('#from_date').change(function() {
                table.ajax.reload();
            });

            $('#to_date').change(function() {
                table.ajax.reload();
            });

            $('#btnReset').click(function() {
                $('#user_id').val('');
                $('#from_date').val('');
                $('#to_date').val('');
                table.ajax.reload();

            });

        });
    </script>

@endsection
