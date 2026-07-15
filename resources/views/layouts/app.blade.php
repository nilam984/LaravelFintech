<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
    </style>

</head>

<body class="bg-fintechLightBg text-fintechDarkText font-sans antialiased h-screen flex overflow-hidden">

    @if (1)
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

    @include('layouts.script')

    {{-- @stack('scripts') --}}

</body>

</html>
