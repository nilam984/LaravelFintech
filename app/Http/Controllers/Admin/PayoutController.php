<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayoutTransaction;
use Barryvdh\DomPDF\Facade\Pdf;

class PayoutController extends Controller
{
    public function transactions()
    {
        return view('admin.payout-transactions');
    }

    public function userpayout()
    {
        return view('user.payout-order');
    }

    public function downloadReceipt($id)
    {
        $transaction = PayoutTransaction::with('user')->findOrFail($id);

        if ($transaction->status !== 'success') {
            abort(404);
        }

        $pdf = Pdf::loadView('admin.receipt', compact('transaction'));

        return $pdf->download('Payout-Receipt-'.$transaction->id.'.pdf');
    }
}
