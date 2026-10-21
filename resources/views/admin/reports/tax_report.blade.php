<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Laporan Rekapitulasi Pajak - CTC Finance</title>
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
    @include('admin.partials.layout-start', ['pageTitle' => 'Laporan pajak'])

    <section class="ctc-workspace space-y-6 max-w-6xl mx-auto">

        <!-- Toolbar Filter & Ekspor (No Print) -->
        <div class="no-print ctc-panel rounded-xl border border-slate-200/80 bg-white p-4 shadow-sm flex flex-col xl:flex-row justify-between items-start xl:items-end gap-4">
            <!-- Form Filter Sejajar -->
            <form action="{{ route('admin.reports.tax') }}" method="GET" class="flex items-end gap-2.5 flex-wrap w-full xl:w-auto">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Filter Skema Pajak</label>
                    <select name="tax_id" class="px-3 py-2 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        <option value="">-- Semua Skema Pajak --</option>
                        @foreach($taxes as $t)
                            <option value="{{ $t->id }}" {{ ($reportData['tax_id'] ?? '') == $t->id ? 'selected' : '' }}>
                                {{ $t->code }} - {{ $t->name }} ({{ $t->rate }}%)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $reportData['start_date'] ?? '' }}" class="px-3 py-2 border border-slate-300 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $reportData['end_date'] ?? '' }}" class="px-3 py-2 border border-slate-300 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                </div>

                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-lg transition-all shadow-sm active:scale-[0.98]">
                    Tampilkan
                </button>
            </form>

            <!-- Aksi Ekspor & Cetak warna khusus tapi presisi -->
            <div class="flex items-center gap-2 w-full xl:w-auto justify-end">
                <a href="{{ route('admin.reports.tax.excel', request()->query()) }}" class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs rounded-lg transition-all shadow-sm active:scale-[0.98]">
                    Export Excel
                </a>

                <button type="button" onclick="window.print()" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-lg transition-all shadow-sm active:scale-[0.98]">
                    Cetak
                </button>

                <a href="{{ route('dashboard') }}" class="px-3.5 py-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 font-medium text-xs rounded-lg transition-all shadow-sm active:scale-[0.98]">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Document Sheet -->
        <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white p-8 shadow-sm space-y-6">

            <!-- Header Dokumen -->
            <div class="text-center border-b border-slate-100 pb-5">
                <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600 mb-1">CTC Finance Report</p>
                <h1 class="text-2xl font-bold text-slate-900 uppercase tracking-tight">Laporan Rekapitulasi Pajak (PPN &amp; PPh)</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Periode: {{ isset($reportData['start_date']) && $reportData['start_date'] ? \Carbon\Carbon::parse($reportData['start_date'])->translatedFormat('d F Y') : 'Semua Periode' }}
                    {{ isset($reportData['end_date']) && $reportData['end_date'] ? 's/d ' . \Carbon\Carbon::parse($reportData['end_date'])->translatedFormat('d F Y') : '' }}
                </p>
            </div>

            <!-- Table Data Rekapitulasi Pajak -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50/80">
                            <th scope="col" class="py-3 px-3">Tanggal</th>
                            <th scope="col" class="py-3 px-3">No. Jurnal</th>
                            <th scope="col" class="py-3 px-3">Skema Pajak</th>
                            <th scope="col" class="py-3 px-3">Akun COA</th>
                            <th scope="col" class="py-3 px-3">Keterangan / Memo</th>
                            <th scope="col" class="py-3 px-3 text-right">Nilai Pajak (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($reportData['tax_entries'] ?? [] as $entry)
                            @php
                                $taxValue = $entry->credit > 0 ? $entry->credit : $entry->debit;
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3 px-3 whitespace-nowrap text-slate-600">{{ $entry->journal->journal_date ?? '-' }}</td>
                                <td class="py-3 px-3 font-mono font-bold text-slate-900 whitespace-nowrap">{{ $entry->journal->journal_number ?? '-' }}</td>
                                <td class="py-3 px-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border bg-purple-50 text-purple-700 border-purple-200/60">
                                        {{ $entry->tax->code ?? 'PAJAK' }} ({{ $entry->tax->rate ?? 0 }}%)
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-slate-800">
                                    <strong class="font-mono text-slate-900">{{ $entry->account->code ?? '-' }}</strong> - {{ $entry->account->name ?? '-' }}
                                </td>
                                <td class="py-3 px-3 text-slate-600">{{ $entry->memo ?? $entry->journal->description ?? '-' }}</td>
                                <td class="py-3 px-3 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                    Rp {{ number_format($taxValue, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    Tidak ada rekapitulasi transaksi pajak pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-slate-900 font-bold bg-slate-50 text-slate-900">
                            <td colspan="5" class="py-3.5 px-3 text-right uppercase tracking-wider text-xs">Total Akumulasi Pajak Terpotong / Terpungut:</td>
                            <td class="py-3.5 px-3 text-right font-mono text-slate-900 bg-slate-100 tabular-nums whitespace-nowrap">
                                Rp {{ number_format($reportData['total_tax_amount'] ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Footer Tanda Tangan (Print View) -->
            <div class="hidden print:flex justify-between pt-12 text-center text-sm text-slate-800">
                <div>
                    <p class="mb-14">Dibuat Oleh,</p>
                    <p class="font-bold underline">{{ auth()->user()->name ?? 'Staff Akuntansi' }}</p>
                    <p class="text-xs text-slate-500">Staff Perpajakan / Akuntan</p>
                </div>
                <div>
                    <p class="mb-14">Disetujui Oleh,</p>
                    <p class="font-bold underline">( .................................... )</p>
                    <p class="text-xs text-slate-500">Manager Keuangan &amp; Pajak</p>
                </div>
            </div>

        </div>
    </section>

    @include('admin.partials.layout-end')
</body>
</html>