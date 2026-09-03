@extends('layouts.app')

@section('title', 'Cost Setup')

@section('content')

    <main class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold">Cost Setup</h2>
                <p class="text-gray-500 text-sm">Manage Service Cost</p>
            </div>
            <button id="openModal" class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-lg">
                <i class="bi bi-plus"></i> Add Cost
            </button>
        </div>
    </main>

    <div id="costModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
        <div class="bg-white rounded-xl w-full max-w-md">
            <div class="border-b p-5 flex justify-between">
                <h4 id="modalTitle" class="font-semibold">Add Cost</h4>
                <button id="closeModal">✕</button>
            </div>

            <form id="costForm">
                @csrf
                <input type="hidden" id="cost_setup_id">
                <div class="p-5">
                    <div class="mb-4">
                        <label class="block mb-2">Service</label>
                        <select name="service_id" id="service_id" class="w-full border rounded-lg p-2">
                            <option value="Select Service">Select Service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">
                                    {{ $service->service_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2">Cost</label>
                        <input type="number" step="0.01" name="cost" id="cost" class="w-full border rounded-lg p-2" placeholder="Enter Cost">
                    </div>

                </div>

                <div class="border-t p-4 flex justify-end">
                    <button class="bg-cyan-600 text-white px-5 py-2 rounded-lg">Save</button>
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
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>




@section('scripts')
    <script>
        $('#openModal').click(function() {
            $('#modalTitle').text('Add Cost');
            $('#cost_setup_id').val('');
            $('#costForm')[0].reset();
            $('#service_id').prop('disabled', false);
            $('#costModal').removeClass('hidden').addClass('flex');
        });

        $('#closeModal').click(function() {
            $('#costModal').removeClass('flex').addClass('hidden');
        });


        $('#costForm').submit(function(e) {
            e.preventDefault();
            let id = $('#cost_setup_id').val();
            let url = id ?
                '/admin/cost-setup/update/' + id :
                "{{ route('cost.setup.store') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: $('meta[name=csrf-token]').attr('content'),
                    service_id: $('#service_id').val(),
                    cost: $('#cost').val()
                },
                success: function(res) {
                    ToastEngine.show(res.message, 'success');
                    $('#costModal').removeClass('flex').addClass('hidden');
                    $('#costForm')[0].reset();
                    $('#service_id').prop('disabled', false);
                    table.ajax.reload(null, false);

                },

                error: function(xhr) {
                    if (xhr.status == 422) {
                        if (xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(k, v) {
                                ToastEngine.show(v[0], 'error');
                            });
                        } else {
                            ToastEngine.show(xhr.responseJSON.message, 'error');
                        }
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
                columns: [{data: 'id', name: 'id'},
                    {
                        data: 'service.service_name',
                        name: 'service.service_name',
                        defaultContent: '-'
                    },
                    {data: 'cost', name: 'cost'},
                    {data: 'created_at', name: 'created_at',
                        render: function(data) {
                            return formatDateTime(data);
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <button
                                    class="editCost bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg"
                                    data-id="${row.id}"
                                    data-service="${row.service_id}"
                                    data-cost="${row.cost}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            `;
                        }
                    }
                ]
            });

        });

        $(document).on('click', '.editCost', function() {
            $('#modalTitle').text('Edit Cost');
            $('#cost_setup_id').val($(this).data('id'));
            $('#service_id').val($(this).data('service'));
            // $('#service_id').prop('disabled', true);
            $('#service_id').prop('disabled', false);
            $('#cost').val($(this).data('cost'));
            $('#costModal').removeClass('hidden').addClass('flex');
        });
    </script>
@endsection

@endsection
