@extends('layouts.app')

@section('title', 'Services Request')

@section('content')
    <main class="p-4 sm:p-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Service Request
                </h1>

                <p class="text-sm text-fintechMutedText mt-1">
                    Manage Service request.
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

                <div>
                    <select id="user"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm bg-white focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">
                        <option value="">-- All User --</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
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
            <table id="usersTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>


@section('scripts')
    <script>
        let table = null
        $(function() {
            table = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                ajax: {
                    url: "{{ route('datatable', 'serviceRequests') }}",
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
                        data: 'service.service_name',
                        name: 'service.service_name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            return data == 'active' ?
                                '<span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">Active</span>' :
                                (data == 'inactive' ?
                                    '<span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs">Inactive</span>' :
                                    '<span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs">Pending</span>'
                                );
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
                        data: 'status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `
                                <select
                                    class="service-status w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 outline-none transition"
                                    data-id="${row.id}"
                                    data-status="${data}">

                                    <option value="active" ${data === 'active' ? 'selected' : ''}>
                                        Active
                                    </option>

                                    <option value="inactive" ${data === 'inactive' ? 'selected' : ''}>
                                        Inactive
                                    </option>
                                     <option value="pending" ${data === 'pending' ? 'selected' : ''}>
                                        Pending
                                    </option>
                                </select>
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
                table.search('').ajax.reload();
            });
        });

        // For Change user status
        $(document).on('change', '.service-status', function() {
            changeStatus(this, "{{ route('service-requests.change-status') }}", "Service", table);
        });

        $(function() {

            // Request service
            $(document).on('click', '.request-service-btn', function() {


                let serviceId = $(this).data('id');
                let serviceName = $(this).data('name');
                Swal.fire({
                    title: 'Confirm Request',
                    html: `Are you sure you want to request the <b>${serviceName}</b> service?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#06B6D4'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('user.request-service') }}",
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                service_id: serviceId
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#serviceModal')
                                        .removeClass('flex')
                                        .addClass('hidden');

                                    ToastEngine.show(response.message, "success");
                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    ToastEngine.show(response.message, "error");
                                }
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    let errorText = "";
                                    $.each(errors, function(key, value) {
                                        errorText += value[0] + "<br>";
                                    });
                                    ToastEngine.show(errorText, "error");
                                } else {
                                    ToastEngine.show(xhr.responseJSON.message, "error");
                                }
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
@endsection
