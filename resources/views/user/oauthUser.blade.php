@extends('layouts.app')

@section('title', 'OAuth API Key')

@section('content')

    <div class="min-h-screen bg-gray-100 py-6">
        <div class="flex items-center justify-between mb-6 px-5">
            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">OAuth API Credentials</h1>
                <p class="text-sm text-fintechMutedText mt-1">Generate Client ID & Client Secret</p>
            </div>
            <button id="openGenerateModal"
                class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2.5 rounded-xl shadow font-semibold transition">Generate
                API Key</button>
        </div>
        {{-- <div class="bg-white rounded-2xl shadow-md p-10 text-center">
            <div class="flex justify-center mb-5">
                <div class="w-20 h-20 rounded-full bg-cyan-100 flex items-center justify-center">
                    <i class="bi bi-key text-4xl text-cyan-600"></i>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-700">OAuth API Credentials</h3>
            <p class="text-gray-500 mt-2">Generate secure API credentials for your selected service.</p>
        </div> --}}
        <div class="bg-white rounded-xl shadow p-5 mt-6">

            <h3 class="text-lg font-semibold mb-4">
                OAuth Credentials
            </h3>

            <table id="oauthTable" class="w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service</th>
                        <th>Client ID</th>
                        <th>Client Secret</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>



    {{-- Generate Modal --}}
    <div id="generateModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold">Generate API Credentials</h3>
                <button id="closeGenerateModal" class="text-2xl text-gray-500 hover:text-red-500">
                    &times;
                </button>
            </div>
            <div class="p-6">
                <label class="block text-sm font-medium text-gray-600 mb-2">Select Service</label>
                <select id="service"
                    class="w-full border rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-cyan-500 outline-none">
                    <option value="">Select Service</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->service_name }}">
                            {{ $service->service_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3 border-t px-6 py-4">
                <button id="closeGenerateModal2" class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300">Cancel</button>
                <button id="generateBtn"
                    class="px-5 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white">Generate</button>
            </div>
        </div>
    </div>

    {{-- Credential Modal --}}
    <div id="credentialModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold">API Credentials</h3>
                <button id="closeCredentialModal" class="text-2xl text-gray-500 hover:text-red-500">
                    &times;
                </button>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Client ID</label>
                    <div class="flex">
                        <input readonly id="client_id" class="flex-1 border rounded-l-xl px-4 py-2">
                        <button class="copyBtn bg-cyan-600 text-white px-5 rounded-r-xl"
                            data-target="client_id">Copy</button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Client Secret</label>
                    <div class="flex">
                        <input readonly id="client_secret" class="flex-1 border rounded-l-xl px-4 py-2">
                        <button class="copyBtn bg-cyan-600 text-white px-5 rounded-r-xl"
                            data-target="client_secret">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $("#openGenerateModal").click(function() {
            console.log("Button Clicked");
            $("#generateModal")
                .removeClass("hidden")
                .addClass("flex");
        });
        $("#closeGenerateModal,#closeGenerateModal2").click(function() {
            $("#generateModal")
                .removeClass("flex")
                .addClass("hidden");
        });
        $("#closeCredentialModal").click(function() {
            $("#credentialModal")
                .removeClass("flex")
                .addClass("hidden");
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
                    $("#generateModal")
                        .removeClass("flex")
                        .addClass("hidden");
                    $("#client_id").val(res.data.client_id);
                    $("#client_secret").val(res.data.client_secret);
                    $("#credentialModal")
                        .removeClass("hidden")
                        .addClass("flex");
                    ToastEngine.show(res.message, "success");
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
    </script>
    <script>
        $('#oauthTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('datatable', 'oauthUsers') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {
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
                    data: 'status',
                    render: function(data) {
                        return data == 1
                            ? '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>'
                            : '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Inactive</span>';
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
@endsection
@endsection
