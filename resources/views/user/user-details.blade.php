<div class="bg-white rounded-2xl  overflow-hidden">
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center gap-4 p-4  rounded-xl hover:shadow-md transition">
                <div class="w-12 h-12 rounded-lg bg-cyan-100 flex items-center justify-center">
                    <i class="bi bi-person-fill text-cyan-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Full Name</p>
                    <h4 class="font-semibold text-gray-800">
                        {{ auth()->user()->name ?? 'N/A' }}
                    </h4>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4  rounded-xl hover:shadow-md transition">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="bi bi-envelope-fill text-blue-600 text-xl"></i>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Email Address</p>
                    <h4 class="font-semibold text-gray-800 break-all">
                        {{ auth()->user()->email ?? 'N/A' }}
                    </h4>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4  rounded-xl hover:shadow-md transition">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <i class="bi bi-phone-fill text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mobile Number</p>
                    <h4 class="font-semibold text-gray-800">
                        {{ auth()->user()->mobile ?? 'N/A' }}
                    </h4>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4  rounded-xl hover:shadow-md transition">
                <div class="w-12 h-12 rounded-lg bg-teal-100 flex items-center justify-center">
                    <i class="bi bi-check-circle-fill text-teal-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    @if(auth()->user()->status == 1)
                        <span class="inline-block mt-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                            Active
                        </span>
                    @else
                        <span class="inline-block mt-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                            Inactive
                        </span>
                    @endif
                </div>
            </div>
            <div class="md:col-span-2 flex items-center gap-4 p-4  rounded-xl hover:shadow-md transition">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <i class="bi bi-calendar-event-fill text-indigo-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Registered On</p>
                    <h4 class="font-semibold text-gray-800">
                        {{ auth()->user()->created_at->format('d M Y') }}
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>