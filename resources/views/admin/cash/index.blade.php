<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Transaksi Kas &amp; Bank - CTC Finance</title>
    @vite('resources/css/app.css')
</head>
<body class="ctc-admin-layout bg-slate-50/50">
    @include('admin.partials.layout-start', ['pageTitle' => 'Transaksi kas'])

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
                <p class="ctc-section-eyebrow text-xs font-semibold uppercase tracking-wider text-emerald-600">Kas &amp; Perbankan</p>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Transaksi Kas &amp; Bank</h2>
                <p class="text-sm text-slate-500 mt-1">Pencatatan pemasukan dan pengeluaran kas operasional.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/80 font-medium text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- Form Input Transaksi -->
            <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm p-6 space-y-5 lg:col-span-1">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Input Transaksi Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Entri penerimaan atau pengeluaran kas baru.</p>
                </div>

                <form action="{{ route('admin.cash-transactions.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Transaksi</label>
                        <select name="type" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="in">Kas Masuk (Pemasukan)</option>
                            <option value="out">Kas Keluar (Pengeluaran)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Transaksi</label>
                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Akun Kas / Bank Utama</label>
                        <select name="account_id" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="">-- Pilih Akun Kas/Bank --</option>
                            @foreach($cashAccounts as $account)
                                <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Akun Lawan (Kategori/Beban/Pendapatan)</label>
                        <select name="opposite_account_id" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="">-- Pilih Akun Lawan --</option>
                            @foreach($allAccounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }} ({{ strtoupper($acc->type) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jumlah Transaksi (Rp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-medium text-slate-400 pointer-events-none">Rp</span>
                            <input type="number" name="amount" min="1" step="0.01" placeholder="0" required class="w-full pl-9 pr-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan / Memo</label>
                        <textarea name="description" rows="3" placeholder="Catatan transaksi..." class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none resize-y"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 rounded-lg transition-all shadow-sm active:scale-[0.98]">
                        Simpan Transaksi
                    </button>
                </form>
            </div>

            <!-- Riwayat Transaksi -->
            <div class="lg:col-span-2 ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm overflow-hidden space-y-0">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Riwayat Transaksi Kas &amp; Bank</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar mutasi transaksi kas yang tercatat dalam sistem.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th scope="col" class="py-3.5 px-4">No. Trx</th>
                                <th scope="col" class="py-3.5 px-4">Tanggal</th>
                                <th scope="col" class="py-3.5 px-4">Tipe</th>
                                <th scope="col" class="py-3.5 px-4">Akun Kas</th>
                                <th scope="col" class="py-3.5 px-4">Akun Lawan</th>
                                <th scope="col" class="py-3.5 px-4 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($transactions as $trx)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4 font-mono font-bold text-slate-900 whitespace-nowrap">
                                        {{ $trx->transaction_number }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 whitespace-nowrap">
                                        {{ $trx->transaction_date }}
                                    </td>
                                    <td class="py-3.5 px-4 whitespace-nowrap">
                                        <span @class([
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border',
                                            'bg-emerald-50 text-emerald-700 border-emerald-200/60' => $trx->type === 'in',
                                            'bg-rose-50 text-rose-700 border-rose-200/60' => $trx->type !== 'in',
                                        ])>
                                            {{ $trx->type === 'in' ? 'MASUK' : 'KELUAR' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-800 font-medium">
                                        {{ $trx->account->name }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600">
                                        {{ $trx->oppositeAccount->name }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono font-bold tabular-nums whitespace-nowrap">
                                        @if($trx->type === 'in')
                                            <span class="text-emerald-600">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-rose-600">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400">
                                        Belum ada transaksi kas yang dicatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>

        </div>
    </section>

    @include('admin.partials.layout-end')
</body>
</html>