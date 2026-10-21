<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f8fafc">
    <title>Jurnal Umum &amp; Reversal</title>
    @vite('resources/css/app.css')
</head>
<body class="ctc-admin-layout">
    @include('admin.partials.layout-start', ['pageTitle' => 'Jurnal umum'])
    <section class="ctc-workspace space-y-5">
        <header class="flex flex-col gap-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:p-7">
            <div>
                <p class="mb-2 text-xs font-semibold uppercase tracking-[0.16em] text-blue-700">Akuntansi</p>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Jurnal Umum &amp; Reversal</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Pencatatan pembukuan berpasangan (double-entry ledger).</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex min-h-11 w-full items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-blue-100 sm:w-auto">
                <svg class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06l-3.22 3.22h10.69A.75.75 0 0 1 17 10Z" clip-rule="evenodd"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </header>

        @if(session('success'))
            <div role="status" class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-800">
                <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.78-9.72a.75.75 0 0 0-1.06-1.06L9 10.94 7.28 9.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.06 0l4.25-4.25Z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm text-rose-800">
                <p class="mb-1 font-semibold">Periksa kembali informasi berikut:</p>
                <ul class="list-inside list-disc space-y-1">
                    @if(session('error')) <li>{{ session('error') }}</li> @endif
                    @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-[minmax(19rem,0.85fr)_minmax(0,2fr)]">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6" aria-labelledby="manual-journal-heading">
                <div class="mb-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-700">Entri baru</p>
                    <h2 id="manual-journal-heading" class="mt-1 text-lg font-bold text-slate-900">Buat Jurnal Manual</h2>
                    <p class="mt-1 text-sm text-slate-500">Isi akun debit dan kredit untuk mencatat transaksi.</p>
                </div>

                <form action="{{ route('admin.journals.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="journal-date" class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal Jurnal</label>
                            <input id="journal-date" type="date" name="journal_date" value="{{ date('Y-m-d') }}" required class="min-h-11 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                        </div>

                        <div>
                            <label for="reference-number" class="mb-1.5 block text-sm font-medium text-slate-700">No. Referensi <span class="font-normal text-slate-400">(opsional)</span></label>
                            <input id="reference-number" type="text" name="reference_number" placeholder="Misal: INV-001" class="min-h-11 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                        </div>

                        <div>
                            <label for="journal-description" class="mb-1.5 block text-sm font-medium text-slate-700">Keterangan Jurnal</label>
                            <textarea id="journal-description" name="description" rows="3" placeholder="Deskripsi transaksi..." required class="w-full resize-y rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"></textarea>
                        </div>
                    </div>

                    <fieldset class="space-y-3 border-t border-slate-200 pt-5">
                        <legend class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Baris Entri Jurnal</legend>

                        <div class="space-y-3 rounded-xl border border-slate-200 bg-slate-50 p-3.5">
                            <div class="flex items-center gap-2">
                                <span class="flex h-6 w-6 items-center justify-center rounded-md bg-blue-100 text-xs font-bold text-blue-700">1</span>
                                <span class="text-sm font-semibold text-slate-800">Debit</span>
                            </div>
                            <select name="items[0][account_id]" aria-label="Pilih akun debit" required class="min-h-11 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                <option value="">-- Pilih Akun Debit --</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                                @endforeach
                            </select>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="items[0][debit]" placeholder="Debit Rp" class="px-2 py-1 border rounded text-xs font-semibold">
                                <input type="number" name="items[0][credit]" value="0" readonly class="px-2 py-1 border bg-gray-100 rounded text-xs">
                            </div>
                        </div>

                        <div class="space-y-3 rounded-xl border border-slate-200 bg-slate-50 p-3.5">
                            <div class="flex items-center gap-2">
                                <span class="flex h-6 w-6 items-center justify-center rounded-md bg-emerald-100 text-xs font-bold text-emerald-700">2</span>
                                <span class="text-sm font-semibold text-slate-800">Kredit</span>
                            </div>
                            <select name="items[1][account_id]" aria-label="Pilih akun kredit" required class="min-h-11 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                <option value="">-- Pilih Akun Kredit --</option>
                                @foreach($accounts as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                                @endforeach
                            </select>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="items[1][debit]" value="0" readonly class="px-2 py-1 border bg-gray-100 rounded text-xs">
                                <input type="number" name="items[1][credit]" placeholder="Kredit Rp" class="px-2 py-1 border rounded text-xs font-semibold">
                            </div>
                        </div>
                    </fieldset>

                    <button type="submit" class="inline-flex min-h-11 w-full items-center justify-center rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-200">
                        Posting Jurnal
                    </button>
                </form>
            </section>

            <section class="min-w-0 space-y-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6" aria-labelledby="journal-list-heading">
                <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-blue-700">Riwayat transaksi</p>
                        <h2 id="journal-list-heading" class="mt-1 text-lg font-bold text-slate-900">Daftar Jurnal Umum</h2>
                    </div>
                    <p class="text-sm text-slate-500">Kelola dan tinjau jurnal yang tercatat.</p>
                </div>

                <div class="space-y-4">
                    @forelse($journals as $j)
                        <article class="space-y-4 rounded-xl border border-slate-200 bg-white p-4 sm:p-5">
                            <div class="flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-start sm:justify-between">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-mono text-sm font-bold text-blue-800">{{ $j->journal_number }}</span>
                                        <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $j->status === 'posted' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200' : 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-200' }}">
                                            {{ strtoupper($j->status) }}
                                        </span>
                                    </div>
                                    <p class="mt-1.5 text-xs text-slate-500">{{ $j->journal_date }} <span class="mx-1 text-slate-300">|</span> Ref: {{ $j->reference_number ?? '-' }}</p>
                                </div>

                                @if($j->status === 'posted')
                                    <form action="{{ route('admin.journals.reverse', $j->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melakukan Reversal / Pembatalan pada jurnal ini?');">
                                        @csrf
                                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs px-2.5 py-1 rounded-lg font-medium transition">
                                            🔄 Reverse / Batal
                                        </button>
                                    </form>
                                @elseif($j->status === 'reversed')
                                    <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded font-bold uppercase">REVERSED</span>
                                @endif
                            </div>

                            <p class="break-words text-sm font-medium leading-6 text-slate-700">{{ $j->description }}</p>

                            <!-- Items Table Detail -->
                            <table class="w-full text-xs text-left bg-white rounded border">
                                <thead>
                                    <tr class="border-b bg-gray-100 text-gray-500 uppercase">
                                        <th class="py-1.5 px-2">Kode & Akun</th>
                                        <th class="py-1.5 px-2 text-right">Debit</th>
                                        <th class="py-1.5 px-2 text-right">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach($j->details as $d)
                                        <tr>
                                            <td class="py-1.5 px-2 {{ $d->credit > 0 ? 'pl-6' : '' }}">
                                                {{ $d->account->code }} - {{ $d->account->name }}
                                            </td>
                                            <td class="py-1.5 px-2 text-right">{{ $d->debit > 0 ? 'Rp ' . number_format($d->debit, 0, ',', '.') : '-' }}</td>
                                            <td class="py-1.5 px-2 text-right">{{ $d->credit > 0 ? 'Rp ' . number_format($d->credit, 0, ',', '.') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-12 text-center">
                            <p class="text-sm font-medium text-slate-600">Belum ada jurnal yang tercatat.</p>
                            <p class="mt-1 text-xs text-slate-500">Jurnal yang berhasil diposting akan tampil di sini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="overflow-x-auto border-t border-slate-100 pt-4">
                    {{ $journals->links() }}
                </div>
            </section>
        </div>
    </section>
    @include('admin.partials.layout-end')
</body>
</html>
