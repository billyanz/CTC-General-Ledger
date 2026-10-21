<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Laporan Posisi Keuangan (Neraca) - CTC Finance</title>
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
    @include('admin.partials.layout-start', ['pageTitle' => 'Neraca'])

    <section class="ctc-workspace space-y-6 max-w-6xl mx-auto">

        <!-- Toolbar Filter & Action (No Print) -->
        <div class="no-print ctc-panel rounded-xl border border-slate-200/80 bg-white p-4 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.reports.balance-sheet') }}" method="GET" class="flex items-center gap-3 flex-wrap w-full sm:w-auto">
                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Per Tanggal:</span>
                <input type="date" name="as_of_date" value="{{ $reportData['as_of_date'] }}" class="px-3.5 py-1.5 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                <button type="submit" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                    Tampilkan
                </button>
            </form>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.reports.balance-sheet.excel', request()->query()) }}" class="px-4 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
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

        <!-- Document Sheet -->
        <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white p-8 shadow-sm space-y-6">

            <!-- Header Dokumen -->
            <div class="text-center border-b border-slate-100 pb-5">
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600 mb-1">CTC Finance Report</p>
                <h1 class="text-2xl font-bold text-slate-900 uppercase tracking-tight">Laporan Posisi Keuangan (Neraca)</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Per Tanggal {{ \Carbon\Carbon::parse($reportData['as_of_date'])->translatedFormat('d F Y') }}
                </p>
            </div>

            <!-- Warning Status Balance -->
            @if(!$reportData['is_balanced'])
                <div class="no-print p-4 bg-rose-50 border border-rose-200/80 text-rose-800 rounded-xl text-sm font-semibold text-center shadow-sm">
                    Perhatian: Neraca tidak seimbang! Total Aset tidak sama dengan Total Kewajiban + Ekuitas.
                </div>
            @endif

            <!-- Body Grid: Aset (Kiri) vs Kewajiban & Ekuitas (Kanan) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

                <!-- BAGIAN ASET (AKTIVA) -->
                <div class="space-y-4">
                    <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b-2 border-slate-900 pb-2">
                        Aset (Aktiva)
                    </h2>

                    <table class="w-full text-xs text-left border-collapse">
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($reportData['assets'] as $asset)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-2.5 px-2 text-slate-800 font-medium">
                                        <span class="font-mono text-slate-900 font-semibold mr-2">{{ $asset->code }}</span>{{ $asset->name }}
                                    </td>
                                    <td class="py-2.5 px-2 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                        Rp {{ number_format($asset->balance, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-4 text-center text-slate-400">
                                        Tidak ada saldo aset.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="flex justify-between items-center font-bold text-xs text-slate-900 p-3 bg-slate-50 rounded-lg border border-slate-200/80">
                        <span class="uppercase tracking-wider">Total Aset</span>
                        <span class="font-mono text-sm tabular-nums">Rp {{ number_format($reportData['total_assets'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- BAGIAN KEWAJIBAN & EKUITAS (PASIVA) -->
                <div class="space-y-6">

                    <!-- KEWAJIBAN -->
                    <div class="space-y-4">
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b-2 border-slate-900 pb-2">
                            Kewajiban (Liabilitas)
                        </h2>
                        <table class="w-full text-xs text-left border-collapse">
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse($reportData['liabilities'] as $liab)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-2.5 px-2 text-slate-800 font-medium">
                                            <span class="font-mono text-slate-900 font-semibold mr-2">{{ $liab->code }}</span>{{ $liab->name }}
                                        </td>
                                        <td class="py-2.5 px-2 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                            Rp {{ number_format($liab->balance, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="py-4 text-center text-slate-400">
                                            Tidak ada kewajiban.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="flex justify-between items-center font-bold text-xs text-slate-900 pt-2 border-t border-slate-200">
                            <span class="uppercase tracking-wider text-[11px] text-slate-600">Total Kewajiban</span>
                            <span class="font-mono tabular-nums">Rp {{ number_format($reportData['total_liabilities'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- EKUITAS -->
                    <div class="space-y-4">
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b-2 border-slate-900 pb-2">
                            Ekuitas (Modal)
                        </h2>
                        <table class="w-full text-xs text-left border-collapse">
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach($reportData['equities'] as $equity)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-2.5 px-2 text-slate-800 font-medium">
                                            <span class="font-mono text-slate-900 font-semibold mr-2">{{ $equity->code }}</span>{{ $equity->name }}
                                        </td>
                                        <td class="py-2.5 px-2 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                            Rp {{ number_format($equity->balance, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-2.5 px-2 text-slate-800 font-medium">
                                        Laba / (Rugi) Tahun Berjalan
                                    </td>
                                    <td class="py-2.5 px-2 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                        Rp {{ number_format($reportData['current_earnings'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="flex justify-between items-center font-bold text-xs text-slate-900 pt-2 border-t border-slate-200">
                            <span class="uppercase tracking-wider text-[11px] text-slate-600">Total Ekuitas</span>
                            <span class="font-mono tabular-nums">Rp {{ number_format($reportData['total_equity'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- TOTAL PASIVA -->
                    <div class="flex justify-between items-center font-bold text-xs text-slate-900 p-3 bg-slate-50 rounded-lg border border-slate-200/80">
                        <span class="uppercase tracking-wider">Total Kewajiban &amp; Ekuitas</span>
                        <span class="font-mono text-sm tabular-nums">Rp {{ number_format($reportData['total_liabilities_and_equity'], 0, ',', '.') }}</span>
                    </div>

                </div>

            </div>

            <!-- Footer Tanda Tangan (Print View) -->
            <div class="hidden print:flex justify-between pt-12 text-center text-sm text-slate-800">
                <div>
                    <p class="mb-14">Dibuat Oleh,</p>
                    <p class="font-bold underline">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">Akuntan / Staff Keuangan</p>
                </div>
                <div>
                    <p class="mb-14">Disetujui Oleh,</p>
                    <p class="font-bold underline">( .................................... )</p>
                    <p class="text-xs text-slate-500">Direktur / Manager</p>
                </div>
            </div>

        </div>
    </section>

    @include('admin.partials.layout-end')
</body>
</html>