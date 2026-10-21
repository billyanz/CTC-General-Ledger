<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Pengolahan Gaji (Payroll) - CTC Finance</title>
    @vite('resources/css/app.css')
</head>
<body class="ctc-admin-layout bg-slate-50/50">
    @include('admin.partials.layout-start', ['pageTitle' => 'Penggajian'])

    <section class="ctc-workspace space-y-6">
        <!-- Alert Notifications -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200/80 text-emerald-800 rounded-xl text-sm shadow-sm" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200/80 text-rose-800 rounded-xl text-sm shadow-sm" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Header Action -->
        <div class="ctc-section-heading flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="ctc-section-eyebrow text-xs font-semibold uppercase tracking-wider text-emerald-600">Penggajian &amp; SDM</p>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Pengolahan Gaji &amp; PPh 21</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola penggajian karyawan dan integrasi otomatis ke jurnal keuangan.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/80 font-medium text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- Form Process Payroll -->
            <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm p-6 space-y-5 lg:col-span-1">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Proses Gaji Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Input penggajian dan potongan PPh 21 karyawan.</p>
                </div>

                <form action="{{ route('admin.payrolls.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Karyawan</label>
                        <select name="user_id" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">
                                    {{ $emp->name }} (Gaji Pokok: Rp {{ number_format($emp->base_salary, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Periode Gaji (YYYY-MM)</label>
                        <input type="month" name="period" value="{{ $period }}" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>

                    <!-- Component: Tunjangan -->
                    <div class="border-t border-slate-100 pt-3 space-y-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Tunjangan Tambahan (Opsional)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="allowances[0][name]" value="Tunjangan Makan" class="px-3 py-1.5 border border-slate-300 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <input type="number" name="allowances[0][amount]" placeholder="Jumlah Rp" class="px-3 py-1.5 border border-slate-300 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        </div>
                    </div>

                    <!-- Component: Potongan -->
                    <div class="border-t border-slate-100 pt-3 space-y-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Potongan Non-Pajak (Opsional)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="deductions[0][name]" value="BPJS Kesehatan" class="px-3 py-1.5 border border-slate-300 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <input type="number" name="deductions[0][amount]" placeholder="Jumlah Rp" class="px-3 py-1.5 border border-slate-300 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        </div>
                    </div>

                    <!-- Posting Account Selection -->
                    <div class="border-t border-slate-100 pt-3 space-y-3">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Pengaturan Jurnal Keuangan</label>

                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Akun Beban Gaji (Debit)</label>
                            <select name="salary_expense_account_id" required class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                                @foreach($expenseAccounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Akun Pembayaran Kas/Bank (Kredit)</label>
                            <select name="cash_account_id" required class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                                @foreach($cashAccounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Akun Hutang PPh 21 (Kredit)</label>
                            <select name="pph_account_id" class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                                <option value="">-- Gunakan Akun PPh Default --</option>
                                @foreach($liabilityAccounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 rounded-lg transition-all shadow-sm active:scale-[0.98]">
                        Hitung &amp; Proses Gaji
                    </button>
                </form>
            </div>

            <!-- List Payroll Completed -->
            <div class="lg:col-span-2 ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Daftar Gaji Periode {{ $period }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Rincian komponen gaji dan potongan pajak per pegawai.</p>
                    </div>
                    <form action="{{ route('admin.payrolls.index') }}" method="GET">
                        <input type="month" name="period" value="{{ $period }}" onchange="this.form.submit()" class="px-3 py-1.5 border border-slate-300 rounded-lg text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none">
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th scope="col" class="py-3.5 px-4">Pegawai</th>
                                <th scope="col" class="py-3.5 px-4 text-right">Gaji Pokok</th>
                                <th scope="col" class="py-3.5 px-4 text-right">Tunjangan</th>
                                <th scope="col" class="py-3.5 px-4 text-right">PPh 21</th>
                                <th scope="col" class="py-3.5 px-4 text-right">Gaji Bersih</th>
                                <th scope="col" class="py-3.5 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($payrolls as $p)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-slate-900 whitespace-nowrap">
                                        {{ $p->user->name }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-slate-700 tabular-nums whitespace-nowrap">
                                        Rp {{ number_format($p->basic_salary, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-slate-700 tabular-nums whitespace-nowrap">
                                        Rp {{ number_format($p->total_allowance, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-rose-600 tabular-nums whitespace-nowrap">
                                        Rp {{ number_format($p->pph21_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-900 tabular-nums whitespace-nowrap">
                                        Rp {{ number_format($p->net_salary, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border bg-emerald-50 text-emerald-700 border-emerald-200/60">
                                            {{ strtoupper($p->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400">
                                        Belum ada data penggajian untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    @include('admin.partials.layout-end')
</body>
</html>