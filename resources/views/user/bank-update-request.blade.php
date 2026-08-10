@extends('layouts.app')

@section('title', 'Bank Update Request')

@section('content')
    <main class="p-4 sm:p-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Bank Update Request
                </h1>

                <p class="text-sm text-fintechMutedText mt-1">
                   Manage Bank Update Request.
                </p>
            </div>

            {{-- <a href="javascript:void(0)" id="openServiceModal"
                class="bg-fintechCyan hover:bg-fintechCyanHover text-white px-4 py-2 rounded-lg">
                <i class="bi bi-gear"></i>
                Services
            </a> --}}

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
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>

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
            <table id="bankTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Request Remark</th>
                        <th>Reject Remark</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>


@section('scripts')
    <script>
        let table = null
        $(function() {
            table = $('#bankTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                ajax: {
                    url: "{{ route('datatable', 'bankUpdateRequest') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $('#status').val();
                        d.user_id = $('#user').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'request_remark',
                        name: 'request_remark',
                        render: function(data, type, row) {
                            if (!data) {
                                return '-';
                            }

                            return `
                                <button
                                    type="button"
                                    class="view-remark cursor-pointer text-cyan-600"
                                    data-remark="${$('<div>').text(data).html()}"
                                    title="Request Remark">
                                    <i class="bi bi-eye-fill text-lg"></i>
                                </button>
                            `;
                        }
                    },
                    {
                        data: 'reject_remark',
                        name: 'reject_remark',
                        render: function(data, type, row) {
                            if (!data) {
                                return '-';
                            }

                            return `
                                <button
                                    type="button"
                                    class="view-remark cursor-pointer text-cyan-600"
                                    data-remark="${$('<div>').text(data).html()}"
                                    title="Reject Remark">
                                    <i class="bi bi-eye-fill text-lg"></i>
                                </button>
                            `;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            switch (data) {
                                case 'approved':
                                    return '<span class="px-2 py-1 rounded bg-green-200 text-green-700 text-xs">Approved</span>';
                                case 'rejected':
                                    return '<span class="px-2 py-1 rounded bg-red-200 text-red-700 text-xs">Rejected</span>';
                                case 'updated':
                                    return '<span class="px-2 py-1 rounded bg-green-200 text-green-700 text-xs">Updated</span>';
                                case 'pending':
                                default:
                                    return '<span class="px-2 py-1 rounded bg-yellow-200 text-yellow-700 text-xs">Pending</span>';
                            }
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

            $('#search').keyup(function() {
                table.search(this.value).draw();
            });

            $('#status').change(function() {
                table.ajax.reload();
            });

            $('#user').change(function() {
                table.ajax.reload();
            });

            $('#btnReset').click(function() {
                $('#search').val('');
                $('#status').val('');
                table.search('').ajax.reload();
            });
        });
    </script>
@endsection
@endsection
