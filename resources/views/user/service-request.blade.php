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

            <a href="javascript:void(0)" id="openServiceModal"
                class="bg-fintechCyan hover:bg-fintechCyanHover text-white px-4 py-2 rounded-lg">
                <i class="bi bi-gear"></i>
                Services
            </a>

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

                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>

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
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>


    <!-- Open Modal Button -->
    {{-- <button id="openServiceModal" class="bg-fintechCyan hover:bg-fintechCyanHover text-white px-4 py-2 rounded-lg">
        Request Service
    </button> --}}

    <!-- Service Request Modal -->
    <div id="serviceModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 overflow-hidden">

            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">Request Services</h2>
                    <p class="text-sm text-slate-500">Select a service and send a request.</p>
                </div>

                <button id="closeServiceModal" class="text-slate-400 hover:text-slate-600 text-xl">
                    &times;
                </button>
            </div>

            <!-- Service List -->
            <div class="max-h-96 overflow-y-auto divide-y divide-slate-100">

                @foreach ($services as $service)
                    <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50">
                        <div>
                            <h3 class="font-medium text-slate-800">
                                {{ $service->service_name }}
                            </h3>
                        </div>

                        <button
                            class="request-service-btn bg-fintechCyan hover:bg-fintechCyanHover text-white px-4 py-2 rounded-lg text-sm"
                            data-id="{{ $service->id }}" data-name="{{ $service->service_name }}">
                            Request
                        </button>
                    </div>
                @endforeach

            </div>

        </div>
    </div>

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
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'service.service_name',
                        name: 'service.service_name'
                    }, {
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
                    }
                ]

            });

            $('#search').keyup(function() {
                table.search(this.value).draw();
            });

            $('#status').change(function() {
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
            changeStatus(this, "{{ route('global.service.change.status') }}", "Service", table);
        });

        $(function() {

            // Open modal
            $('#openServiceModal').on('click', function() {
                $('#serviceModal')
                    .removeClass('hidden')
                    .addClass('flex');
            });

            // Close modal
            $('#closeServiceModal, #serviceModal').on('click', function(e) {
                if (e.target.id === 'serviceModal' || e.target.id === 'closeServiceModal') {
                    $('#serviceModal')
                        .removeClass('flex')
                        .addClass('hidden');
                }
            });

            // Request service
            $(document).on('click', '.request-service-btn', function() {

                $('#serviceModal')
                    .removeClass('flex')
                    .addClass('hidden');


                let serviceId = $(this).data('id');
                let serviceName = $(this).data('name');
                Swal.fire({
                    title: 'Confirm Request',
                    text: `Are you sure you want to request the ${serviceName} service?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Request',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#06B6D4'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "1",
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                service_id: serviceId
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Requested!', response.message,
                                        'success');
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Unable to send request.', 'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
@endsection
