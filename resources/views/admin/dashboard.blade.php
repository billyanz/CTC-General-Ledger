<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Ringkasan Keuangan - CTC Finance</title>
    @vite('resources/css/app.css')
</head>
<body class="ctc-admin-layout bg-slate-50/50">
    @include('admin.partials.layout-start', ['pageTitle' => 'Ringkasan keuangan'])

    <section class="ctc-workspace space-y-6">
        {{-- Header Section --}}
        <div class="ctc-section-heading flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div>
                <p class="ctc-section-eyebrow text-xs font-semibold uppercase tracking-wider text-emerald-600">Ikhtisar</p>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Ringkasan Keuangan</h2>
            </div>
            <p class="text-sm text-slate-500">Posisi utama dan aktivitas kas terbaru.</p>
        </div>

        {{-- Stat Cards Grid (Metrik Utama) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Kas Masuk --}}
            <div class="ctc-panel p-5 rounded-xl border border-slate-200/80 bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between text-slate-500 mb-3">
                    <span class="text-xs font-semibold uppercase tracking-wider">Kas Masuk</span>
                    <div class="p-2 rounded-lg bg-emerald-50 text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900 tabular-nums">
                    <span class="text-xs font-normal text-slate-400">Rp</span> {{ number_format($data['kas_masuk'] ?? 0, 0, ',', '.') }}
                </p>
            </div>

            {{-- Kas Keluar --}}
            <div class="ctc-panel p-5 rounded-xl border border-slate-200/80 bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between text-slate-500 mb-3">
                    <span class="text-xs font-semibold uppercase tracking-wider">Kas Keluar</span>
                    <div class="p-2 rounded-lg bg-rose-50 text-rose-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900 tabular-nums">
                    <span class="text-xs font-normal text-slate-400">Rp</span> {{ number_format($data['kas_keluar'] ?? 0, 0, ',', '.') }}
                </p>
            </div>

            {{-- Laba / Rugi Bersih --}}
            @php
                $labaRugi = $data['laba_rugi_bersih'] ?? 0;
                $isPositive = $labaRugi >= 0;
            @endphp
            <div class="ctc-panel p-5 rounded-xl border border-slate-200/80 bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between text-slate-500 mb-3">
                    <span class="text-xs font-semibold uppercase tracking-wider">Laba / Rugi Bersih</span>
                    <div class="p-2 rounded-lg {{ $isPositive ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold {{ $isPositive ? 'text-emerald-600' : 'text-rose-600' }} tabular-nums">
                    <span class="text-xs font-normal text-slate-400">Rp</span> {{ number_format($labaRugi, 0, ',', '.') }}
                </p>
            </div>

            {{-- Gaji Bulan Ini --}}
            <div class="ctc-panel p-5 rounded-xl border border-slate-200/80 bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between text-slate-500 mb-3">
                    <span class="text-xs font-semibold uppercase tracking-wider">Gaji Bulan Ini</span>
                    <div class="p-2 rounded-lg bg-blue-50 text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900 tabular-nums">
                    <span class="text-xs font-normal text-slate-400">Rp</span> {{ number_format($data['gaji_bulan_ini'] ?? 0, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- Panel Transaksi Kas Terbaru --}}
        <section class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm overflow-hidden" aria-labelledby="recent-transactions-heading">
            <div class="ctc-panel-heading p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 id="recent-transactions-heading" class="text-base font-semibold text-slate-900">Transaksi kas terbaru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Aktivitas transaksi terakhir yang tercatat.</p>
                </div>
                @can('manage-cash-transactions')
                    <a href="{{ route('admin.cash-transactions.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Buka transaksi kas <span aria-hidden="true">→</span>
                    </a>
                @endcan
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[42rem] text-left text-sm">
                    <thead class="bg-slate-50/80 border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th scope="col" class="py-3 px-5">No. Transaksi</th>
                            <th scope="col" class="py-3 px-5">Tanggal</th>
                            <th scope="col" class="py-3 px-5">Tipe</th>
                            <th scope="col" class="py-3 px-5 text-right">Jumlah</th>
                            <th scope="col" class="py-3 px-5">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($data['transaksi_terakhir'] ?? [] as $trx)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-5 font-mono text-xs font-medium text-slate-900">{{ $trx->transaction_number }}</td>
                                <td class="py-3.5 px-5 text-slate-600 whitespace-nowrap">{{ $trx->transaction_date }}</td>
                                <td class="py-3.5 px-5">
                                    <span @class([
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border',
                                        'bg-emerald-50 text-emerald-700 border-emerald-200/60' => $trx->type === 'in',
                                        'bg-slate-100 text-slate-700 border-slate-200/60' => $trx->type !== 'in',
                                    ])>
                                        {{ $trx->type === 'in' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 text-right font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-5 max-w-xs truncate text-slate-500" title="{{ $trx->description }}">
                                    {{ $trx->description ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-sm text-slate-400">
                                    <div class="flex flex-col items-center justify-center space-y-1">
                                        <svg class="w-7 h-7 text-slate-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>Belum ada transaksi kas tercatat.</span>
                                    </div>
                                </td>
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