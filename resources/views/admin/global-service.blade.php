@extends('layouts.app')

@section('title', 'Global Services')

@section('content')
    <main class="p-4 sm:p-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Global Services
                </h1>
                <p class="text-sm text-fintechMutedText mt-1">
                    Manage all global services.
                </p>
            </div>
            <button id="openServiceModal" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg">
                <i class="bi bi-plus-lg"></i>
                Add Global Service
            </button>
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
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
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
            <table id="usersTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        {{-- <th>Add Product</th> --}}
                        <th width="120">Status</th>
                        <th>Created</th>
                        <th>Add Product</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>

    {{-- Product Modal  --}}
    <div id="productModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
            <!-- Header -->
            <div class="flex items-center justify-between border-b px-6 py-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-800">
                        Manage Products
                    </h2>
                    <p class="text-sm text-slate-500">
                        Add or update products for <b id="serviceName"></b> service.
                    </p>
                </div>
                <button id="closeModal" class="rounded-lg p-2 hover:bg-gray-100">
                    ✕
                </button>
            </div>

            <!-- Body -->
            <div class="p-6">
                <input type="hidden" id="service_id">
                <div id="productRows" class="space-y-3">
                </div>
            </div>
            <!-- Footer -->
            <div class="flex justify-end gap-3 border-t bg-gray-50 px-6 py-4">
                <button id="closeModal2" class="rounded-lg border border-gray-300 px-5 py-2 hover:bg-gray-100">
                    Cancel
                </button>
                <button id="saveProducts" class="rounded-lg bg-cyan-600 px-5 py-2 text-white hover:bg-cyan-700">
                    Save Products
                </button>
            </div>
        </div>
    </div>
    <!-- Add Global Service Modal -->
    <div id="serviceModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg">
            <div class="flex justify-between items-center border-b p-5">
                <h4 id="modalTitle" class="text-lg font-semibold">
                    Add Global Service
                </h4>
                <button type="button" id="closeServiceModal">✕</button>
            </div>
            <form id="serviceForm">
                @csrf
                <input type="hidden" id="service_id">
                <div class="p-5">
                    <div class="mb-4">
                        <label>Service Name</label>
                        <input type="text" id="service_name" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label>Status</label>
                        <select id="service_status" class="w-full border rounded-lg p-2">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="border-t p-4 flex justify-end gap-2">
                    <button type="button" id="closeServiceModal2" class="border px-4 py-2 rounded">
                        Cancel
                    </button>
                    <button type="submit" id="saveBtn" class="bg-cyan-600 text-white px-5 py-2 rounded">
                        Save
                    </button>
                </div>
            </form>
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
                autoWidth: false,
                scrollX: true,
                ajax: {
                    url: "{{ route('datatable', 'globalServices') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $('#status').val();
                    }
                },
                columns: [{
                        data: 'id', name: 'id'
                    },
                    {
                        data: 'service_name', name: 'service_name'
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
                                        <option value="1" ${data == 1 ? 'selected' : ''}>Active</option>
                                        <option value="0" ${data == 0 ? 'selected' : ''}>Inactive</option>
                                    </select>
                                `;
                        }
                    },
                     {
                        data: 'created_at', name: 'created_at',
                        render: function(data) {
                            return formatDateTime(data);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <button
                                class="addProducts bg-cyan-600 hover:bg-cyan-700 text-white px-3 py-2 rounded-lg"
                                data-id="${row.id}"
                                data-name="${row.service_name}">
                                <i class="bi bi-plus-circle"></i>
                            </button>
                        `;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <button
                                    class="editService bg-yellow-500 text-white px-3 py-2 rounded"
                                    data-id="${row.id}"
                                    data-name="${row.service_name}"
                                    data-status="${row.status}">
                                    <i class="bi bi-pencil"></i>
                                </button>
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

        function appendRow(id = '', product = '') {
            $('#productRows').append(`
            <div class="product-row flex items-center gap-3">
                <input type="hidden"
                    class="product-id"
                    value="${id}">
                <input
                    type="text"
                    class="product-name flex-1 rounded-lg border border-slate-300 px-4 py-2 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 outline-none"
                    placeholder="Enter product name"
                    value="${product}">
                <button type="button" class="addMore h-10 w-10 rounded-lg bg-green-500 text-white hover:bg-green-600"> + </button>
                <button type="button" class="removeRow h-10 w-10 rounded-lg bg-red-500 text-white hover:bg-red-600"> − </button>
            </div>`);
            toggleRemoveButton();
        }
        $(document).on('click', '.addProducts', function() {
            $('#service_id').val($(this).data('id'));
            $('#serviceName').html($(this).data('name'));
            $('#productRows').empty();
            loadProducts($(this).data('id'));
            $('#productModal')
                .removeClass('hidden')
                .addClass('flex');
        });
        // Close Modal
        $('#closeModal,#closeModal2').click(function() {
            $('#productModal')
                .removeClass('flex')
                .addClass('hidden');
        });

        //Add Row
        $(document).on('click', '.addMore', function() {
            appendRow();
        });

        // Remove Row
        $(document).on('click', '.removeRow', function() {
            if ($('.product-row').length == 1) {
                return;
            }
            $(this).closest('.product-row').remove();
            toggleRemoveButton();
        });

        // Save Record 
        $('#saveProducts').click(function() {
            let products = [];
            $('.product-row').each(function() {
                products.push({
                    product_name: $(this).find('.product-name').val()
                });
            });

            $.ajax({
                url: "{{ route('add.products') }}",
                type: 'POST',
                data: {
                    _token: $('meta[name=csrf-token]').attr('content'),
                    service_id: $('#service_id').val(),
                    products: products
                },
                success: function(response) {
                    $('#productModal').addClass('hidden');
                    if (response.status) {
                        ToastEngine.show(response.message, "success");
                    } else {
                        ToastEngine.show(response.message, "error");
                    }
                    table.ajax.reload(null, false);
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
                },
            });

        });

        function loadProducts(service_id) {
            const url = "{{ route('get.products', ['service_id' => ':service_id']) }}".replace(':service_id', service_id)
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $('#productRows').empty();
                    if (response.length > 0) {
                        response.forEach(function(product) {
                            appendRow(product.id, product.product_name);
                        });
                    } else {
                        appendRow();
                    }
                }
            });

        }

        function toggleRemoveButton() {
            if ($('.product-row').length == 1) {
                $('.removeRow')
                    .prop('disabled', true)
                    .addClass('opacity-40 cursor-not-allowed');
            } else {
                $('.removeRow')
                    .prop('disabled', false)
                    .removeClass('opacity-40 cursor-not-allowed');
            }
        }
    </script>
    <script>
        $('#openServiceModal').click(function() {
            $('#modalTitle').text('Add Global Service');
            $('#saveBtn').text('Save');
            $('#serviceForm')[0].reset();
            $('#service_id').val('');
            $('#serviceModal')
                .removeClass('hidden')
                .addClass('flex');

        });

        $(document).on('click', '.editService', function() {
            $('#modalTitle').text('Edit Global Service');
            $('#saveBtn').text('Update');
            $('#service_id').val($(this).data('id'));
            $('#service_name').val($(this).data('name'));
            $('#service_status').val($(this).data('status'));
            $('#serviceModal')
                .removeClass('hidden')
                .addClass('flex');

        });

        // Close Modal
        $('#closeServiceModal,#closeServiceModal2').click(function() {

            $('#serviceModal')
                .removeClass('flex')
                .addClass('hidden');

        });

        // save global service
        $('#serviceForm').submit(function(e) {
            e.preventDefault();
            let id = $('#service_id').val();
            let url = '';
            if (id == '') {
                url = "{{ route('global.service.store') }}";
            } else {
                url = "{{ route('global.service.update') }}";
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: $('meta[name=csrf-token]').attr('content'),
                    id: id,
                    service_name: $('#service_name').val(),
                    status: $('#service_status').val()
                },
                success: function(response) {
                    if (response.status) {
                        ToastEngine.show(response.message, 'success');
                        $('#serviceModal')
                            .removeClass('flex')
                            .addClass('hidden');
                        $('#serviceForm')[0].reset();
                        table.ajax.reload(null, false);
                    } else {
                        ToastEngine.show(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        $.each(xhr.responseJSON.errors, function(k, v) {
                            ToastEngine.show(v[0], 'error');
                        });
                    }
                }
            });

        });
    </script>
@endsection
@endsection
