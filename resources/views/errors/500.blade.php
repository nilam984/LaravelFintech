@extends('layouts.app')

@section('title', 'Internal Server Error')

@section('content')
    <main class="min-h-[80vh] flex items-center justify-center p-6">
        <div class="w-full max-w-5xl">

            <div class="rounded-2xl border border-red-200 bg-white shadow-lg overflow-hidden">

                {{-- Header --}}
                <div class="border-b border-red-200 bg-red-50 px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                            </svg>
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold text-red-700">
                                Internal Server Error
                            </h1>
                            <p class="text-sm text-gray-600">
                                An unexpected error occurred while processing your request.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-6 space-y-6">
{{-- 
                    @if (0) --}}
                        @if (config('app.debug'))
                        {{-- Exception Message --}}
                        <div>
                            <h3 class="mb-2 text-sm font-semibold text-gray-700">
                                Exception
                            </h3>

                            <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                                <code class="text-red-700">
                                    {{ $exception->getMessage() }}
                                </code>
                            </div>
                        </div>

                        {{-- File --}}
                        <div class="grid gap-4 md:grid-cols-2">

                            <div>
                                <h3 class="mb-2 text-sm font-semibold text-gray-700">
                                    File
                                </h3>

                                <div class="rounded-lg bg-gray-900 p-4 text-sm text-green-300 break-all">
                                    {{ $exception->getFile() }}
                                </div>
                            </div>

                            <div>
                                <h3 class="mb-2 text-sm font-semibold text-gray-700">
                                    Line
                                </h3>

                                <div class="rounded-lg bg-gray-900 p-4 text-sm text-yellow-300">
                                    {{ $exception->getLine() }}
                                </div>
                            </div>

                        </div>

                        {{-- Trace --}}
                        <details class="rounded-lg border">
                            <summary class="cursor-pointer bg-gray-100 px-4 py-3 font-medium">
                                View Stack Trace
                            </summary>

                            <div class="overflow-auto bg-gray-950 p-5">
                                <pre class="text-xs text-gray-200 whitespace-pre-wrap">{{ $exception }}</pre>
                            </div>
                        </details>
                    @else
                        <div class="rounded-lg border border-red-200 bg-red-50 p-5 text-gray-700">
                            Something went wrong while processing your request.
                            Please try again later or contact the administrator.
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex flex-wrap gap-3">


                        <a href="{{ url('/') }}"
                            class="rounded-lg border border-gray-300 px-5 py-2.5 font-medium hover:bg-gray-50">
                            Dashboard
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </main>
@endsection
