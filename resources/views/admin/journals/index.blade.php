<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Jurnal Umum &amp; Reversal - CTC Finance</title>
    @vite('resources/css/app.css')
</head>
<body class="ctc-admin-layout bg-slate-50/50">
    @include('admin.partials.layout-start', ['pageTitle' => 'Jurnal umum'])

    <section class="ctc-workspace space-y-6">
        <!-- Alert Notifications -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200/80 text-emerald-800 rounded-xl text-sm shadow-sm" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200/80 text-rose-800 rounded-xl text-sm shadow-sm space-y-2" role="alert">
                <p class="font-semibold text-rose-900">Periksa kembali informasi berikut:</p>
                <ul class="list-disc list-inside space-y-1 text-xs text-rose-700">
                    @if(session('error')) <li>{{ session('error') }}</li> @endif
                    @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                </ul>
            </div>
        @endif

        <!-- Header Action -->
        <div class="ctc-section-heading flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="ctc-section-eyebrow text-xs font-semibold uppercase tracking-wider text-emerald-600">Akuntansi &amp; Pembukuan</p>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Jurnal Umum &amp; Reversal</h2>
                <p class="text-sm text-slate-500 mt-1">Pencatatan pembukuan berpasangan (double entry ledger system).</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/80 font-medium text-sm rounded-lg transition-all shadow-sm active:scale-[0.98]">
                Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
            <!-- Form Input Jurnal Manual -->
            <section class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm p-6 space-y-5 lg:col-span-1" aria-labelledby="manual-journal-heading">
                <div class="pb-3 border-b border-slate-100">
                    <h3 id="manual-journal-heading" class="text-base font-bold text-slate-900">Buat Jurnal Manual</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Isi entri akun debit dan kredit berpasangan.</p>
                </div>

                <form action="{{ route('admin.journals.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-3.5">
                        <div>
                            <label for="journal-date" class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Jurnal</label>
                            <input id="journal-date" type="date" name="journal_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        </div>

                        <div>
                            <label for="reference-number" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                No. Referensi <span class="font-normal text-slate-400">(opsional)</span>
                            </label>
                            <input id="reference-number" type="text" name="reference_number" placeholder="Misal: INV-001" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        </div>

                        <div>
                            <label for="journal-description" class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan Jurnal</label>
                            <textarea id="journal-description" name="description" rows="3" placeholder="Deskripsi ringkas transaksi..." required class="w-full px-3.5 py-2 rounded-lg border border-slate-300 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none resize-y"></textarea>
                        </div>
                    </div>

                    <fieldset class="space-y-3 border-t border-slate-100 pt-4">
                        <legend class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Baris Entri Jurnal</legend>

                        <!-- Baris 1: Debit -->
                        <div class="space-y-3 rounded-xl border border-slate-200/80 bg-slate-50/70 p-3.5">
                            <div class="flex items-center gap-2">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md bg-emerald-100 text-[11px] font-bold text-emerald-700">1</span>
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Sisi Debit</span>
                            </div>
                            <select name="items[0][account_id]" aria-label="Pilih akun debit" required class="min-h-11 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                <option value="">-- Pilih Akun Debit --</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                                @endforeach
                            </select>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="debit-amount" class="mb-1 block text-xs font-medium text-slate-500">Jumlah debit (Rp)</label>
                                    <input id="debit-amount" type="number" name="items[0][debit]" placeholder="0" class="min-h-10 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-800 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                </div>
                                <div>
                                    <label for="debit-credit" class="mb-1 block text-xs font-medium text-slate-500">Kredit</label>
                                    <input id="debit-credit" type="number" name="items[0][credit]" value="0" readonly aria-label="Kredit baris debit" class="min-h-10 w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2 text-sm text-slate-500">
                                </div>
                            </div>
                        </div>

                        <!-- Baris 2: Kredit -->
                        <div class="space-y-3 rounded-xl border border-slate-200/80 bg-slate-50/70 p-3.5">
                            <div class="flex items-center gap-2">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md bg-blue-100 text-[11px] font-bold text-blue-700">2</span>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-800">Sisi Kredit</span>
                            </div>
                            <select name="items[1][account_id]" aria-label="Pilih akun kredit" required class="min-h-11 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                <option value="">-- Pilih Akun Kredit --</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                                @endforeach
                            </select>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="credit-debit" class="mb-1 block text-xs font-medium text-slate-500">Debit</label>
                                    <input id="credit-debit" type="number" name="items[1][debit]" value="0" readonly aria-label="Debit baris kredit" class="min-h-10 w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2 text-sm text-slate-500">
                                </div>
                                <div>
                                    <label for="credit-amount" class="mb-1 block text-xs font-medium text-slate-500">Jumlah kredit (Rp)</label>
                                    <input id="credit-amount" type="number" name="items[1][credit]" placeholder="0" class="min-h-10 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-800 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 rounded-lg transition-all shadow-sm active:scale-[0.98]">
                        Posting Jurnal
                    </button>
                </form>
            </section>

            <!-- Tabel & Riwayat Transaksi Jurnal -->
            <section class="lg:col-span-2 space-y-4" aria-labelledby="journal-list-heading">
                <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <h3 id="journal-list-heading" class="text-base font-bold text-slate-900">Daftar Jurnal Umum</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola dan tinjau jurnal yang telah tercatat dalam sistem.</p>
                    </div>
                    <span class="text-xs font-medium text-slate-400 bg-slate-100 px-3 py-1 rounded-full w-fit">Double Entry Verified</span>
                </div>

                <div class="space-y-4">
                    @forelse($journals as $j)
                        <article class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm p-5 space-y-4 hover:border-slate-300 transition-colors">
                            <!-- Card Header -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-slate-100">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2.5">
                                        <span class="font-mono text-sm font-bold text-slate-900">{{ $j->journal_number }}</span>
                                        <span @class([
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border',
                                            'bg-emerald-50 text-emerald-700 border-emerald-200/60' => $j->status === 'posted',
                                            'bg-rose-50 text-rose-700 border-rose-200/60' => $j->status !== 'posted',
                                        ])>
                                            {{ strtoupper($j->status) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <span class="font-medium text-slate-600">{{ $j->journal_date }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span>Ref: <strong class="font-mono text-slate-700">{{ $j->reference_number ?? '-' }}</strong></span>
                                    </div>
                                </div>

                                @if($j->status === 'posted')
                                    <form action="{{ route('admin.journals.reverse', $j->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melakukan Reversal / Pembatalan pada jurnal ini?');">
                                        @csrf
                                        <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-rose-200 bg-white px-3 py-2 text-xs font-semibold text-rose-700 transition-colors hover:bg-rose-50 focus:outline-none focus:ring-4 focus:ring-rose-100">
                                            Reverse / Batal
                                        </button>
                                    </form>
                                @elseif($j->status === 'reversed')
                                    <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded font-bold uppercase">REVERSED</span>
                                @endif
                            </div>

                            <!-- Deskripsi -->
                            <p class="text-xs font-medium text-slate-700 leading-relaxed bg-slate-50/60 p-3 rounded-lg border border-slate-100">
                                {{ $j->description }}
                            </p>

                            <div class="overflow-x-auto rounded-lg border border-slate-200">
                                <table class="w-full min-w-[32rem] text-left text-xs">
                                    <thead class="bg-slate-50 text-[11px] uppercase tracking-wide text-slate-500">
                                        <tr>
                                            <th scope="col" class="px-3 py-3 font-semibold">Kode &amp; Akun</th>
                                            <th scope="col" class="px-3 py-3 text-right font-semibold">Debit</th>
                                            <th scope="col" class="px-3 py-3 text-right font-semibold">Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 bg-white">
                                        @foreach($j->details as $d)
                                            <tr class="text-slate-600">
                                                <td class="max-w-[18rem] break-words px-3 py-3 font-medium {{ $d->credit > 0 ? 'pl-7' : '' }}">
                                                    {{ $d->account->code }} - {{ $d->account->name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-3 text-right tabular-nums">{{ $d->debit > 0 ? 'Rp ' . number_format($d->debit, 0, ',', '.') : '-' }}</td>
                                                <td class="whitespace-nowrap px-3 py-3 text-right tabular-nums">{{ $d->credit > 0 ? 'Rp ' . number_format($d->credit, 0, ',', '.') : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </article>
                    @empty
                        <div class="ctc-panel rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-400">
                            Belum Ada Jurnal Tercatat.
                        </div>
                    @endforelse
                </div>

                @if($journals->hasPages())
                    <div class="pt-2">
                        {{ $journals->links() }}
                    </div>
                @endif
            </section>
        </div>
    </section>

    @include('admin.partials.layout-end')
</body>
</html>