@extends('layouts.app')

@section('title', 'PayIn & Payout Dashboard')

@section('content')
    <main class="min-h-screen bg-slate-50/50 p-4 sm:p-6 lg:p-8 space-y-8">

        <!-- Top Header & Admin Quick Controls -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ auth()->user()->name }}</h1>
                <p class="text-xs text-slate-500 mt-1">Manage system services, monitor PayIn/Payouts, and review live
                    transactions.</p>
            </div>
            {{-- <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <i class="bi bi-plus-lg"></i> Add New Service
                </button>
                <button
                    class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium text-xs rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <i class="bi bi-sliders"></i> Gateway Settings
                </button>
            </div> --}}
        </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 text-white rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs opacity-80">Today's PayIn</p>
                        <h2 class="text-2xl font-bold mt-1">₹8,45,230</h2>
                        <p class="text-[11px] mt-1 opacity-90">+18% vs Yesterday</p>
                    </div>
                    <div class="w-12 h-12  flex items-center justify-center">
                        <i class="bi bi-wallet2 text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs opacity-80">Today's Payout</p>
                        <h2 class="text-2xl font-bold mt-1">₹6,28,140</h2>
                        <p class="text-[11px] mt-1 opacity-90">124 Transactions</p>
                    </div>
                    <div class="w-12 h-12  flex items-center justify-center">
                        <i class="bi bi-send-check text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-400 to-orange-500 text-white rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs opacity-80">Pending Settlement</p>
                        <h2 class="text-2xl font-bold mt-1">₹1,12,000</h2>
                        <p class="text-[11px] mt-1 opacity-90">18 Requests</p>
                    </div>
                    <div class="w-12 h-12  flex items-center justify-center">
                        <i class="bi bi-hourglass-split text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-indigo-500 to-violet-600 text-white rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs opacity-80">Wallet Balance</p>
                        <h2 class="text-2xl font-bold mt-1">₹4,87,540</h2>
                        <p class="text-[11px] mt-1 opacity-90">Available</p>
                    </div>
                    <div class="w-12 h-12  flex items-center justify-center">
                        <i class="bi bi-bank text-3xl"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- System Services & Operations Grid -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Admin Services & Gateway Operations</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Quick access to manage active merchant APIs and payment
                        services</p>
                </div>
                <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">View All Services
                    &rarr;</a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <!-- Service Card 1 -->
                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 hover:shadow-md transition-all group cursor-pointer text-center">
                    <div
                        class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                        <i class="bi bi-qr-code-scan text-xl"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">UPI Collection</p>
                    <span class="inline-block px-2 py-0.5 mt-1 text-[10px] font-medium text-emerald-600 bg-emerald-50 rounded-full">Active</span>
                </div>

                <!-- Service Card 2 -->
                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 hover:shadow-md transition-all group cursor-pointer text-center">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                        <i class="bi bi-arrow-right-square text-xl"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">Instant Payout</p>
                    <span class="inline-block px-2 py-0.5 mt-1 text-[10px] font-medium text-emerald-600 bg-emerald-50 rounded-full">Active</span>
                </div>

                <!-- Service Card 3 -->
                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 hover:shadow-md transition-all group cursor-pointer text-center">
                    <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                        <i class="bi bi-phone text-xl"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">Recharge API</p>
                    <span class="inline-block px-2 py-0.5 mt-1 text-[10px] font-medium text-emerald-600 bg-emerald-50 rounded-full">Active</span>
                </div>

                <!-- Service Card 4 -->
                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 hover:shadow-md transition-all group cursor-pointer text-center">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                        <i class="bi bi-receipt text-xl"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">BBPS Utility</p>
                    <span
                        class="inline-block px-2 py-0.5 mt-1 text-[10px] font-medium text-emerald-600 bg-emerald-50 rounded-full">Active</span>
                </div>

                <!-- Service Card 5 -->
                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 hover:shadow-md transition-all group cursor-pointer text-center">
                    <div
                        class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                        <i class="bi bi-fingerprint text-xl"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">AEPS System</p>
                    <span
                        class="inline-block px-2 py-0.5 mt-1 text-[10px] font-medium text-amber-600 bg-amber-50 rounded-full">Maintenance</span>
                </div>

                <!-- Service Card 6 -->
                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-slate-200 hover:shadow-md transition-all group cursor-pointer text-center">
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                        <i class="bi bi-credit-card text-xl"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">DMT / Remittance</p>
                    <span
                        class="inline-block px-2 py-0.5 mt-1 text-[10px] font-medium text-emerald-600 bg-emerald-50 rounded-full">Active</span>
                </div>
            </div>
        </div>

        <!-- Charts Section Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Area Chart Card (PayIn vs Payout) -->
            <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm hover:shadow-md transition-shadow">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-slate-800">PayIn vs Payout Trend</h3>
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200/60 text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span> Live
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Real-time volume comparison over selected period</p>
                    </div>

                    <!-- Range Selector Controls -->
                    <div class="flex items-center bg-slate-100 p-1 rounded-xl self-start sm:self-auto text-xs font-semibold">
                        <button class="px-3 py-1.5 rounded-lg bg-white text-slate-800 shadow-sm transition-all">7
                            Days</button>
                        <button class="px-3 py-1.5 text-slate-500 hover:text-slate-800 transition-all">30 Days</button>
                    </div>
                </div>

                <!-- Interactive Apex Chart Render Target -->
                <div id="analyticsChart" class="w-full min-h-[300px]"></div>
            </div>

            <!-- Radial Donut Chart Card (Success Rate) -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">

                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Transaction Status</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Overall Performance Metric</p>
                    </div>
                    <span class="p-2 bg-slate-100 rounded-xl text-slate-600">
                        <i class="bi bi-pie-chart text-lg"></i>
                    </span>
                </div>

                <!-- Radial Chart Render Target -->
                <div class="relative flex items-center justify-center my-2">
                    <div id="statusChart" class="w-full"></div>
                </div>

                <!-- Status Stats Grid -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-slate-50 rounded-2xl p-3 text-center border border-slate-100">
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span class="text-xs font-medium text-slate-500">Success</span>
                        </div>
                        <p class="text-base font-bold text-slate-800">97.0%</p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-3 text-center border border-slate-100">
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <span class="text-xs font-medium text-slate-500">Pending</span>
                        </div>
                        <p class="text-base font-bold text-slate-800">2.0%</p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-3 text-center border border-slate-100">
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                            <span class="text-xs font-medium text-slate-500">Failed</span>
                        </div>
                        <p class="text-base font-bold text-slate-800">1.0%</p>
                    </div>
                </div>

            </div>

        </div>

        <!-- Recent System Transactions Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Live Merchant Transactions</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Latest PayIn and Payout logs across all gateways</p>
                </div>
                <button class="px-3 py-1.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">Export
                    CSV</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-semibold text-slate-400">
                            <th class="py-3 px-4">Txn ID</th>
                            <th class="py-3 px-4">Merchant</th>
                            <th class="py-3 px-4">Service</th>
                            <th class="py-3 px-4">Type</th>
                            <th class="py-3 px-4">Amount</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        <tr>
                            <td class="py-3 px-4 font-mono text-slate-800 font-medium">TXN98421039</td>
                            <td class="py-3 px-4 font-medium text-slate-700">Retail</td>
                            <td class="py-3 px-4">UPI Direct</td>
                            <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-cyan-50 text-cyan-600 font-semibold text-[11px]">PayIn</span>
                            </td>
                            <td class="py-3 px-4 font-bold text-slate-800">₹12,500</td>
                            <td class="py-3 px-4"><span
                                    class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 font-medium text-[11px]">Success</span>
                            </td>
                            <td class="py-3 px-4 text-right"><button
                                    class="text-indigo-600 hover:text-indigo-800 font-medium">Details</button></td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-mono text-slate-800 font-medium">TXN98421040</td>
                            <td class="py-3 px-4 font-medium text-slate-700">Apex Solutions</td>
                            <td class="py-3 px-4">IMPS Payout</td>
                            <td class="py-3 px-4"><span
                                    class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 font-semibold text-[11px]">Payout</span>
                            </td>
                            <td class="py-3 px-4 font-bold text-slate-800">₹45,000</td>
                            <td class="py-3 px-4"><span
                                    class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 font-medium text-[11px]">Pending</span>
                            </td>
                            <td class="py-3 px-4 text-right"><button
                                    class="text-indigo-600 hover:text-indigo-800 font-medium">Details</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const analyticsOptions = {
                series: [{
                        name: 'PayIn',
                        data: [120000, 240000, 390000, 510000, 680000, 750000, 845230]
                    },
                    {
                        name: 'Payout',
                        data: [80000, 150000, 280000, 410000, 490000, 560000, 628140]
                    }
                ],
                chart: {
                    type: 'area',
                    height: 310,
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'inherit',
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#06B6D4', '#10B981'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.0,
                        stops: [0, 90, 100]
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#94A3B8',
                            fontSize: '12px',
                            fontWeight: 500
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#94A3B8',
                            fontSize: '12px'
                        },
                        formatter: (val) => '₹' + (val / 1000) + 'k'
                    }
                },
                grid: {
                    borderColor: '#F1F5F9',
                    strokeDashArray: 4,
                    padding: {
                        top: 10,
                        right: 10,
                        bottom: 0,
                        left: 10
                    }
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: (val) => '₹' + val.toLocaleString('en-IN')
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    fontSize: '13px',
                    markers: {
                        radius: 12
                    }
                }
            };
            new ApexCharts(document.querySelector("#analyticsChart"), analyticsOptions).render();

            // 2. Transaction Status Donut Chart Integration
            const statusOptions = {
                series: [97, 2, 1],
                labels: ['Success', 'Pending', 'Failed'],
                chart: {
                    type: 'donut',
                    height: 250
                },
                colors: ['#10B981', '#F59E0B', '#EF4444'],
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 0
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '80%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Success Rate',
                                    fontSize: '12px',
                                    color: '#64748B',
                                    formatter: () => '97%'
                                }
                            }
                        }
                    }
                }
            };
            new ApexCharts(document.querySelector("#statusChart"), statusOptions).render();
        });
    </script>
@endsection
