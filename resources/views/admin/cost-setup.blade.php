@extends('layouts.app')

@section('title', 'Cost Setup')

@section('content')

    <main class="p-6">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold">Cost Setup</h2>
                <p class="text-gray-500 text-sm">
                    Manage Service Cost
                </p>
            </div>

            <button id="openModal" class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-lg">
                <i class="bi bi-plus"></i> Add Cost
            </button>
        </div>

    </main>

    <!-- Modal -->

    <div id="costModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">

        <div class="bg-white rounded-xl w-full max-w-md">

            <div class="border-b p-5 flex justify-between">

                <h4 class="font-semibold">
                    Cost Setup
                </h4>

                <button id="closeModal">✕</button>

            </div>

            <form id="costForm">

                @csrf

                <div class="p-5">

                    <div class="mb-4">

                        <label class="block mb-2">
                            Service
                        </label>

                        <select name="service_id" id="service_id" class="w-full border rounded-lg p-2">

                            <option value="">Select Service</option>

                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">
                                    {{ $service->service_name }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="block mb-2">
                            Cost
                        </label>

                        <input type="number" step="0.01" name="cost" id="cost"
                            class="w-full border rounded-lg p-2" placeholder="Enter Cost">

                    </div>

                </div>

                <div class="border-t p-4 flex justify-end">

                    <button class="bg-cyan-600 text-white px-5 py-2 rounded-lg">

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

    <main class="p-4 sm:p-8 space-y-6">

        <div class="bg-white border rounded-xl overflow-hidden p-3">
            <table id="costSetupTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service</th>
                        <th>Cost</th>
                        <th>Created</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>




@section('scripts')
    <script>
        $('#openModal').click(function() {
            $('#costModal').removeClass('hidden').addClass('flex');
        });

        $('#closeModal').click(function() {
            $('#costModal').removeClass('flex').addClass('hidden');
        });


        $('#costForm').submit(function(e) {

            e.preventDefault();

            $.ajax({

                url: "{{ route('cost.setup.store') }}",

                type: "POST",

                data: {
                    _token: $('meta[name=csrf-token]').attr('content'),
                    service_id: $('#service_id').val(),
                    cost: $('#cost').val(),
                },

                success: function(response) {
                    if (response.status) {
                        ToastEngine.show(response.message, 'success');
                        $('#costModal').removeClass('flex').addClass('hidden');
                        $('#costForm')[0].reset();
                        table.ajax.reload(null, false);
                    }

                },

                error: function(xhr) {

                    if (xhr.status == 422) {

                        $.each(xhr.responseJSON.errors, function(key, value) {

                            ToastEngine.show(value[0], 'error');

                        });

                    }

                }

            });

        });



        let table = null;

        $(document).ready(function() {

            table = $('#costSetupTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('datatable', 'costSetup') }}",
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
                        name: 'service.service_name',
                        defaultContent: '-'
                    },
                    {
                        data: 'cost',
                        name: 'cost'
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
