@extends('layouts.app')

@section('title', 'Scheme')

@section('content')
    <main class="p-4 sm:p-8 space-y-6">
        {{-- Page Header --}}
        <div>
            <h1 class="text-2xl font-bold text-fintechDarkText">
                Gateway & Routing
            </h1>
            <p class="text-sm text-fintechMutedText mt-1">
                Manage your active payment gateways for Payin and Payout operations.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white border border-cyan-500 rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b pb-3">
                        <h2 class="text-lg font-semibold text-fintechDarkText">
                            Payin Routing
                        </h2>
                        <span
                            class="inline-flex items-center rounded-full bg-cyan-500 px-3 py-1 text-xs font-medium text-white">
                            {{ $payinCurrentRouteId?->gatewayName?->gateway_name ?? '----' }}
                        </span>

                    </div>

                    {{-- Form / Selection --}}
                    <form id="payinRoutingForm" method="POST" action="{{ route('switch.gateway.routing') }}"
                        class="space-y-4">
                        @csrf

                        <input type="hidden" name="gateway_type" value="payin">
                        <div>
                            <label for="payin_gateway" class="block text-sm font-medium text-fintechDarkText mb-1.5">
                                Select Payin Gateway
                            </label>
                            <select id="payin_gateway" name="payin_gateway_id"
                                class="w-full bg-slate-50 border border-slate-300 text-fintechDarkText text-sm rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none transition">
                                <option value="" disabled selected>Choose a gateway...</option>
                                @foreach ($payinGateways as $gateway)
                                    <option value="{{ $gateway->id }}"
                                        {{ $gateway->id == $payinCurrentRouteId->payment_gateway_id ? 'selected' : '' }}>
                                        {{ $gateway->gateway_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payin_gateway_id')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>

                {{-- Action --}}
                <div>
                    <button type="submit" form="payinRoutingForm"
                        class="w-full text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4  font-medium rounded-lg text-sm px-5 py-2.5 text-center transition">
                        Save Payin Route
                    </button>
                </div>
            </div>

            <div class="bg-white border border-cyan-500 rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b pb-3">
                        <h2 class="text-lg font-semibold text-fintechDarkText">
                            Payout Routing
                        </h2>
                        <span
                            class="inline-flex items-center rounded-full bg-cyan-500 px-3 py-1 text-xs font-medium text-white">
                            {{ $payoutCurrentRouteId?->gatewayName?->gateway_name ?? '----' }}
                        </span>
                    </div>

                    {{-- Form / Selection --}}
                    <form id="payoutRoutingForm" method="POST" action="{{ route('switch.gateway.routing') }}"
                        class="space-y-4">
                        @csrf
                        <input type="hidden" name="gateway_type" value="payout">
                        <div>
                            <label for="payout_gateway" class="block text-sm font-medium text-fintechDarkText mb-1.5">
                                Select Payout Gateway
                            </label>
                            <select id="payout_gateway" name="payout_gateway_id"
                                class="w-full bg-slate-50 border border-slate-300 text-fintechDarkText text-sm rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none transition">
                                <option value="" disabled selected>Choose a gateway...</option>
                                @foreach ($payoutGateways as $gateway)
                                    <option value="{{ $gateway->id }}"
                                        {{ $gateway->id == $payoutCurrentRouteId->payment_gateway_id ? 'selected' : '' }}>
                                        {{ $gateway->gateway_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payout_gateway_id')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>

                {{-- Action --}}
                <div>
                    <button type="submit" form="payoutRoutingForm"
                        class="w-full text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4  font-medium rounded-lg text-sm px-5 py-2.5 text-center transition">
                        Save Payout Route
                    </button>
                </div>
            </div>

        </div>

    </main>

@section('scripts')
    <script>
        $('#assignSchemeForm').on('submit', function(e) {
            e.preventDefault();

            let submitBtn = $('#btnSubmit');
            submitBtn.prop('disabled', true).text('Assigning...');

            $('#error_user_id').text('');
            $('#error_scheme_id').text('');

            $.ajax({
                url: "{{ route('assign.scheme') }}",
                type: "POST",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    submitBtn.prop('disabled', false).text('Assign');

                    if (response.status === 'success') {
                        if ($.fn.DataTable.isDataTable('#assignedScheme')) {
                            $('#assignedScheme').DataTable().ajax.reload(null, false);
                        }
                        ToastEngine.show(response.message, "success");
                    } else {
                        ToastEngine.show(response.message, "error");
                    }
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).text('Assign');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.user_id) $('#error_user_id').text(errors.user_id[0]);
                        if (errors.scheme_id) $('#error_scheme_id').text(errors.scheme_id[0]);
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        ToastEngine.show(xhr.responseJSON.message, "error");
                    } else {
                        ToastEngine.show('Something went wrong. Please try again.', "error");
                    }
                }
            });
        });
    </script>
@endsection
@endsection
