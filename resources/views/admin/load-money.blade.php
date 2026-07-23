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
                    Manage Load Money request.
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
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>

                    </select>
                </div>

                <div>
                    <select id="user"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">
                        <option value="">-- All User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
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
            <table id="requestTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
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
                        d.user_id = $('#user').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
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

                            if (data === 'pending') {
                                return `
                                <select
                                    class="loadMoney w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 outline-none transition"
                                    data-id="${row.id}"
                                    data-status="${data}">

                                    <option value="pending">
                                        Pending
                                    </option>


                                    <option value="approved">
                                        Approved
                                    </option>

                                    <option value="rejected">
                                        Rejected
                                    </option>

                                </select>
                            `;
                            }

                            let badgeClass = '';
                            let label = data.charAt(0).toUpperCase() + data.slice(1);

                            if (data === 'approved') {
                                badgeClass = 'bg-green-100 text-green-700 border-green-200';
                            } else if (data === 'rejected') {
                                badgeClass = 'bg-red-100 text-red-700 border-red-200';
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

            $('#user').change(function() {
                table.ajax.reload();
            });

            $('#btnReset').click(function() {
                $('#search').val('');
                $('#status').val('');
                $('#user').val('');
                table.search('').ajax.reload();
            });
        });



        $(document).on('change', '.loadMoney', function() {

            let select = $(this),
                id = select.data('id'),
                oldStatus = 'pending',
                status = select.val();

            Swal.fire({
                title: `${status === 'approved' ? 'Approve' : 'Reject'} Request`,
                icon: status === 'approved' ? 'question' : 'warning',
                input: status === 'rejected' ? 'textarea' : null,
                inputPlaceholder: 'Enter rejection remark...',
                inputValidator: value =>
                    status === 'rejected' && !value ? 'Remark is required.' : undefined,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#06B6D4'
            }).then(result => {

                if (!result.isConfirmed) {
                    return select.val(oldStatus);
                }
                $.post("{{ route('action.load.money') }}", {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    status: status,
                    remark: result.value ?? ''
                }, function(res) {

                    ToastEngine.show(res.message, res.success ? 'success' : 'error');

                    if (res.success) {
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        select.val(oldStatus);
                    }

                }).fail(function(xhr) {

                    select.val(oldStatus);
                    ToastEngine.show(xhr.responseJSON?.message || 'Something went wrong.', 'error');

                });
            });
        });
    </script>
@endsection
@endsection
