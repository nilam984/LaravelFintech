@extends('layouts.app')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-lg">

            @if ($status === 'success')
                {{-- Success --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                    <div class="px-6 py-8 text-center">

                        <div
                            class="mx-auto w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-3xl">
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <h1 class="mt-5 text-2xl font-bold text-slate-800">
                            Payment Successful
                        </h1>

                        <p class="mt-2 text-sm text-slate-500">
                            Customer payment has been received and the onboarding process has been initiated.
                        </p>

                    </div>

                    <div class="border-t border-slate-200 px-6 py-5 space-y-4">

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500">
                                Merchant Transaction ID
                            </span>

                            <span class="text-sm font-semibold text-slate-800 text-right break-all">
                                {{ $order?->gateway_order_id ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500">
                                Gateway Transaction ID
                            </span>

                            <span class="text-sm font-semibold text-slate-800 text-right break-all">
                                {{ $order?->gateway_payment_id ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">
                                Amount Paid
                            </span>

                            <span class="text-sm font-bold text-green-600">
                                ₹{{ number_format((float) ($order?->total_amount ?? 0), 2) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">
                                Status
                            </span>

                            <span
                                class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                SUCCESS
                            </span>
                        </div>

                    </div>

                    <div class="bg-slate-50 border-t border-slate-200 px-6 py-5">

                        <div class="flex gap-3">
                            <div class="text-cyan-600 text-xl">
                                <i class="bi bi-envelope-check"></i>
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-slate-800">
                                    Onboarding Email
                                </p>

                                <p class="text-xs text-slate-500 mt-1">
                                    An onboarding initiation email has been queued for
                                    {{ $order?->email ?? 'the customer' }}.
                                </p>
                            </div>
                        </div>

                    </div>

                </div>
            @else
                {{-- Failed --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                    <div class="px-6 py-8 text-center">

                        <div
                            class="mx-auto w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-3xl">
                            <i class="bi bi-x-lg"></i>
                        </div>

                        <h1 class="mt-5 text-2xl font-bold text-slate-800">
                            Payment Failed
                        </h1>

                        <p class="mt-2 text-sm text-slate-500">
                            {{ $message }}
                        </p>

                    </div>

                    <div class="border-t border-slate-200 px-6 py-5 space-y-4">

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500">
                                Merchant Transaction ID
                            </span>

                            <span class="text-sm font-semibold text-slate-800 text-right break-all">
                                {{ $order?->gateway_order_id ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500">
                                Gateway Transaction ID
                            </span>

                            <span class="text-sm font-semibold text-slate-800 text-right break-all">
                                {{ $order?->gateway_payment_id ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">
                                Status
                            </span>

                            <span
                                class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                FAILED
                            </span>
                        </div>

                    </div>

                    <div class="bg-slate-50 border-t border-slate-200 px-6 py-5">

                        <a href="{{ route('dashboard') }}"
                            class="w-full inline-flex items-center justify-center gap-2 bg-fintechCyan hover:bg-fintechCyanHover text-white px-5 py-2.5 rounded-lg text-sm font-medium">
                            <i class="bi bi-arrow-left"></i>
                            Back to Dashboard
                        </a>

                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection
