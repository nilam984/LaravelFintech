<div class="space-y-3">
    @foreach ($services as $service)
        @php
            $serviceAmount = $service->costSetup->cost ?? 0;
        @endphp

        <label
            class="service-card block cursor-pointer rounded-xl border border-slate-200 bg-white p-4 hover:border-cyan-400 hover:bg-cyan-50/30 transition">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="services[]" value="{{ $service->id }}"
                        data-service-id="{{ $service->id }}" data-service-name="{{ $service->service_name }}"
                        data-service-amount="{{ $serviceAmount }}"
                        class="service-checkbox h-5 w-5 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">

                    <div>
                        <h4 class="text-sm font-semibold text-slate-800">
                            {{ $service->service_name }}
                        </h4>
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-xs text-slate-500">Setup Cost</p>
                    <p class="text-base font-bold text-slate-800">
                        ₹{{ number_format($serviceAmount, 2) }}
                    </p>
                </div>
            </div>
        </label>
    @endforeach
</div>
