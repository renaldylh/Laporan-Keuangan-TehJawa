<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan {{ $report->period_start->format('d M Y') }} - {{ $report->period_end->format('d M Y') }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 0;
            padding: 24px;
        }
        h1, h2, h3, h4 {
            margin: 0 0 8px 0;
            color: #111827;
        }
        .header {
            text-align: center;
            margin-bottom: 24px;
        }
        .header h1 {
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .muted {
            color: #6b7280;
        }
        .grid {
            display: grid;
            gap: 12px;
        }
        .grid-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 16px;
            background-color: #f9fafb;
        }
        .card h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 6px;
        }
        .card .value {
            font-size: 16px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .mt-4 { margin-top: 16px; }
        .mt-6 { margin-top: 24px; }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-success {
            background-color: #d1fae5;
            color: #047857;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .footer {
            margin-top: 32px;
            font-size: 10px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Teh Jawa POS</h1>
        <p class="muted">Laporan Keuangan Periode {{ $report->period_start->format('d M Y') }} - {{ $report->period_end->format('d M Y') }}</p>
    </div>

    <div class="grid grid-3">
        <div class="card">
            <h3>Total Pemasukan</h3>
            <div class="value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
        </div>
        <div class="card">
            <h3>Total Pengeluaran</h3>
            <div class="value">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
        </div>
        <div class="card">
            <h3>Laba / Rugi</h3>
            <div class="value" style="color: {{ $profit >= 0 ? '#047857' : '#b91c1c' }};">Rp {{ number_format($profit, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="grid grid-3 mt-3">
        <div class="card">
            <h3>Jumlah Transaksi</h3>
            <div class="value">{{ $transactionCount }}</div>
            <p class="muted">{{ $incomeCount }} pemasukan / {{ $expenseCount }} pengeluaran</p>
        </div>
        <div class="card">
            <h3>Rata-rata Transaksi Masuk</h3>
            <div class="value">Rp {{ number_format($avgTransactionValue, 0, ',', '.') }}</div>
        </div>
        <div class="card">
            <h3>Tanggal Cetak</h3>
            <div class="value">{{ now()->format('d M Y H:i') }}</div>
        </div>
    </div>

    <div class="mt-6">
        <h2>Pemasukan per Menu</h2>
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Rata-rata</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incomeDetails->sortByDesc('total_amount') as $detail)
                    <tr>
                        <td>{{ $detail['menu_name'] }}</td>
                        <td class="text-center">{{ $detail['quantity'] }}</td>
                        <td class="text-right">Rp {{ number_format($detail['avg_price'], 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($detail['total_amount'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center muted">Tidak ada data pemasukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <h2>Pengeluaran per Kategori</h2>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th class="text-center">Jumlah Transaksi</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenseDetails->sortByDesc('total_amount') as $detail)
                    <tr>
                        <td>{{ $detail['category'] }}</td>
                        <td class="text-center">{{ $detail['count'] }}</td>
                        <td class="text-right">Rp {{ number_format($detail['total_amount'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center muted">Tidak ada data pengeluaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <h2>Detail Transaksi</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th class="text-center">Jenis</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_date->format('d M Y') }}</td>
                        <td>
                            <strong>{{ $transaction->description }}</strong>
                            @if($transaction->transactionDetails->count() > 0)
                                <div class="muted mt-2">
                                    @foreach($transaction->transactionDetails as $detail)
                                        {{ $detail->quantity }}x {{ $detail->menu_name }}@if(!$loop->last), @endif
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $transaction->type === 'income' ? 'badge-success' : 'badge-danger' }}">
                                {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        <td class="text-right">{{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center muted">Tidak ada transaksi pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($report->notes)
        <div class="mt-4">
            <h2>Catatan</h2>
            <p class="muted">{{ $report->notes }}</p>
        </div>
    @endif

    <div class="footer">
        Laporan dihasilkan pada {{ now()->format('d M Y H:i:s') }} | Teh Jawa POS
    </div>
</body>
</html>
