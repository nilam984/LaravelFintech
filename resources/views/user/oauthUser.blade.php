@extends('layouts.app')

@section('title', 'OAuth & IP Whitelist Management')

@section('content')

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">API Security & Credentials</h1>
                <p class="text-sm text-fintechMutedText mt-1">Manage your OAuth Client credentials and IP Whitelist
                    configurations.</p>
            </div>
            <div class="flex items-center gap-3">
                <button id="openIpModalBtn"
                    class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl shadow-sm font-semibold transition flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    IP Whitelist
                </button>
                <button id="openGenerateModal"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2.5 rounded-xl shadow font-semibold transition flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                        </path>
                    </svg>
                    API Key
                </button>
            </div>
        </div>

        <!-- Side-by-Side Cards Grid Container -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- OAuth Credentials Card Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">OAuth Credentials</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Active API keys and client credentials assigned to services.
                        </p>
                    </div>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table id="oauthTable" class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="py-3 px-3">ID</th>
                                <th class="py-3 px-3">Service</th>
                                <th class="py-3 px-3">Client ID</th>
                                <th class="py-3 px-3">Client Secret</th>
                                <th class="py-3 px-3">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700"></tbody>
                    </table>
                </div>
            </div>

            <!-- IP Whitelist Card Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">IP Whitelist Management</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Permitted IP addresses authorized to access specific
                            services.</p>
                    </div>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table id="ipWhitelistTable" class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="py-3 px-3">ID</th>
                                <th class="py-3 px-3">Service</th>
                                <th class="py-3 px-3">IP</th>
                                <th class="py-3 px-3">Created At</th>
                                <th class="py-3 px-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Generate API Key Modal --}}
    <div id="generateModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">Generate API Credentials</h3>
                <button id="closeGenerateModal"
                    class="text-2xl text-gray-400 hover:text-red-500 transition">&times;</button>
            </div>
            <div class="p-6">
                <label class="block text-sm font-medium text-gray-600 mb-2">Select Service</label>
                <select id="service"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition">
                    <option value="">--Select Service--</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">
                            {{ $service?->service?->service_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4">
                <button id="closeGenerateModal2"
                    class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition">Cancel</button>
                <button id="generateBtn"
                    class="px-5 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white font-medium shadow-sm transition">Generate</button>
            </div>
        </div>
    </div>

    {{-- Credential Result Modal --}}
    <div id="credentialModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
            <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">API Credentials Generated</h3>
                <button id="closeCredentialModal"
                    class="text-2xl text-gray-400 hover:text-red-500 transition">&times;</button>
            </div>
            <div class="p-6 space-y-5">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-xs text-amber-800">
                    <strong>Important:</strong> Make sure to copy your client secret now. You will not be able to see it
                    again!
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Client ID</label>
                    <div class="flex shadow-sm">
                        <input readonly id="client_id"
                            class="flex-1 border border-gray-300 rounded-l-xl px-4 py-2 bg-gray-50 text-gray-800 outline-none">
                        <button
                            class="copyBtn bg-cyan-600 hover:bg-cyan-700 text-white px-5 rounded-r-xl font-medium transition"
                            data-target="client_id">Copy</button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Client Secret</label>
                    <div class="flex shadow-sm">
                        <input readonly id="client_secret"
                            class="flex-1 border border-gray-300 rounded-l-xl px-4 py-2 bg-gray-50 text-gray-800 outline-none">
                        <button
                            class="copyBtn bg-cyan-600 hover:bg-cyan-700 text-white px-5 rounded-r-xl font-medium transition"
                            data-target="client_secret">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- IP Whitelist Add/Edit Modal --}}
    <div id="ipModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4">
                <h3 id="ipModalTitle" class="text-lg font-semibold text-gray-800">Add IP Whitelist</h3>
                <button id="closeIpModal" class="text-2xl text-gray-400 hover:text-red-500 transition">&times;</button>
            </div>
            <form id="ipWhitelistForm">
                <input type="hidden" id="ip_record_id" value="">
                <div class="p-6 space-y-4">
                    <p class="text-red-500">Note : Maximum 5 IPs can be whitelisted for a Service</p>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Select Service</label>
                        <select id="ip_service" name="service"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition">
                            <option value="">--Select Service--</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">
                                    {{ $service?->service?->service_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">IP Address</label>
                        <input type="text" id="ip_address" name="ip_address" placeholder="e.g. 192.168.1.1"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition">
                    </div>
                </div>
                <div class="flex justify-end gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4">
                    <button type="button" id="closeIpModal2"
                        class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition">Cancel</button>
                    <button type="submit" id="saveIpBtn"
                        class="px-5 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white font-medium shadow-sm transition">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>

@section('scripts')
    <script>
        $("#openGenerateModal").click(function() {
            $("#generateModal").removeClass("hidden").addClass("flex");
        });
        $("#closeGenerateModal,#closeGenerateModal2").click(function() {
            $("#generateModal").removeClass("flex").addClass("hidden");
        });
        $("#closeCredentialModal").click(function() {
            $("#credentialModal").removeClass("flex").addClass("hidden");
        });

        $("#generateBtn").click(function() {
            let service = $("#service").val();
            if (service == "") {
                ToastEngine.show("Select Service", "error");
                return;
            }
            $.ajax({
                url: "{{ route('generate.client.credentials') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    service: service
                },
                success: function(res) {
                    $("#generateModal").removeClass("flex").addClass("hidden");
                    $("#client_id").val(res.data.client_id);
                    $("#client_secret").val(res.data.client_secret);
                    $("#credentialModal").removeClass("hidden").addClass("flex");
                    ToastEngine.show(res.message, "success");
                    if (typeof $('#oauthTable').DataTable === 'function') {
                        $('#oauthTable').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    ToastEngine.show(xhr.responseJSON.message, "error");
                }
            });
        });

        $(".copyBtn").click(function() {
            let target = $(this).data("target");
            navigator.clipboard.writeText($("#" + target).val());
            let btn = $(this);
            btn.text("Copied");
            setTimeout(function() {
                btn.text("Copy");
            }, 2000);
        });

        $('#oauthTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            ajax: {
                url: "{{ route('datatable', 'oauthUsers') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'service.service_name',
                    name: 'service.service_name',
                    defaultContent: '-'
                },
                {
                    data: 'client_id',
                    name: 'client_id'
                },
                {
                    data: 'client_secret',
                    name: 'client_secret',
                    render: function(data) {
                        if (!data) return '-';
                        return data.substring(0, 8) + '************' + data.substring(data.length - 8);
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
    </script>

    <script>
        let ipTable = $('#ipWhitelistTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            ajax: {
                url: "{{ route('datatable', 'IpWhitelist') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'service.service_name',
                    name: 'service.service_name',
                },
                {
                    data: 'ip',
                    name: 'ip'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data) {
                        return formatDateTime(data);
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-right',
                    render: function(data, type, row) {
                        let serviceName = row.service ? row.service.service_name : '';
                        return `
                            <div class="flex justify-end gap-2">
                                <button type="button" class="editIpBtn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded transition" 
                                    data-id="${row.id}" 
                                    data-service="${serviceName}" 
                                    data-ip="${row.ip_address}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="deleteIpBtn bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded transition" 
                                    data-id="${row.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>`;
                    }
                }
            ]
        });


        $("#openIpModalBtn").click(function() {
            $("#ipModalTitle").text("Add IP Whitelist");
            $("#ip_record_id").val("");
            $("#ip_service").val("");
            $("#ip_address").val("");
            $("#ipModal").removeClass("hidden").addClass("flex");
        });

        $("#closeIpModal, #closeIpModal2").click(function() {
            $("#ipModal").removeClass("flex").addClass("hidden");
        });


        // Edit IP 
        $(document).on("click", ".editIpBtn", function() {
            let id = $(this).data("id");
            let service = $(this).data("service");
            let ip = $(this).data("ip");

            $("#ipModalTitle").text("Edit IP Whitelist");
            $("#ip_record_id").val(id);
            $("#ip_service").val(service);
            $("#ip_address").val(ip);
            $("#ipModal").removeClass("hidden").addClass("flex");
        });


        // Delete IP 

        $(document).on("click", ".deleteIpBtn", function() {
            let recordId = $(this).data("id");

            Swal.fire({
                title: "Are you sure to Delete this IP?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#06B6D4'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete.ip') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: recordId
                        },
                        success: function(response) {
                            if (response.status) {
                                ipTable.ajax.reload()
                                ToastEngine.show(response.message, "success");
                            } else {
                                ToastEngine.show(response.message, "error");
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                ToastEngine.show(errors, "error");
                            } else {
                                ToastEngine.show(
                                    xhr.responseJSON.message ?? "Something went wrong.",
                                    "error",
                                );
                            }
                        },

                    });
                }
            });
        });


        $("#ipWhitelistForm").submit(function(e) {
            e.preventDefault();
            let recordId = $("#ip_record_id").val();
            let service = $("#ip_service").val();
            let ipAddress = $("#ip_address").val();

            if (!service || !ipAddress) {
                ToastEngine.show("Please select a service and enter an IP address", "error");
                return;
            }

            $.ajax({
                url: "{{ route('add.update.ip') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: recordId,
                    service: service,
                    ip_address: ipAddress
                },
                success: function(response) {
                    if (response.status) {
                        $("#ipModal").removeClass("flex").addClass("hidden");
                        ipTable.ajax.reload()
                        ToastEngine.show(response.message, "success");
                    } else {
                        ToastEngine.show(response.message, "error");
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        ToastEngine.show(errors, "error");
                    } else {
                        ToastEngine.show(
                            xhr.responseJSON.message ?? "Something went wrong.",
                            "error",
                        );
                    }
                },

            });
        });
    </script>
@endsection
@endsection
