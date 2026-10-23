<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Rekonsiliasi Bank - CTC Finance</title>
    @vite('resources/css/app.css')
</head>
<body class="ctc-admin-layout bg-slate-50/50">
    @include('admin.partials.layout-start', ['pageTitle' => 'Rekonsiliasi bank'])

    <section class="ctc-workspace space-y-6">
        <!-- Alert Notification -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200/80 text-emerald-800 rounded-xl text-sm shadow-sm" role="status">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header Action -->
        <div class="ctc-section-heading flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="ctc-section-eyebrow text-xs font-semibold uppercase tracking-wider text-emerald-600">Kas & Perbankan</p>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Rekonsiliasi Rekening Bank</h2>
                <p class="text-sm text-slate-500 mt-1">Pencocokan saldo rekening koran bank dengan catatan saldo buku sistem.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/80 font-medium text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- Form Input Rekonsiliasi Baru -->
            <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm p-6 space-y-5 lg:col-span-1">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Proses Rekonsiliasi Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Input saldo rekening koran untuk diverifikasi.</p>
                </div>

                <form action="{{ route('admin.bank-reconciliations.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Akun Rekening Bank</label>
                        <select name="account_id" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="">-- Pilih Akun Bank --</option>
                            @foreach($bankAccounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Rekening Koran</label>
                        <input type="date" name="statement_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Saldo Rekening Koran Bank (Rp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-medium text-slate-400 pointer-events-none">Rp</span>
                            <input type="number" name="statement_balance" step="0.01" placeholder="0" required class="w-full pl-9 pr-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Catatan / Keterangan</label>
                        <textarea name="notes" rows="3" placeholder="Catatan penyesuaian, biaya admin, atau selisih..." class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none resize-y"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 rounded-lg transition-all shadow-sm active:scale-[0.98]">
                        Jalankan Rekonsiliasi
                    </button>
                </form>
            </div>

            <!-- Tabel Riwayat Rekonsiliasi -->
            <div class="lg:col-span-2 ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Riwayat Rekonsiliasi Bank</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar pencocokan saldo buku vs saldo rekening koran.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th scope="col" class="py-3.5 px-4">Tgl Koran</th>
                                <th scope="col" class="py-3.5 px-4">Akun Bank</th>
                                <th scope="col" class="py-3.5 px-4 text-right">Saldo Koran</th>
                                <th scope="col" class="py-3.5 px-4 text-right">Saldo Buku</th>
                                <th scope="col" class="py-3.5 px-4 text-right">Selisih</th>
                                <th scope="col" class="py-3.5 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($reconciliations as $rec)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4 font-semibold text-slate-900 whitespace-nowrap">
                                        {{ $rec->statement_date }}
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-700 font-medium">
                                        {{ $rec->account->name }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono font-semibold text-slate-900 tabular-nums whitespace-nowrap">
                                        Rp {{ number_format($rec->statement_balance, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono text-slate-600 tabular-nums whitespace-nowrap">
                                        Rp {{ number_format($rec->book_balance, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-mono font-bold tabular-nums whitespace-nowrap">
                                        @if($rec->difference == 0)
                                            <span class="text-emerald-600">Rp 0</span>
                                        @else
                                            <span class="text-rose-600">Rp {{ number_format($rec->difference, 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                        <span @class([
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border',
                                            'bg-emerald-50 text-emerald-700 border-emerald-200/60' => $rec->status === 'reconciled',
                                            'bg-amber-50 text-amber-700 border-amber-200/60' => $rec->status !== 'reconciled',
                                        ])>
                                            {{ strtoupper($rec->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400">
                                        Belum ada riwayat rekonsiliasi bank tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($reconciliations->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $reconciliations->links() }}
                    </div>
                @endif
            </div>

        </div>
    </section>

    @include('admin.partials.layout-end')
</body>
</html>