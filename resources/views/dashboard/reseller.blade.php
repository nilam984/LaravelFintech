@extends('layouts.app')

@section('title', 'Reseller Dashboard')

@section('content')
    <main class="min-h-screen bg-slate-50/50 p-4 sm:p-6 lg:p-8 space-y-8">
        <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                    Welcome {{ auth()->user()->name }}
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Monitor your merchant network, track commissions, and manage instant settlements.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 font-medium text-sm shadow-sm transition-all">
                    <i class="bi bi-download text-base"></i> Export Report
                </button>
                <button
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white hover:from-cyan-600 hover:to-blue-700 font-medium text-sm shadow-lg shadow-cyan-500/20 hover:shadow-cyan-500/30 transition-all">
                    <i class="bi bi-person-plus text-base"></i> Add Merchant
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 text-white rounded-2xl p-5 shadow-md hover:-translate-y-1 transition">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs opacity-80">Wallet Balance</p>
                        <h2 class="text-2xl font-bold mt-1">₹1,24,850</h2>
                        <p class="text-xs mt-1 opacity-80">Available</p>
                    </div>
                    <i class="bi bi-wallet2 text-3xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-2xl p-5 shadow-md hover:-translate-y-1 transition">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs opacity-80">Today's Commission</p>
                        <h2 class="text-2xl font-bold mt-1">₹8,240</h2>
                        <p class="text-xs mt-1 opacity-80">+14%</p>
                    </div>
                    <i class="bi bi-cash-stack text-3xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-indigo-500 to-violet-600 text-white rounded-2xl p-5 shadow-md hover:-translate-y-1 transition">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs opacity-80">My Merchants</p>
                        <h2 class="text-2xl font-bold mt-1">86</h2>
                        <p class="text-xs mt-1 opacity-80">5 Added This Week</p>
                    </div>
                    <i class="bi bi-people text-3xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-400 to-orange-500 text-white rounded-2xl p-5 shadow-md hover:-translate-y-1 transition">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs opacity-80">Settlement Pending</p>
                        <h2 class="text-2xl font-bold mt-1">₹42,500</h2>
                        <p class="text-xs mt-1 opacity-80">7 Requests</p>
                    </div>
                    <i class="bi bi-hourglass-split text-3xl"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-slate-800">Commission Growth</h3>
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-cyan-50 text-cyan-600 border border-cyan-200/60 text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-ping"></span> Live
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Last 7 days earnings analytics performance</p>
                    </div>

                    <div
                        class="flex items-center bg-slate-100 p-1 rounded-xl self-start sm:self-auto text-xs font-semibold">
                        <button class="px-3 py-1.5 rounded-lg bg-white text-slate-800 shadow-sm transition-all">7
                            Days</button>
                        <button class="px-3 py-1.5 text-slate-500 hover:text-slate-800 transition-all">30 Days</button>
                    </div>
                </div>
                <div id="commissionChart" class="w-full min-h-[300px]"></div>
            </div>
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Transaction Success</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Network Volume Overview</p>
                    </div>
                    <span class="p-2 bg-slate-100 rounded-xl text-slate-600">
                        <i class="bi bi-pie-chart text-lg"></i>
                    </span>
                </div>
                <div class="relative flex items-center justify-center my-2">
                    <div id="successDonutChart" class="w-full"></div>
                </div>
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

        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-5">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="#"
                    class="group p-5 rounded-2xl border border-slate-200/80 hover:border-cyan-300 hover:bg-cyan-50/40 text-center transition-all duration-300">
                    <div
                        class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <i class="bi bi-person-plus text-xl"></i>
                    </div>
                    <p class="font-semibold text-slate-800 text-sm">Add Merchant</p>
                    <span class="text-xs text-slate-400 mt-0.5 block">Onboard new client</span>
                </a>
                <a href="#"
                    class="group p-5 rounded-2xl border border-slate-200/80 hover:border-indigo-300 hover:bg-indigo-50/40 text-center transition-all duration-300">
                    <div
                        class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <i class="bi bi-wallet text-xl"></i>
                    </div>
                    <p class="font-semibold text-slate-800 text-sm">Wallet</p>
                    <span class="text-xs text-slate-400 mt-0.5 block">Manage funds</span>
                </a>
                <a href="#"
                    class="group p-5 rounded-2xl border border-slate-200/80 hover:border-emerald-300 hover:bg-emerald-50/40 text-center transition-all duration-300">
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <i class="bi bi-receipt text-xl"></i>
                    </div>
                    <p class="font-semibold text-slate-800 text-sm">Commission</p>
                    <span class="text-xs text-slate-400 mt-0.5 block">View earnings</span>
                </a>
                <a href="#"
                    class="group p-5 rounded-2xl border border-slate-200/80 hover:border-amber-300 hover:bg-amber-50/40 text-center transition-all duration-300">
                    <div
                        class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <i class="bi bi-bank text-xl"></i>
                    </div>
                    <p class="font-semibold text-slate-800 text-sm">Settlement</p>
                    <span class="text-xs text-slate-400 mt-0.5 block">Payout requests</span>
                </a>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commissionOptions = {
                series: [{
                    name: 'Commission Earned',
                    data: [2100, 3800, 4500, 5200, 6800, 7500, 8240]
                }],
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
                colors: ['#06B6D4'],
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
                        formatter: (val) => '₹' + val.toLocaleString('en-IN')
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
                }
            };
            new ApexCharts(document.querySelector("#commissionChart"), commissionOptions).render();

            // Transaction Success Donut Chart
            const successOptions = {
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
            new ApexCharts(document.querySelector("#successDonutChart"), successOptions).render();
        });
    </script>
@endsection
