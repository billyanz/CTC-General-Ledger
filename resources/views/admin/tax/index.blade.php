<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Otomatisasi Pajak (PPN &amp; PPh) - CTC Finance</title>
    @vite('resources/css/app.css')
</head>
<body class="ctc-admin-layout bg-slate-50/50">
    @include('admin.partials.layout-start', ['pageTitle' => 'Pemrosesan pajak'])

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
                <p class="ctc-section-eyebrow text-xs font-semibold uppercase tracking-wider text-emerald-600">Perpajakan &amp; Regulasi</p>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Otomatisasi Pajak (PPN &amp; PPh)</h2>
                <p class="text-sm text-slate-500 mt-1">Kalkulasi dan posting otomatis transaksi pemotongan / pemungutan pajak ke jurnal umum.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/80 font-medium text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- Form Kalkulator & Proses Pajak -->
            <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm p-6 space-y-5 lg:col-span-1">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Proses Pajak Transaksi</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Input kalkulasi perpajakan untuk transaksi berjalan.</p>
                </div>

                <form action="{{ route('admin.taxes.process') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Transaksi</label>
                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Transaksi</label>
                        <select name="transaction_type" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="sales">Penjualan (+ PPN Keluaran)</option>
                            <option value="purchase">Pembelian Jasa/Barang (- Potongan PPh 23)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Skema Pajak</label>
                        <select name="tax_id" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="">-- Pilih Skema Pajak --</option>
                            @foreach($taxes as $t)
                                <option value="{{ $t->id }}">
                                    {{ $t->code }} - {{ $t->name }} ({{ $t->rate }}%)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nilai Transaksi DPP / Subtotal (Rp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-medium text-slate-400 pointer-events-none">Rp</span>
                            <input type="number" name="subtotal" placeholder="0" min="1" required class="w-full pl-9 pr-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Akun Kas / Bank (Pembayaran)</label>
                        <select name="cash_account_id" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            @foreach($cashAccounts as $cash)
                                <option value="{{ $cash->id }}">{{ $cash->code }} - {{ $cash->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Akun Pendapatan / Beban</label>
                        <select name="revenue_expense_id" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }} ({{ strtoupper($acc->type) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan / Memo</label>
                        <textarea name="description" rows="2" placeholder="Catatan transaksi pajak..." class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none resize-y"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 rounded-lg transition-all shadow-sm active:scale-[0.98]">
                        Hitung &amp; Posting Jurnal Pajak
                    </button>
                </form>
            </div>

            <!-- Master Data Tarif Pajak -->
            <div class="lg:col-span-2 ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Master Data Tarif &amp; Akun Penampung Pajak</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar konfigurasi skema pajak dan mapping akun COA terkait.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th scope="col" class="py-3.5 px-4">Kode</th>
                                <th scope="col" class="py-3.5 px-4">Nama Pajak</th>
                                <th scope="col" class="py-3.5 px-4">Tipe</th>
                                <th scope="col" class="py-3.5 px-4 text-right">Tarif (%)</th>
                                <th scope="col" class="py-3.5 px-4">Akun COA Penampung</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($taxes as $tax)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4 font-mono font-bold text-slate-900 whitespace-nowrap">
                                        {{ $tax->code }}
                                    </td>
                                    <td class="py-3.5 px-4 font-medium text-slate-900">
                                        {{ $tax->name }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-purple-50 text-purple-700 border-purple-200/60">
                                            {{ $tax->type }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-900 tabular-nums whitespace-nowrap">
                                        {{ $tax->rate }}%
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600">
                                        @if($tax->account)
                                            <span class="font-mono text-slate-900 font-semibold">{{ $tax->account->code }}</span> - {{ $tax->account->name }}
                                        @else
                                            <span class="text-slate-400 italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">
                                        Belum ada master tarif pajak yang terdaftar.
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