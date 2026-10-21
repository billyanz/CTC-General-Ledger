<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Laporan Laba Rugi - CTC Finance</title>
    @vite('resources/css/app.css')
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .shadow-sm { box-shadow: none !important; }
            .border { border-color: #e2e8f0 !important; }
        }
    </style>
</head>
<body class="ctc-admin-layout bg-slate-50/50">
    @include('admin.partials.layout-start', ['pageTitle' => 'Laba rugi'])

    <section class="ctc-workspace space-y-6 max-w-4xl mx-auto">

        <!-- Toolbar Filter & Action (No Print) -->
        <div class="no-print ctc-panel rounded-xl border border-slate-200/80 bg-white p-4 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.reports.profit-loss') }}" method="GET" class="flex items-center gap-2 flex-wrap w-full sm:w-auto">
                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Periode:</span>
                <input type="date" name="start_date" value="{{ $reportData['start_date'] }}" class="px-3.5 py-1.5 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                <span class="text-xs text-slate-400 font-medium">s/d</span>
                <input type="date" name="end_date" value="{{ $reportData['end_date'] }}" class="px-3.5 py-1.5 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                <button type="submit" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                    Filter
                </button>
            </form>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.reports.profit-loss.excel', request()->query()) }}" class="px-4 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                    Export Excel
                </a>
                <button type="button" onclick="window.print()" class="px-4 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                    Cetak
                </button>
                <a href="{{ route('dashboard') }}" class="px-4 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/80 font-medium text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Document Paper -->
        <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white p-8 shadow-sm space-y-6">

            <!-- Header Dokumen -->
            <div class="text-center border-b border-slate-100 pb-5">
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600 mb-1">CTC Finance Report</p>
                <h1 class="text-2xl font-bold text-slate-900 uppercase tracking-tight">Laporan Laba Rugi</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Periode: {{ \Carbon\Carbon::parse($reportData['start_date'])->translatedFormat('d F Y') }}
                    s/d {{ \Carbon\Carbon::parse($reportData['end_date'])->translatedFormat('d F Y') }}
                </p>
            </div>

            <!-- BAGIAN PENDAPATAN -->
            <div class="space-y-3">
                <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b border-slate-200 pb-2">1. Pendapatan (Revenue)</h2>
                <table class="w-full text-xs text-left border-collapse">
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($reportData['revenues'] as $rev)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-2.5 px-2 text-slate-800 font-medium">
                                    <span class="font-mono text-slate-900 font-semibold mr-2">{{ $rev->code }}</span>{{ $rev->name }}
                                </td>
                                <td class="py-2.5 px-2 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                    Rp {{ number_format($rev->period_balance, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-slate-400">
                                    Tidak ada pendapatan pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="flex justify-between items-center font-bold text-xs text-slate-900 p-3 bg-slate-50 rounded-lg border border-slate-100">
                    <span class="uppercase tracking-wider">Total Pendapatan</span>
                    <span class="font-mono text-sm tabular-nums">Rp {{ number_format($reportData['total_revenue'], 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- BAGIAN BEBAN & BIAYA -->
            <div class="space-y-3">
                <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b border-slate-200 pb-2">2. Beban &amp; Biaya (Expenses)</h2>
                <table class="w-full text-xs text-left border-collapse">
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($reportData['expenses'] as $exp)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-2.5 px-2 text-slate-800 font-medium">
                                    <span class="font-mono text-slate-900 font-semibold mr-2">{{ $exp->code }}</span>{{ $exp->name }}
                                </td>
                                <td class="py-2.5 px-2 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                    Rp {{ number_format($exp->period_balance, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-center text-slate-400">
                                    Tidak ada beban pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="flex justify-between items-center font-bold text-xs text-slate-900 p-3 bg-slate-50 rounded-lg border border-slate-100">
                    <span class="uppercase tracking-wider">Total Beban</span>
                    <span class="font-mono text-sm tabular-nums">Rp {{ number_format($reportData['total_expense'], 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- HASIL LABA / RUGI BERSIH -->
            <div @class([
                'flex justify-between items-center font-bold text-base p-4 rounded-xl border',
                'bg-emerald-50/80 border-emerald-200 text-emerald-950' => $reportData['net_profit'] >= 0,
                'bg-rose-50/80 border-rose-200 text-rose-950' => $reportData['net_profit'] < 0,
            ])>
                <span class="uppercase tracking-wider text-xs sm:text-sm">
                    {{ $reportData['net_profit'] >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}
                </span>
                <span class="font-mono text-lg tabular-nums">
                    Rp {{ number_format($reportData['net_profit'], 0, ',', '.') }}
                </span>
            </div>

            <!-- Signature Section (Print Only) -->
            <div class="hidden print:flex justify-between pt-12 text-center text-sm text-slate-800">
                <div>
                    <p class="mb-14">Dibuat Oleh,</p>
                    <p class="font-bold underline">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">Staff Keuangan / Akuntan</p>
                </div>
                <div>
                    <p class="mb-14">Disetujui Oleh,</p>
                    <p class="font-bold underline">( .................................... )</p>
                    <p class="text-xs text-slate-500">Direktur Utama</p>
                </div>
            </div>

        </div>
    </section>

    @include('admin.partials.layout-end')
</body>
</html>