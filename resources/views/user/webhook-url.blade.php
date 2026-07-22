<!-- ===========================
Webhook List Card
=========================== -->

<div class="bg-white rounded-2xl overflow-hidden">

    <div class="px-6 py-4 border-b flex items-center justify-between">

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Webhook URL Details
            </h2>

            {{-- <p class="text-sm text-gray-500 mt-1">
                Configure callback URLs for your services.
            </p> --}}
        </div>

        <button type="button" onclick="openWebhookModal()"
            class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2.5 rounded-lg shadow transition">
            + Add Webhook
        </button>

    </div>

    <div class="overflow-x-auto">

        <table id="webhookTable" class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Webhook URL</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

</div>


<div id="webhookModal" class="fixed inset-0 bg-black/60 hidden justify-center items-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                Add Webhook URL
            </h3>
            <button onclick="closeWebhookModal()" class="text-3xl text-gray-500 hover:text-red-500">
                &times;
            </button>
        </div>

        <form id="webhookForm" method="POST">
            @csrf
            <input type="hidden" name="id" id="webhook_id" value="">
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Service
                    </label>
                    <select name="service_id"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-cyan-500 outline-none">
                        <option value="">
                            Select Service
                        </option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">
                                {{ $service->service_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Webhook URL
                    </label>
                    <input type="url" name="webhook_url" placeholder="https://example.com/webhook"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-cyan-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Status
                    </label>
                    <select name="status"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-cyan-500 outline-none">
                        <option value="1">
                            Active
                        </option>
                        <option value="0">
                            Inactive
                        </option>
                    </select>
                </div>
            </div>

            <!-- Footer -->

            <div class="flex justify-end gap-3 border-t px-6 py-4">

                <button type="button" onclick="closeWebhookModal()"
                    class="border px-5 py-2 rounded-lg hover:bg-gray-100">

                    Cancel

                </button>
                <button type="submit" id="saveWebhookBtn"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-lg">
                    Save Webhook
                </button>

            </div>

        </form>

    </div>

</div>
