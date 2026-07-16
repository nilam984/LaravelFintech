@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')



    <!-- ==================== MAIN CONTENT MASTER COMPONENT ==================== -->
    <main class="p-4 sm:p-8 space-y-6">

        <!-- Welcome Title Area -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-fintechDarkText">Console Workspace</h1>
                <p class="text-sm text-fintechMutedText mt-1">Real-time valuation analytics and operational infrastructure
                    tracking.</p>
            </div>
            <div class="flex items-center gap-2">
                <button
                    class="bg-white hover:bg-slate-50 text-fintechDarkText border border-fintechLightBorder px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">
                    Export Audit Logs
                </button>
                <button
                    class="bg-fintechCyan text-white hover:bg-fintechCyanHover px-4 py-2 rounded-xl text-sm font-semibold transition shadow-md shadow-fintechCyan/10">
                    + Allocation Transfer
                </button>
            </div>
        </div>

        <!-- Cards System Metric Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div
                class="bg-fintechLightCard border border-fintechLightBorder p-6 rounded-2xl relative overflow-hidden group shadow-sm">
                <div
                    class="absolute -right-4 -bottom-4 text-slate-100 text-8xl font-bold group-hover:scale-110 transition duration-500">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="flex justify-between items-start">
                    <span class="text-xs font-semibold text-fintechMutedText tracking-wider uppercase">Net Capital
                        Balance</span>
                    <span
                        class="text-fintechGreen bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full text-[10px] font-bold">+12.4%</span>
                </div>
                <div class="text-3xl font-bold tracking-tight mt-3 text-fintechDarkText"> ₹1,248,390<span
                        class="text-fintechCyan">.50</span></div>
                <p class="text-xs text-fintechMutedText mt-2 flex items-center gap-1">
                    <i class="bi bi-check2-circle text-fintechGreen"></i> Vault settlement confirmed
                </p>
            </div>

            <div
                class="bg-fintechLightCard border border-fintechLightBorder p-6 rounded-2xl relative overflow-hidden group shadow-sm">
                <div
                    class="absolute -right-4 -bottom-4 text-slate-100 text-8xl font-bold group-hover:scale-110 transition duration-500">
                    <i class="bi bi-graph-up text-8xl"></i>
                </div>
                <div class="flex justify-between items-start">
                    <span class="text-xs font-semibold text-fintechMutedText tracking-wider uppercase">Active Staking
                        Yield</span>
                    <span
                        class="text-cyan-600 bg-cyan-50 border border-cyan-200 px-2 py-0.5 rounded-full text-[10px] font-bold">APY
                        8.42%</span>
                </div>
                <div class="text-3xl font-bold tracking-tight mt-3 text-fintechDarkText"> ₹84,120<span
                        class="text-fintechCyan">.00</span></div>
                <p class="text-xs text-fintechMutedText mt-2 flex items-center gap-1">
                    <i class="bi bi-lightning-charge-fill text-amber-500"></i> Accruing interest compound live
                </p>
            </div>

            <div
                class="bg-fintechLightCard border border-fintechLightBorder p-6 rounded-2xl relative overflow-hidden group shadow-sm">
                <div
                    class="absolute -right-4 -bottom-4 text-slate-100 text-8xl font-bold group-hover:scale-110 transition duration-500">
                    <i class="bi bi-safe2"></i>
                </div>
                <div class="flex justify-between items-start">
                    <span class="text-xs font-semibold text-fintechMutedText tracking-wider uppercase">Risk Exposure
                        index</span>
                    <span
                        class="text-fintechMutedText bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-full text-[10px] font-bold">Minimal</span>
                </div>
                <div class="text-3xl font-bold tracking-tight mt-3 text-fintechDarkText">0.12<span
                        class="text-fintechMutedText">%</span></div>
                <p class="text-xs text-fintechMutedText mt-2 flex items-center gap-1">
                    <i class="bi bi-shield-lock-fill text-fintechCyan"></i> Protected by Apex Insurance
                </p>
            </div>
        </div>

        <!-- Performance Graphics Analytics Split Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div
                class="lg:col-span-2 bg-fintechLightCard border border-fintechLightBorder p-6 rounded-2xl flex flex-col justify-between shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-fintechDarkText">Performance Tracking Vector</h3>
                        <p class="text-xs text-fintechMutedText">Aggregated tracking asset values vs platform baselines.</p>
                    </div>
                    <div class="flex gap-2 text-xs bg-slate-100 border border-fintechLightBorder p-1 rounded-xl">
                        <span
                            class="px-2.5 py-1 rounded-lg bg-white text-fintechDarkText shadow-sm font-bold cursor-pointer">7D</span>
                        <span
                            class="px-2.5 py-1 rounded-lg text-fintechMutedText hover:text-fintechDarkText cursor-pointer">30D</span>
                        <span
                            class="px-2.5 py-1 rounded-lg text-fintechMutedText hover:text-fintechDarkText cursor-pointer">1Y</span>
                    </div>
                </div>

                <div class="relative w-full h-56 flex items-end">
                    <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                        <div class="w-full border-t border-slate-100"></div>
                        <div class="w-full border-t border-slate-100"></div>
                        <div class="w-full border-t border-slate-100"></div>
                        <div class="w-full border-t border-slate-100"></div>
                    </div>

                    <svg class="w-full h-full drop-shadow-[0_4px_12px_rgba(0,180,216,0.15)]" viewBox="0 0 500 200"
                        preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="chartGlow" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#00b4d8" stop-opacity="0.15" />
                                <stop offset="100%" stop-color="#00b4d8" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <path d="M 0 160 Q 100 80 200 120 T 400 40 T 500 20" fill="none" stroke="#00b4d8"
                            stroke-width="3" stroke-linecap="round"></path>
                        <path d="M 0 160 Q 100 80 200 120 T 400 40 T 500 20 L 500 200 L 0 200 Z" fill="url(#chartGlow)">
                        </path>
                    </svg>
                </div>

                <div
                    class="flex justify-between text-fintechMutedText text-[10px] font-bold tracking-wider mt-4 px-2 uppercase">
                    <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                </div>
            </div>

            <!-- Settlement Operations Feeds -->
            <div class="bg-fintechLightCard border border-fintechLightBorder p-6 rounded-2xl flex flex-col shadow-sm">
                <h3 class="text-lg font-bold mb-1 text-fintechDarkText">Live Settlements</h3>
                <p class="text-xs text-fintechMutedText mb-4">Latest secure network verification actions.</p>

                <div class="space-y-3.5 flex-1 overflow-y-auto max-h-72 pr-1">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center text-fintechGreen">
                                <i class="bi bi-arrow-down-left"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-fintechDarkText">Asset Settlement</p>
                                <p class="text-[10px] text-fintechMutedText">Via Node #84920</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-emerald-600">+₹4,290.00</p>
                            <p class="text-[9px] text-fintechMutedText">Just Now</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-500">
                                <i class="bi bi-arrow-up-right"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-fintechDarkText">External Liquidity</p>
                                <p class="text-[10px] text-fintechMutedText">Secured Apex Yield</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-rose-600">-₹1,100.00</p>
                            <p class="text-[9px] text-fintechMutedText">4 min ago</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center text-fintechGreen">
                                <i class="bi bi-arrow-down-left"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-fintechDarkText">Dividends Accrued</p>
                                <p class="text-[10px] text-fintechMutedText">USDT Smart Yield</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-emerald-600">+₹182.40</p>
                            <p class="text-[9px] text-fintechMutedText">1 hr ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>



@endsection
