<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} - Enterprise Fintech Solutions | Payin, Payout & Auto Settlement</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'media',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    },
                    animation: {
                        'infinite-scroll': 'infiniteScroll 30s linear infinite',
                    },
                    keyframes: {
                        infiniteScroll: {
                            '0%': {
                                transform: 'translateX(0)'
                            },
                            '100%': {
                                transform: 'translateX(-50%)'
                            },
                        }
                    }
                }
            }
        }
    </script>
</head>

<body
    class="bg-slate-950 text-slate-100 font-sans antialiased selection:bg-cyan-500 selection:text-slate-950 min-h-screen flex flex-col justify-between"
    x-data="{ currentTab: 'home', mobileMenu: false }">

    <!-- Navigation Bar -->
    <header class="w-full border-b border-slate-800/80 bg-slate-950/90 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="#" @click.prevent="currentTab = 'home'" class="flex items-center gap-3 cursor-pointer">
                <div
                    class="h-10 w-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                    <svg class="w-6 h-6 text-slate-950 font-bold" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-white">Best<span
                        class="text-cyan-400">Pay</span></span>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#" @click.prevent="currentTab = 'home'"
                    :class="currentTab === 'home' ? 'text-cyan-400' : 'hover:text-white'"
                    class="transition">Home</a>
                <a href="#" @click.prevent="currentTab = 'services'"
                    :class="currentTab === 'services' ? 'text-cyan-400' : 'hover:text-white'"
                    class="transition">Services</a>
                <a href="#" @click.prevent="currentTab = 'about'"
                    :class="currentTab === 'about' ? 'text-cyan-400' : 'hover:text-white'" class="transition">About
                    Us</a>
                <a href="#" @click.prevent="currentTab = 'contact'"
                    :class="currentTab === 'contact' ? 'text-cyan-400' : 'hover:text-white'" class="transition">Contact
                    Us</a>
            </nav>

            <!-- Auth Actions -->
            <div class="hidden md:flex items-center gap-4">
                @if (Route::has('login'))


                    @auth

                        @php
                            $role = Auth::user()->role;

                            if ($role == 'admin') {
                                $dashboard = route('admin.dashboard');
                            } else {
                                $dashboard = route('user.dashboard');
                            }

                        @endphp

                        <a href="{{ $dashboard }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold text-sm transition shadow-lg shadow-cyan-500/10">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login.page') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg text-slate-300 hover:text-white font-medium text-sm transition hover:bg-slate-900">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('login.page') }}"
                                class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-semibold text-sm transition shadow-lg shadow-cyan-500/25">
                                Get Started
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenu = !mobileMenu"
                class="md:hidden text-slate-400 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenu" class="md:hidden bg-slate-900 border-b border-slate-800 px-6 py-4 space-y-3">
            <a href="#" @click.prevent="currentTab = 'home'; mobileMenu = false"
                class="block text-slate-300 hover:text-white">Home</a>
            <a href="#" @click.prevent="currentTab = 'services'; mobileMenu = false"
                class="block text-slate-300 hover:text-white">Services</a>
            <a href="#" @click.prevent="currentTab = 'about'; mobileMenu = false"
                class="block text-slate-300 hover:text-white">About Us</a>
            <a href="#" @click.prevent="currentTab = 'contact'; mobileMenu = false"
                class="block text-slate-300 hover:text-white">Contact Us</a>
            <div class="pt-3 border-t border-slate-800 flex flex-col gap-2">
                <a href="{{ route('login') }}"
                    class="w-full text-center py-2 rounded-lg bg-slate-800 text-white font-medium">Log in</a>
                <a href="{{ route('register') }}"
                    class="w-full text-center py-2 rounded-lg bg-cyan-500 text-slate-950 font-semibold">Get Started</a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">

        <!-- ==================== PAGE 1: HOME ==================== -->
        <div x-show="currentTab === 'home'" class="space-y-20 pb-16">
            <!-- Hero Section -->
            <section class="max-w-7xl mx-auto px-6 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 flex flex-col items-start space-y-6">
                    <div
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs font-semibold uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                        Enterprise Grade Payment Infrastructure
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white leading-[1.1]">
                        Advanced <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Payin,
                            Payout & Auto Settlement</span>
                    </h1>
                    <p class="text-slate-400 text-lg max-w-xl leading-relaxed">
                        Scale your enterprise operations with high-success-rate payment aggregation, instantaneous API
                        payouts, multi-bank auto reconciliation, and utility recharges.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                        <a href="{{ route('login.page') }}"
                            class="inline-flex items-center justify-center px-8 py-4 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-base transition shadow-xl shadow-cyan-500/20">
                            Create Merchant Account
                        </a>
                        <button @click="currentTab = 'services'"
                            class="inline-flex items-center justify-center px-8 py-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 font-semibold text-base border border-slate-800 transition">
                            Explore Services
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-5 relative">
                    <div
                        class="absolute -inset-1 rounded-2xl bg-gradient-to-tr from-cyan-500 to-blue-600 opacity-20 blur-xl">
                    </div>
                    <div class="relative rounded-2xl bg-slate-900 border border-slate-800 p-6 space-y-4 shadow-2xl">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                            <span class="text-sm font-medium text-slate-400">Live Gateway Cluster</span>
                            <span
                                class="px-2.5 py-0.5 rounded-full bg-cyan-500/10 text-cyan-400 text-xs font-medium border border-cyan-500/20">99.99%
                                Uptime</span>
                        </div>
                        <div class="space-y-3">
                            <div
                                class="flex justify-between items-center p-3.5 rounded-xl bg-slate-950 border border-slate-800/60">
                                <span class="text-sm font-medium text-slate-300">UPI Dynamic Routing</span>
                                <span class="text-xs text-cyan-400 font-semibold">Sub-second Latency</span>
                            </div>
                            <div
                                class="flex justify-between items-center p-3.5 rounded-xl bg-slate-950 border border-slate-800/60">
                                <span class="text-sm font-medium text-slate-300">IMPS / NEFT Disbursal</span>
                                <span class="text-xs text-blue-400 font-semibold">Instant Credit</span>
                            </div>
                            <div
                                class="flex justify-between items-center p-3.5 rounded-xl bg-slate-950 border border-slate-800/60">
                                <span class="text-sm font-medium text-slate-300">Automated Settlements</span>
                                <span class="text-xs text-cyan-400 font-semibold">T+0 Multi-batch</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Statistics Section -->
            <section class="border-y border-slate-800 bg-slate-900/50 py-12">
                <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="space-y-2">
                        <h3
                            class="text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">
                            450M+</h3>
                        <p class="text-sm font-medium text-slate-400 uppercase tracking-widest">Transactions Processed
                        </p>
                    </div>
                    <div class="space-y-2">
                        <h3
                            class="text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">
                            2.5 Lakh+</h3>
                        <p class="text-sm font-medium text-slate-400 uppercase tracking-widest">Active Business Clients
                        </p>
                    </div>
                    <div class="space-y-2">
                        <h3
                            class="text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">
                            99.9%</h3>
                        <p class="text-sm font-medium text-slate-400 uppercase tracking-widest">Success Rate Index</p>
                    </div>
                </div>
            </section>

            <!-- Core Advantage Grid Section -->
            <section class="max-w-7xl mx-auto px-6 space-y-12">
                <div class="text-center max-w-2xl mx-auto space-y-4">
                    <h2 class="text-xs font-semibold text-cyan-400 uppercase tracking-widest">Why Choose BestPay</h2>
                    <h3 class="text-3xl font-bold text-white">Engineered For Unmatched Reliability</h3>
                    <p class="text-slate-400">Built from the ground up to support high-frequency enterprise
                        requirements with zero downtime guarantees.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-4">
                        <div
                            class="h-12 w-12 rounded-xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center font-bold text-lg">
                            01</div>
                        <h4 class="text-xl font-bold text-white">Smart Dynamic Routing</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">Our proprietary routing algorithm
                            automatically switches transaction paths across banking partners in real time to secure
                            maximum success rates.</p>
                    </div>
                    <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-4">
                        <div
                            class="h-12 w-12 rounded-xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center font-bold text-lg">
                            02</div>
                        <h4 class="text-xl font-bold text-white">Instant Ledger Audit</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">Never lose track of a single cent. Every
                            payin and payout transaction is instantly logged, verified, and mapped to your internal
                            dashboard system.</p>
                    </div>
                    <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-4">
                        <div
                            class="h-12 w-12 rounded-xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center font-bold text-lg">
                            03</div>
                        <h4 class="text-xl font-bold text-white">Bank-Grade Protection</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">Protect your platform against fraudulent
                            threats using advanced encryption layers, multi-factor signatures, and automated
                            tokenization.</p>
                    </div>
                </div>
            </section>

            <!-- Infinite Auto-Scrolling Trusted Partners (Right to Left) -->
            <section class="max-w-7xl mx-auto px-6 space-y-8 overflow-hidden pt-8">
                <div class="text-center space-y-2">
                    <h4 class="text-xs font-semibold text-cyan-400 uppercase tracking-widest">Enterprise Ecosystem</h4>
                    <h3 class="text-2xl font-bold text-white">Trusted By Industry Leaders At Scale</h3>
                </div>

                <div
                    class="relative w-full overflow-hidden [mask-image:_linear-gradient(to_right,transparent_0,_black_128px,_black_calc(100%-128px),transparent_100%)]">
                    <div class="flex gap-6 w-max animate-infinite-scroll">
                        <!-- Partner Set 1 -->
                        <div class="flex items-center gap-6">
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                NEXUS <span class="text-cyan-400 text-xs ml-1">PAY</span>
                            </div>
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                GLOBAL<span class="text-blue-400 text-xs ml-1">CAP</span>
                            </div>
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                VORTEX <span class="text-cyan-400 text-xs ml-1">TECH</span>
                            </div>
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                PULSE <span class="text-blue-400 text-xs ml-1">FIN</span>
                            </div>
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                APEX <span class="text-cyan-400 text-xs ml-1">BANK</span>
                            </div>
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                ZENITH <span class="text-blue-400 text-xs ml-1">X</span>
                            </div>
                        </div>
                        <!-- Partner Set 2 (Duplicate for smooth infinite ticker effect) -->
                        <div class="flex items-center gap-6" aria-hidden="true">
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                NEXUS <span class="text-cyan-400 text-xs ml-1">PAY</span>
                            </div>
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                GLOBAL<span class="text-blue-400 text-xs ml-1">CAP</span>
                            </div>
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                VORTEX <span class="text-cyan-400 text-xs ml-1">TECH</span>
                            </div>
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                PULSE <span class="text-blue-400 text-xs ml-1">FIN</span>
                            </div>
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                APEX <span class="text-cyan-400 text-xs ml-1">BANK</span>
                            </div>
                            <div
                                class="w-48 h-20 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 font-bold tracking-wider">
                                ZENITH <span class="text-blue-400 text-xs ml-1">X</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- ==================== PAGE 2: SERVICES ==================== -->
        <section x-show="currentTab === 'services'" class="max-w-7xl mx-auto px-6 py-16 lg:py-24 space-y-16">
            <div class="text-center max-w-2xl mx-auto space-y-4">
                <h2 class="text-xs font-semibold text-cyan-400 uppercase tracking-widest">Our Offerings</h2>
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">Enterprise Financial Services
                    Suite</h2>
                <p class="text-slate-400">A robust collection of modular payment APIs and automated ledger systems
                    engineered for modern digital businesses.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Payin Details -->
                <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-6">
                    <div
                        class="h-14 w-14 rounded-2xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center font-bold text-2xl">
                        IN</div>
                    <h3 class="text-2xl font-bold text-white">Smart Payin Gateway</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Accept customer checkout payments seamlessly via UPI QR, intent flows, credit and debit cards,
                        net banking, and dynamic virtual accounts. Our engine features automatic fallback channels to
                        guarantee highest conversion percentages.
                    </p>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cyan-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Dynamic QR generation with zero manual tracking</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cyan-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Instant webhook triggers upon payment confirmation</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cyan-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Multi-currency and multi-channel routing</li>
                    </ul>
                </div>

                <!-- Payout Details -->
                <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-6">
                    <div
                        class="h-14 w-14 rounded-2xl bg-blue-500/15 text-blue-400 flex items-center justify-center font-bold text-2xl">
                        OUT</div>
                    <h3 class="text-2xl font-bold text-white">Instant Payout Engine</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Disburse customer refunds, vendor invoices, merchant settlements, and employee salaries 24/7/365
                        straight to recipient bank accounts or UPI handles with auto-retry protocols for failed banking
                        nodes.
                    </p>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> IMPS, NEFT, RTGS & UPI payout modes</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Bulk transfer execution via CSV upload or API batch</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Built-in beneficiary name verification check</li>
                    </ul>
                </div>

                <!-- Auto Settlement Details -->
                <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-6">
                    <div
                        class="h-14 w-14 rounded-2xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center font-bold text-2xl">
                        AS</div>
                    <h3 class="text-2xl font-bold text-white">Auto Settlement Matrix</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Eliminate the headache of manual ledger reconciliation. Trigger automated batch settlements and
                        multi-party split payments straight to your designated corporate bank accounts on custom
                        schedules.
                    </p>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cyan-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Multi-cycle batch execution daily (T+0 or T+1)</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cyan-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Automated platform commission and fee deduction</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-cyan-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Detailed downloadable accounting statements</li>
                    </ul>
                </div>

                <!-- Recharge Details -->
                <div class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-6">
                    <div
                        class="h-14 w-14 rounded-2xl bg-blue-500/15 text-blue-400 flex items-center justify-center font-bold text-2xl">
                        RC</div>
                    <h3 class="text-2xl font-bold text-white">Recharge & BBPS Suite</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Embed nationwide prepaid/postpaid mobile recharges, DTH connections, electricity bills, and
                        Bharat Bill Payment System utilities straight into your platform with guaranteed carrier uptime.
                    </p>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Instant operator plan fetching APIs</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> High margin returns per successful utility bill</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg> Unified BBPS compliance framework</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- ==================== PAGE 3: ABOUT US ==================== -->
        <section x-show="currentTab === 'about'" class="max-w-5xl mx-auto px-6 py-16 lg:py-24 space-y-16">
            <div class="text-center max-w-2xl mx-auto space-y-4">
                <h2 class="text-xs font-semibold text-cyan-400 uppercase tracking-widest">Our Corporate Identity</h2>
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">About BestPay</h2>
                <p class="text-slate-400">Powering the next generation of digital commerce and financial inclusion
                    through ultra-reliable cloud infrastructure.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
                <div
                    class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-4 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-3">Our Core Vision</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            At BestPay, we believe that moving capital across the digital ecosystem should be as
                            frictionless as sending an instant message. We bridge the gap between legacy banking rails
                            and dynamic modern enterprises, abstracting away complex regulatory hurdles and routing
                            protocols into clean developer endpoints.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-800 text-xs text-cyan-400 font-medium">Empowering 2.5 Lakh+
                        Active Businesses</div>
                </div>
                <div
                    class="bg-slate-900 border border-slate-800 p-8 rounded-2xl space-y-4 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-3">Security & Compliance First</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            Security is embedded into every layer of our architecture. We employ enterprise-grade
                            256-bit data encryption, rigorous cryptographic webhook signatures, multi-factor
                            authentication controls, and strict adherence to global financial compliance frameworks to
                            safeguard every transaction ledger.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-800 text-xs text-blue-400 font-medium">99.9% Core
                        Operational Uptime</div>
                </div>
            </div>

            <div
                class="bg-gradient-to-r from-slate-900 to-slate-900/50 border border-slate-800 p-8 rounded-2xl text-center space-y-6">
                <h3 class="text-2xl font-bold text-white">Engineered For High-Volume Growth</h3>
                <p class="text-slate-400 text-sm max-w-2xl mx-auto leading-relaxed">
                    Whether you are an emerging fintech startup processing your initial thousands of transactions or an
                    established national corporation handling massive multi-million request loads daily, BestPay's
                    cloud-native infrastructure scales automatically to match your unique operational tempo.
                </p>
                <div class="pt-2">
                    <button @click="currentTab = 'contact'"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-sm transition shadow-lg shadow-cyan-500/20">
                        Partner With Us Today
                    </button>
                </div>
            </div>
        </section>

        <!-- ==================== PAGE 4: CONTACT US ==================== -->
        <section x-show="currentTab === 'contact'" class="max-w-5xl mx-auto px-6 py-16 lg:py-24 space-y-12">
            <div class="text-center space-y-4 max-w-2xl mx-auto">
                <h2 class="text-xs font-semibold text-cyan-400 uppercase tracking-widest">Connect With Us</h2>
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">Get in Touch With Our Expert Team
                </h2>
                <p class="text-slate-400">Have custom enterprise volume requirements or technical integration
                    questions? Our dedicated fintech support desk is active 24/7/365.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Contact Information Cards -->
                <div class="space-y-6">
                    <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl space-y-2">
                        <h4 class="text-sm font-semibold text-cyan-400 uppercase tracking-wider">Corporate Headquarters
                        </h4>
                        <p class="text-sm text-slate-300">Cyber City, Phase 2, Fintech Tower, Level 14, Sector 48,
                            Gurugram, India</p>
                    </div>
                    <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl space-y-2">
                        <h4 class="text-sm font-semibold text-cyan-400 uppercase tracking-wider">Direct Support Desk
                        </h4>
                        <p class="text-sm text-slate-300">support@bestpay-enterprise.com<br>+91 (011) 4500-8900</p>
                    </div>
                    <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl space-y-2">
                        <h4 class="text-sm font-semibold text-cyan-400 uppercase tracking-wider">Developer Assistance
                        </h4>
                        <p class="text-sm text-slate-300">api-help@bestpay-enterprise.com<br>Sandbox environment active
                            24/7</p>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-2xl">
                    <form
                        @submit.prevent="alert('Thank you! Your message has been sent successfully. Our team will contact you shortly.')"
                        class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-medium text-slate-300">Your Full Name</label>
                                <input type="text" required
                                    class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500"
                                    placeholder="John Doe">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-medium text-slate-300">Business Email Address</label>
                                <input type="email" required
                                    class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500"
                                    placeholder="john@company.com">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-medium text-slate-300">Subject / Service Interested In</label>
                            <select
                                class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500">
                                <option>Smart Payin Gateway Integration</option>
                                <option>Instant Payout API Solution</option>
                                <option>Auto Settlement & Reconciliation</option>
                                <option>Recharge & BBPS API</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-medium text-slate-300">Message</label>
                            <textarea rows="4" required
                                class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500"
                                placeholder="Tell us about your expected monthly transaction volume..."></textarea>
                        </div>
                        <button type="submit"
                            class="w-full py-4 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-base transition shadow-lg shadow-cyan-500/20">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-900 py-8 text-center text-xs text-slate-500 space-y-2">
        <p>&copy; {{ date('Y') }} BestPay Technologies. All rights reserved. Built on Laravel Engine.</p>
        <div class="flex justify-center gap-6">
            <a href="#" @click.prevent="currentTab = 'home'" class="hover:text-slate-300">Privacy Policy</a>
            <a href="#" @click.prevent="currentTab = 'home'" class="hover:text-slate-300">Terms of Service</a>
            <a href="#" @click.prevent="currentTab = 'contact'" class="hover:text-slate-300">Support Desk</a>
        </div>
    </footer>

</body>

</html>
