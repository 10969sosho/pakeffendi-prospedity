@php
    $formatPrice = function ($value) {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    };

    $bankName = $activeBankAccount?->bank_name ?? config('payment.bank_name');
    $bankAccountNumber = $activeBankAccount?->account_number ?? config('payment.bank_account_number');
    $bankAccountName = $activeBankAccount?->account_name ?? config('payment.bank_account_name');
@endphp

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $salesOrder->so_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        .title { font-size: 18px; font-weight: 700; margin: 0 0 8px; }
        .muted { color: #6B7280; }
        .box { border: 1px solid #E5E7EB; padding: 12px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border-bottom: 1px solid #E5E7EB; vertical-align: top; }
        th { text-align: left; font-weight: 700; }
        .right { text-align: right; }
        .total { font-size: 14px; font-weight: 700; }
    </style>
</head>
<body>
    <div class="title">Invoice Pembelian Paket</div>
    <div class="muted">SO Number: {{ $salesOrder->so_number }}</div>
    <div class="muted">Tanggal: {{ $salesOrder->created_at?->format('Y-m-d H:i') }}</div>

    <div style="height: 14px;"></div>

    <div class="box">
        <table>
            <tr>
                <td style="width: 55%;">
                    <div style="font-weight:700; margin-bottom:6px;">Data Pembeli</div>
                    <div>{{ $salesOrder->customer_full_name }}</div>
                    <div>{{ $salesOrder->company_name }}</div>
                    <div>{{ $salesOrder->whatsapp_number }}</div>
                    <div>{{ $salesOrder->email }}</div>
                    @if($salesOrder->pic_number)
                        <div style="margin-top:6px;" class="muted">PIC Number: {{ $salesOrder->pic_number }}</div>
                    @endif
                </td>
                <td style="width: 45%;">
                    <div style="font-weight:700; margin-bottom:6px;">Ringkasan</div>
                    <div>Status: {{ $salesOrder->status }}</div>
                    <div class="muted">Harap simpan dokumen ini sebagai arsip.</div>
                </td>
            </tr>
        </table>
    </div>

    <div style="height: 14px;"></div>

    <div class="box">
        <table>
            <thead>
                <tr>
                    <th>Nama Paket</th>
                    <th class="right">Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $salesOrder->package_name }}</td>
                    <td class="right">{{ $formatPrice($salesOrder->final_price) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="right total">Total</td>
                    <td class="right total">{{ $formatPrice($salesOrder->final_price) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div style="height: 14px;"></div>

    <div class="box">
        <div style="font-weight:700; margin-bottom:6px;">Instruksi Pembayaran</div>
        <div>Bank: {{ $bankName }}</div>
        <div>No. Rekening: {{ $bankAccountNumber }}</div>
        <div>Atas Nama: {{ $bankAccountName }}</div>
        <div style="margin-top:6px;" class="muted">Berita transfer: {{ $salesOrder->so_number }}</div>
    </div>
</body>
</html>
