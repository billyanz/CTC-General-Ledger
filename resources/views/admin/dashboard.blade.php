<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Ringkasan Keuangan - CTC Finance</title>
    @vite('resources/css/app.css')
</head>
<body class="ctc-admin-layout">
    @include('admin.partials.layout-start', ['pageTitle' => 'Ringkasan keuangan'])

    <section class="ctc-workspace">
        <div class="ctc-section-heading">
            <div>
                <p class="ctc-section-eyebrow">Ikhtisar</p>
                <h2>Ringkasan keuangan</h2>
            </div>
            <p>Posisi utama dan aktivitas kas terbaru.</p>
        </div>

        <section class="ctc-panel" aria-labelledby="financial-summary-heading">
            <div class="ctc-panel-heading">
                <div>
                    <h3 id="financial-summary-heading">Ringkasan periode berjalan</h3>
                    <p>Nilai keuangan dalam rupiah</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="ctc-financial-summary w-full text-left">
                    <thead>
                        <tr>
                            <th scope="col">Indikator</th>
                            <th scope="col" class="text-right">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="font-medium">Kas masuk</th>
                            <td class="text-right font-semibold text-green-800">Rp {{ number_format($data['kas_masuk'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="font-medium">Kas keluar</th>
                            <td class="text-right font-semibold text-slate-700">Rp {{ number_format($data['kas_keluar'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="font-medium">Laba / rugi bersih</th>
                            <td class="text-right font-semibold {{ ($data['laba_rugi_bersih'] ?? 0) >= 0 ? 'text-green-800' : 'text-red-700' }}">Rp {{ number_format($data['laba_rugi_bersih'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="font-medium">Gaji bulan ini</th>
                            <td class="text-right font-semibold text-slate-700">Rp {{ number_format($data['gaji_bulan_ini'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="ctc-panel" aria-labelledby="recent-transactions-heading">
            <div class="ctc-panel-heading">
                <div>
                    <h3 id="recent-transactions-heading">Transaksi kas terbaru</h3>
                    <p>Aktivitas transaksi terakhir yang tercatat.</p>
                </div>
                @can('manage-cash-transactions')
                    <a href="{{ route('admin.cash-transactions.index') }}" class="ctc-panel-link">Buka transaksi kas <span aria-hidden="true">→</span></a>
                @endcan
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[42rem] text-left">
                    <thead>
                        <tr>
                            <th scope="col">No. transaksi</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Tipe</th>
                            <th scope="col" class="text-right">Jumlah</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['transaksi_terakhir'] ?? [] as $trx)
                            <tr>
                                <td class="font-mono text-xs">{{ $trx->transaction_number }}</td>
                                <td>{{ $trx->transaction_date }}</td>
                                <td>
                                    <span @class([
                                        'ctc-status',
                                        'ctc-status-positive' => $trx->type === 'in',
                                        'ctc-status-neutral' => $trx->type !== 'in',
                                    ])>{{ $trx->type === 'in' ? 'Masuk' : 'Keluar' }}</span>
                                </td>
                                <td class="text-right font-semibold tabular-nums">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td class="max-w-sm truncate text-slate-600">{{ $trx->description ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-sm text-slate-500">Belum ada transaksi kas tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </section>

    @include('admin.partials.layout-end')
</body>
</html>
