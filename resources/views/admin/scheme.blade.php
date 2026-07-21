@extends('layouts.app')

@section('title', 'Scheme')

@section('content')
    <main class="p-4 sm:p-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-fintechDarkText">
                    Scheme
                </h1>
                <p class="text-sm text-fintechMutedText mt-1">
                    Manage all schemes.
                </p>
            </div>
            <a href="javascript:void(0)"
                class="addScheme bg-fintechCyan hover:bg-fintechCyanHover text-white px-4 py-2 rounded-lg">
                <i class="bi bi-plus-lg"></i>
                Scheme
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
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

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
            <table id="schemeTable" class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>


    {{-- Scheme Modal  --}}
    <div id="schemeModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50 overflow-y-auto p-4">

        <div class="bg-white rounded-xl w-full max-w-6xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between p-5 border-b">
                <h2 class="text-xl font-semibold">
                    Manage Scheme
                </h2>
                <button id="closeSchemeModal">
                    ✕
                </button>
            </div>

            <div class="p-5">
                <input type="hidden" id="scheme_id">
                <label>
                    Scheme Name
                </label>
                <input id="scheme_name" class="w-full border rounded-lg px-3 py-2 mb-5" placeholder="Scheme Name">
                <div
                    class="grid grid-cols-10 gap-2 mb-2 text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200 rounded-lg px-2 py-2">

                    <div>Service</div>
                    <div>Product</div>
                    <div>Fee Type</div>
                    <div>Start Value</div>
                    <div>End Value</div>
                    <div>Fee</div>
                    <div>Min Fee</div>
                    <div>Max Fee</div>
                    <div>Status</div>
                    <div>Action</div>
                </div>
                <div id="ruleRows" class="space-y-3">
                </div>
            </div>
            <div class="border-t p-5 flex justify-end gap-3">
                <button id="closeSchemeModal2" class="border px-5 py-2 rounded-lg">
                    Cancel
                </button>
                <button id="saveScheme" class="bg-cyan-600 text-white px-5 py-2 rounded-lg">
                    Save
                </button>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        let table = null
        $(function() {
            table = $('#schemeTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                ajax: {
                    url: "{{ route('datatable', 'schemes') }}",
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
                        data: 'name',
                        name: 'name'
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

                                    <option value="1" ${data == 1 ? 'selected' : ''}>
                                        Active
                                    </option>

                                    <option value="0" ${data == 0 ? 'selected' : ''}>
                                        Inactive
                                    </option>
                                </select>
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
                                    class="editScheme bg-yellow-500 text-white px-3 py-2 rounded"
                                    data-id="${row.id}">
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

        // For Change status
        $(document).on('change', '.service-status', function() {
            changeStatus(this, "{{ route('scheme.change.status') }}", "Scheme", table);
        });


        $(document).on('click', '.addRuleRow', function() {
            addRuleRow();
        });

        $(document).on('click', '.removeRule', function() {

            if ($('.rule-row').length > 1) {
                $(this).closest('.rule-row').remove();
            }

            setRemoveButton();
        });


        $('.addScheme').click(function() {

            $('#scheme_id').val('');
            $('#scheme_name').val('');
            $('#scheme_status').val(1);
            $('#ruleRows').html('');
            addRuleRow();
            $('#schemeModal')
                .removeClass('hidden')
                .addClass('flex');
        });


        $(document).on('click', '.editScheme', function() {
            editScheme($(this).data('id'));
        });


        $(document).on('change', '.service', function() {
            let service_id = $(this).val();
            let product = $(this)
                .closest('.rule-row')
                .find('.product');

            loadProducts(service_id, product);
        });

        $(document).on('click', '#closeSchemeModal, #closeSchemeModal2', function() {
            $('#schemeModal')
                .removeClass('flex')
                .addClass('hidden');
        });

        $('#saveScheme').click(function() {
            saveScheme();
        });


        function setRemoveButton() {
            $('.removeRule')
                .prop('disabled', $('.rule-row').length == 1)
                .toggleClass('opacity-40', $('.rule-row').length == 1);
        }


        function saveScheme() {

            let rules = [];

            $('.rule-row').each(function() {

                rules.push({

                    service_id: $(this).find('.service').val(),

                    product_id: $(this).find('.product').val(),

                    fee_type: $(this).find('.fee_type').val(),

                    start_value: $(this).find('.start').val(),

                    end_value: $(this).find('.end').val(),

                    fee: $(this).find('.fee').val(),

                    min_fee: $(this).find('.min_fee').val(),

                    max_fee: $(this).find('.max_fee').val(),

                    status: $(this).find('.status').val()

                });

            });


            $.ajax({

                url: "{{ route('scheme.save') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    scheme_id: $('#scheme_id').val(),

                    name: $('#scheme_name').val(),

                    status: $('#scheme_status').val(),

                    rules: rules

                },

                success: function(response) {

                    if (response.status) {
                        $('#schemeModal')
                            .removeClass('flex')
                            .addClass('hidden');
                        table.ajax.reload(null, false);
                        ToastEngine.show(response.message, "success");
                    } else {
                        ToastEngine.show(response.message, "error");
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 422) {

                        let errors = xhr.responseJSON.errors;

                        let msg = '';

                        $.each(errors, function(key, value) {

                            msg += value[0] + "<br>";

                        });

                        ToastEngine.show(msg, "error");

                    } else {

                        ToastEngine.show(
                            xhr.responseJSON.message,
                            "error"
                        );

                    }

                }

            });

        }


        function addRuleRow() {

            $('#ruleRows').append(`

                <div class="rule-row grid grid-cols-10 gap-2 items-center">

                    <select class="service h-9 border rounded px-2 text-sm">

                        <option value="">
                            Service
                        </option>

                        @foreach ($services as $service)

                        <option value="{{ $service->id }}">
                            {{ $service->service_name }}
                        </option>

                        @endforeach

                    </select>


                    <select class="product h-9 border rounded px-2 text-sm">

                        <option value="">
                            Product
                        </option>

                    </select>


                    <select class="fee_type h-9 border rounded px-2 text-sm">

                        <option value="Fixed">
                            Fixed
                        </option>

                        <option value="Percent">
                            Percent
                        </option>

                    </select>


                    <input class="start h-9 border rounded px-2 text-sm">

                    <input class="end h-9 border rounded px-2 text-sm">

                    <input class="fee h-9 border rounded px-2 text-sm">

                    <input class="min_fee h-9 border rounded px-2 text-sm">

                    <input class="max_fee h-9 border rounded px-2 text-sm">


                    <select class="status h-9 border rounded px-2 text-sm">

                        <option value="1">
                            Active
                        </option>

                        <option value="0">
                            Inactive
                        </option>

                    </select>


                    <div class="flex gap-1">

                        <button type="button"
                            class="addRuleRow h-9 w-9 bg-green-600 text-white rounded">
                            +
                        </button>


                        <button type="button"
                            class="removeRule h-9 w-9 bg-red-600 text-white rounded">
                            -
                        </button>

                    </div>


                </div>

                `);

            setRemoveButton();

        }


        function editScheme(id) {

            $('#ruleRows').html('');

            let url = "{{ route('scheme.edit', ['id' => ':id']) }}"
                .replace(':id', id);


            $.get(url, function(response) {


                let scheme = response.scheme;


                $('#scheme_id').val(scheme.id);

                $('#scheme_name').val(scheme.name);

                $('#scheme_status').val(scheme.status);



                scheme.rules.forEach(function(rule) {


                    addRuleRow();


                    let row = $('.rule-row').last();


                    row.find('.service')
                        .val(rule.service_id);


                    row.find('.fee_type')
                        .val(rule.fee_type);


                    row.find('.start')
                        .val(rule.start_value);


                    row.find('.end')
                        .val(rule.end_value);


                    row.find('.fee')
                        .val(rule.fee);


                    row.find('.min_fee')
                        .val(rule.min_fee);


                    row.find('.max_fee')
                        .val(rule.max_fee);


                    row.find('.status')
                        .val(rule.status);



                    loadProducts(

                        rule.service_id,

                        row.find('.product'),

                        rule.product_id

                    );


                });


                $('#schemeModal')
                    .removeClass('hidden')
                    .addClass('flex');


            });

        }


        function loadProducts(service_id, productElement, selectedProduct = null) {

            if (!service_id) {

                productElement.html(
                    '<option value="">Select Product</option>'
                );

                return;

            }


            let url = "{{ route('get.products', ['service_id' => ':service_id']) }}"
                .replace(':service_id', service_id);


            productElement.html(
                '<option>Loading...</option>'
            );


            $.get(url, function(data) {


                productElement.html(
                    '<option value="">Select Product</option>'
                );


                data.forEach(function(item) {


                    productElement.append(`

            <option value="${item.id}"
            ${selectedProduct == item.id ? 'selected':''}>

                ${item.product_name}

            </option>

            `);


                });


            });

        }
    </script>
@endsection
@endsection
