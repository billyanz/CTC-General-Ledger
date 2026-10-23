<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Jurnal Penyesuaian &amp; Penyusutan - CTC Finance</title>
    @vite('resources/css/app.css')
</head>
<body class="ctc-admin-layout bg-slate-50/50">
    @include('admin.partials.layout-start', ['pageTitle' => 'Jurnal penyesuaian'])

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
                <p class="ctc-section-eyebrow text-xs font-semibold uppercase tracking-wider text-emerald-600">Akuntansi &amp; Aset</p>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Jurnal Penyesuaian &amp; Penyusutan</h2>
                <p class="text-sm text-slate-500 mt-1">Pencatatan penyusutan aset tetap &amp; penyesuaian beban akhir periode.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/80 font-medium text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- Form Input Penyesuaian Baru -->
            <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm p-6 space-y-5 lg:col-span-1">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Input Penyesuaian Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Entri jurnal penyesuaian/penyusutan periode ini.</p>
                </div>

                <form action="{{ route('admin.adjustments.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Penyesuaian</label>
                        <input type="date" name="adjustment_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Akun Beban / Debit</label>
                        <select name="expense_account_id" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="">-- Pilih Akun Beban --</option>
                            @foreach($expenseAccounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Akun Akumulasi / Kredit</label>
                        <select name="accumulated_account_id" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-xs text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="">-- Pilih Akun Akumulasi/Kredit --</option>
                            @foreach($accumulatedAccounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }} ({{ strtoupper($acc->type) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nilai Penyesuaian (Rp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-medium text-slate-400 pointer-events-none">Rp</span>
                            <input type="number" name="amount" min="1" step="0.01" placeholder="0" required class="w-full pl-9 pr-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan / Deskripsi</label>
                        <textarea name="description" rows="3" placeholder="Contoh: Penyusutan inventaris bulan ini..." required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none resize-y"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 rounded-lg transition-all shadow-sm active:scale-[0.98]">
                        Posting Jurnal Penyesuaian
                    </button>
                </form>
            </div>

            <!-- Tabel Riwayat Penyesuaian -->
            <div class="lg:col-span-2 space-y-4">
                <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm p-5 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Riwayat Jurnal Penyesuaian</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar ayat jurnal penyesuaian akhir periode yang telah diposting.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($adjustments as $adj)
                        <div class="border rounded-xl p-4 bg-gray-50/50 space-y-2">
                            <div class="flex justify-between items-center border-b pb-2">
                                <span class="font-mono font-bold text-xs text-blue-600">{{ $adj->journal_number }}</span>
                                <span class="text-xs text-gray-500">{{ $adj->journal_date }}</span>
                            </div>
                            <p class="text-xs text-gray-700 font-medium">{{ $adj->description }}</p>

                            <table class="w-full text-xs text-left bg-white rounded border">
                                <thead>
                                    <tr class="border-b bg-gray-100 text-gray-500 uppercase">
                                        <th class="py-1 px-2">Akun</th>
                                        <th class="py-1 px-2 text-right">Debit</th>
                                        <th class="py-1 px-2 text-right">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach($adj->details as $d)
                                        <tr>
                                            <td class="py-1 px-2 {{ $d->credit > 0 ? 'pl-6' : '' }}">
                                                {{ $d->account->code }} - {{ $d->account->name }}
                                            </td>
                                            <td class="py-1 px-2 text-right">{{ $d->debit > 0 ? 'Rp ' . number_format($d->debit, 0, ',', '.') : '-' }}</td>
                                            <td class="py-1 px-2 text-right">{{ $d->credit > 0 ? 'Rp ' . number_format($d->credit, 0, ',', '.') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <div class="ctc-panel rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-400">
                            Belum Ada Jurnal Penyesuaian.
                        </div>
                    @endforelse
                </div>

                @if($adjustments->hasPages())
                    <div class="pt-2">
                        {{ $adjustments->links() }}
                    </div>
                @endif
            </div>

        </div>
    </section>

    @include('admin.partials.layout-end')
</body>
</html>