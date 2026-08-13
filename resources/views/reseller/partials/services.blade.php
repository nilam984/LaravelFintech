<div class="space-y-3">

    @foreach ($services as $service)
        <label
            class="service-item flex items-center justify-between gap-4 rounded-xl border border-slate-200 p-4 cursor-pointer hover:border-cyan-400 hover:bg-cyan-50/30 transition">

            <div class="flex items-center gap-3">

                <input type="checkbox"
                    class="service-checkbox h-5 w-5 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500"
                    name="services[]" value="{{ $service->id }}" data-price="{{ $service->costSetup->setup_cost ?? 0 }}">

                <div>
                    <h4 class="font-medium text-slate-800">
                        {{ $service->name }}
                    </h4>

                    @if (!empty($service->description))
                        <p class="text-xs text-slate-500">
                            {{ $service->description }}
                        </p>
                    @endif
                </div>

            </div>

            <div class="font-semibold text-slate-800">
                ₹{{ number_format($service->costSetup->setup_cost ?? 0, 2) }}
            </div>

        </label>
    @endforeach

</div>
