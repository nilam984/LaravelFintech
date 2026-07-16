<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        fintechDark: '#0b1528',
                        fintechDropdownBg: '#0e1a30',
                        fintechBorder: 'rgba(255, 255, 255, 0.1)',
                        fintechCyan: '#00b4d8',
                        fintechCyanHover: '#0077b6',
                        fintechGreen: '#52b788',
                        fintechLightBg: '#f8fafc',
                        fintechLightCard: '#ffffff',
                        fintechLightBorder: '#e2e8f0',
                        fintechDarkText: '#0f172a',
                        fintechMutedText: '#64748b'
                    }
                }
            }
        }
    </script>

    <style>
        /* Premium Fintech Gradient for Sidebar and Header based on #0b1528 */
        .fintech-gradient {
            background: linear-gradient(136deg, #4a628e 0%, #11284d 100%);
        }

        /* Custom scrollbars for clean desktop design */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.02);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #00b4d8;
        }


        /* Pagination container */
        .dt-paging {
            margin-top: 16px !important;
        }

        /* All buttons */
        .dt-paging .dt-paging-button {
            padding: 4px 10px !important;
            margin: 0 2px !important;
            min-width: 32px;
            height: 32px;
            border-radius: 8px !important;
            border: 1px solid #E2E8F0 !important;
            background: #fff !important;
            color: #475569 !important;
            font-size: 13px !important;
            font-weight: 500;
            transition: .2s;
        }

        /* Hover */
        .dt-paging .dt-paging-button:hover {
            background: #06B6D4 !important;
            border-color: #06B6D4 !important;
            color: #fff !important;
        }

        /* Active */
        .dt-paging .dt-paging-button.current {
            background: #0891B2 !important;
            border-color: #0891B2 !important;
            color: #fff !important;
        }

        /* Disabled */
        .dt-paging .dt-paging-button.disabled {
            opacity: .5;
        }

        .dt-column-order {
            font-size: 11px !important;
        }

        table.dataTable thead th {
            font-size: 13px !important;
            font-weight: 600;
        }
    </style>

</head>

<body class="bg-fintechLightBg text-fintechDarkText font-sans antialiased h-screen flex overflow-hidden">

    @if (Auth::check() && Auth::user()->role == 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.user-sidebar')
    @endif

    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">

        @include('layouts.header')

        <main class="flex-1 overflow-y-auto custom-scrollbar">

            @yield('content')

        </main>

        @include('layouts.footer')

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('layouts.script')
    @yield('scripts')

</body>

</html>
