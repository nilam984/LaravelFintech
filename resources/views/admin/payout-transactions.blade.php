@extends('layouts.app')

@section('title', 'Payout Transactions')

@section('content')
<main class="p-4 sm:p-8 space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-fintechDarkText">
                Payout Transactions
            </h1>

            <p class="text-sm text-fintechMutedText mt-1">
                View and manage all payout transactions.
            </p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <input type="text"
                placeholder="Search..."
                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-fintechCyan focus:ring-2 focus:ring-fintechCyan/20 outline-none">

            <select
                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm bg-white">
                <option>All Status</option>
                <option>Pending</option>
                <option>Processing</option>
                <option>Success</option>
                <option>Failed</option>
            </select>

            <input type="date"
                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">

            <input type="date"
                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm">

            <button
                class="border border-slate-300 hover:bg-slate-100 rounded-lg">
                Reset
            </button>

        </div>
    </div>

    <!-- Table -->
    <div class="bg-white border rounded-xl overflow-hidden p-3">

        <table id="payoutTable" class="min-w-full whitespace-nowrap">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>User</th>
                    <th>Order ID</th>
                    <th>Bank</th>
                    <th>Account No.</th>
                    <th>IFSC</th>
                    <th>Amount</th>
                    <th>Charge</th>
                    <th>GST</th>
                    <th>Net Amount</th>
                    <th>UTR</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>1</td>
                    <td>User</td>
                    <td>PAY123456</td>
                    <td>HDFC Bank</td>
                    <td>XXXXXXXX1234</td>
                    <td>HDFC0001234</td>
                    <td>₹5,000</td>
                    <td>₹25</td>
                    <td>₹4.50</td>
                    <td>₹4,970.50</td>
                    <td>UTR987654321</td>

                    <td>
                        <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">
                            Success
                        </span>
                    </td>

                    <td>03 Aug 2026</td>

                    <td>

                        <button class="text-cyan-600">
                            <i class="bi bi-eye-fill"></i>
                        </button>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</main>
@endsection

@section('scripts')
<script>
$(function () {
    $('#payoutTable').DataTable({
        responsive: true,
        scrollX: true,
        searching: false,
        ordering: true,
        paging: true
    });
});
</script>
@endsection