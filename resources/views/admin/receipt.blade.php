<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Payout Receipt</title>

    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            /* background: #f3f4f6; */
            margin: 0;padding: 15px;color: #2d3748;font-size: 13px;
        }
        .receipt {
            /* background: #fff; */
            border: 1px solid #dcdcdc;border-radius: 10px;overflow: hidden;
        }
        .title {
            /* background: #f5f5f5; */
            padding: 14px 20px;font-size: 22px;font-weight: bold; border-bottom: 1px solid #ddd;
        }

        .header { padding: 22px;display: table; width: 100%;box-sizing: border-box; }
        .left,
        .right {display: table-cell; width: 50%; vertical-align: top; }
        .logo {width: 55px;height: 55px;border-radius: 50%; border: 2px solid #16a34a; text-align: center; line-height: 55px;font-size: 24px;font-weight: bold;color: #16a34a;
            float: left;margin-right: 12px;
        }
        .company {font-size: 20px;font-weight: bold; }
        .sub {color: #666;font-size: 12px; margin-top: 4px;}
        .address {font-size: 12px; color: #555;line-height: 1.5; margin-top: 8px;}
        .section-wrap { display: table; width: 100%;box-sizing: border-box; padding: 0 22px 22px; }
        .section {display: table-cell;width: 50%;vertical-align: top;padding-right: 15px;}
        .section:last-child {padding-right: 0; }
        h3 {font-size: 16px; margin: 0 0 12px;padding-bottom: 6px;border-bottom: 1px solid #ddd;color: #374151;}
        table {width: 100%;border-collapse: collapse;}
        td {padding: 7px 0;vertical-align: top;}
        td:first-child { color: #6b7280;width: 42%;}
        td:last-child { text-align: right; font-weight: bold;}
        .success {color: #0f9d58;}
        .amount {color: #0d6efd; font-size: 28px;font-weight: bold;}
        .footer {border-top: 1px solid #ddd;text-align: center;padding: 15px;font-size: 11px;color: #777;}
        .icon img {width: 160px;height: 50px;object-fit: contain;}
    </style>
</head>

<body>

    <div class="receipt">

        <div class="title">
            Payment Receipt
        </div>

        <div class="header">

            @php
                $logo = base64_encode(file_get_contents(public_path('assets/groscope-logo1.png')));
            @endphp

            <div class="left">
                <div class="icon">
                    <img src="data:image/png;base64,{{ $logo }}" alt="Groscope Logo">
                </div>

                {{-- <div class="company">Groscope</div>
                <div class="sub">PRIVATE LIMITED</div> --}}
            </div>

            <div class="right">
                <div class="company" style="font-size:18px;">
                    Address
                </div>

                <div class="sub">
                    {{ $transaction->bussiness_info->city ?? '--' }} {{ $transaction->bussiness_info->state ?? ', --' }} {{ $transaction->bussiness_info->pin_code ?? ' --' }}
                </div>

                {{-- <div class="address">
                    Transaction processed securely through TejoPay Payment Gateway.
                </div> --}}
            </div>

        </div>

        <div class="section-wrap">
            <div class="section">
                <h3>Transaction Info</h3>
                <table>
                    <tr>
                        <td>Client Ref ID</td>
                        <td>{{ $transaction->client_ref_id ?? '--' }}</td>
                    </tr>
                    <tr>
                        <td>UTR</td>
                        <td>{{ $transaction->utr ?? '--' }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td class="success">{{ strtoupper($transaction->status) }}</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <td>Product</td>
                        <td>Payout</td>
                    </tr>
                </table>
                <br>
                <h3>Amount Details</h3>
                <table>
                    <tr>
                        <td>Amount</td>
                        <td class="amount">₹{{ number_format($transaction->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Fee</td>
                        <td>₹{{ number_format($transaction->fee, 2) }}</td>
                    </tr>
                    <tr>
                        <td>GST</td>
                        <td>₹{{ number_format($transaction->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Final</td>
                        <td>₹{{ number_format($transaction->final_amount, 2) }}</td>
                    </tr>
                </table>
            </div>
            <div class="section">
                <h3>Payer Details</h3>
                <table>
                    <tr>
                        <td>Name</td>
                        <td>{{ $transaction->beneficiary_name ?? '--' }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $transaction->beneficiary_email ?? '--' }}</td>
                    </tr>
                    <tr>
                        <td>Account</td>
                        <td>{{ $transaction->account_number }}</td>
                    </tr>
                    <tr>
                        <td>IFSC</td>
                        <td>{{ $transaction->ifsc_code }}</td>
                    </tr>
                    <tr>
                        <td>Bank</td>
                        <td>{{ $transaction->bank_name }}</td>
                    </tr>
                </table>
                <br>
                <h3>Payee & Notes</h3>
                <table>
                    {{-- <tr>
                        <td>Beneficiary</td>
                        <td>{{ $transaction->beneficiary_name }}</td>
                    </tr> --}}
                    <tr>
                        <td>Remark</td>
                        <td>{{ $transaction->remarks ?? 'Fund Transfer' }}</td>
                    </tr>
                    <tr>
                        <td>Mode</td>
                        <td>{{ $transaction->mode }}</td>
                    </tr>
                    <tr>
                        <td>Gateway</td>
                        <td>{{ $transaction->gateway_type }}</td>
                    </tr>
                    {{-- <tr>
                        <td>Client Ref</td>
                        <td>{{ $transaction->client_ref_id ?? '--' }}</td>
                    </tr> --}}
                </table>
            </div>
        </div>
        <div class="footer">
            This is a computer-generated receipt. No signature required.
        </div>
    </div>
</body>

</html>
