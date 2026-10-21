<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Laporan Rekapitulasi Penggajian - CTC Finance</title>
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
    @include('admin.partials.layout-start', ['pageTitle' => 'Laporan penggajian'])

    <section class="ctc-workspace space-y-6 max-w-6xl mx-auto">

        <!-- Toolbar Filter (No Print) -->
        <div class="no-print ctc-panel rounded-xl border border-slate-200/80 bg-white p-4 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.reports.payroll') }}" method="GET" class="flex items-center gap-3 flex-wrap w-full sm:w-auto">
                <span class="text-xs font-semibold text-slate-700 uppercase tracking-wider">Pilih Periode Gaji:</span>
                <input type="month" name="period" value="{{ $reportData['period'] }}" class="px-3.5 py-2 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-lg transition-all shadow-sm active:scale-[0.98]">
                    Tampilkan
                </button>
            </form>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.reports.payroll.excel', request()->query()) }}" class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs rounded-lg transition-all shadow-sm active:scale-[0.98]">
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
                <h1 class="text-2xl font-bold text-slate-900 uppercase tracking-tight">Laporan Rekapitulasi Penggajian Karyawan</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Periode: {{ \Carbon\Carbon::createFromFormat('Y-m', $reportData['period'])->translatedFormat('F Y') }}
                </p>
            </div>

            <!-- Table Data Rekapitulasi Gaji -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider bg-slate-50/80">
                            <th scope="col" class="py-3 px-3">No</th>
                            <th scope="col" class="py-3 px-3">Nama Karyawan</th>
                            <th scope="col" class="py-3 px-3 text-right">Gaji Pokok</th>
                            <th scope="col" class="py-3 px-3 text-right">Total Tunjangan</th>
                            <th scope="col" class="py-3 px-3 text-right">Potongan Lain</th>
                            <th scope="col" class="py-3 px-3 text-right">PPh 21</th>
                            <th scope="col" class="py-3 px-3 text-right">Gaji Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($reportData['payrolls'] as $index => $payroll)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3 px-3 font-semibold text-slate-500 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="py-3 px-3 font-semibold text-slate-900 whitespace-nowrap">{{ $payroll->user->name }}</td>
                                <td class="py-3 px-3 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                    Rp {{ number_format($payroll->basic_salary, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                    Rp {{ number_format($payroll->total_allowance, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                    Rp {{ number_format($payroll->total_deduction, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3 text-right font-mono font-semibold text-rose-600 tabular-nums whitespace-nowrap">
                                    Rp {{ number_format($payroll->pph21_amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3 text-right font-mono font-bold text-slate-900 tabular-nums whitespace-nowrap">
                                    Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    Tidak ada data penggajian untuk periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-slate-900 font-bold bg-slate-50 text-slate-900">
                            <td colspan="2" class="py-3.5 px-3 uppercase tracking-wider text-xs">
                                Total Pembayaran ({{ $reportData['total_employees'] }} Karyawan):
                            </td>
                            <td class="py-3.5 px-3 text-right font-mono tabular-nums whitespace-nowrap">
                                Rp {{ number_format($reportData['total_basic_salary'], 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-3 text-right font-mono tabular-nums whitespace-nowrap">
                                Rp {{ number_format($reportData['total_allowance'], 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-3 text-right font-mono tabular-nums whitespace-nowrap">
                                Rp {{ number_format($reportData['total_deduction'], 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-3 text-right font-mono text-rose-700 tabular-nums whitespace-nowrap">
                                Rp {{ number_format($reportData['total_pph21'], 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-3 text-right font-mono text-slate-900 bg-slate-100 tabular-nums whitespace-nowrap">
                                Rp {{ number_format($reportData['total_net_salary'], 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Footer Tanda Tangan (Print View) -->
            <div class="hidden print:flex justify-between pt-12 text-center text-sm text-slate-800">
                <div>
                    <p class="mb-14">Dibuat Oleh,</p>
                    <p class="font-bold underline">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">Staff Payroll / HRD</p>
                </div>
                <div>
                    <p class="mb-14">Disetujui Oleh,</p>
                    <p class="font-bold underline">( .................................... )</p>
                    <p class="text-xs text-slate-500">Manager Keuangan / Direktur</p>
                </div>
            </div>

        </div>
    </section>

    @include('admin.partials.layout-end')
</body>
</html>