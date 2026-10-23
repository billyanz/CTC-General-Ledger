<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Bagan Akun (COA) - CTC Finance</title>
    @vite('resources/css/app.css')
</head>
<body class="ctc-admin-layout bg-slate-50/50">
    @include('admin.partials.layout-start', ['pageTitle' => 'Bagan akun'])

    <section class="ctc-workspace space-y-6">
        <!-- Alert Notification -->
        @if(session('success'))
            <div class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200/80 text-emerald-800 rounded-xl text-sm shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Header Action -->
        <div class="ctc-section-heading flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="ctc-section-eyebrow text-xs font-semibold uppercase tracking-wider text-emerald-600">Akuntansi & Struktur</p>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Master Data Bagan Akun (COA)</h2>
                <p class="text-sm text-slate-500 mt-1">Daftar hirarki dan struktur akun keuangan resmi perusahaan.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200/80 font-medium text-sm rounded-lg transition-all shadow-sm">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- Form Tambah Akun -->
            <div class="ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm p-6 space-y-5">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Tambah Akun Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Buat entri akun baru dalam buku besar.</p>
                </div>

                <form action="{{ route('admin.chart-of-accounts.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kode Akun</label>
                        <input type="text" name="code" placeholder="Misal: 10101" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 font-mono focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Akun</label>
                        <input type="text" name="name" placeholder="Misal: Kas Kecil Operational" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tipe Akun</label>
                        <select name="type" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="asset">Aset (Asset)</option>
                            <option value="liability">Kewajiban (Liability)</option>
                            <option value="equity">Ekuitas (Equity)</option>
                            <option value="revenue">Pendapatan (Revenue)</option>
                            <option value="expense">Beban (Expense)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Saldo Normal</label>
                        <select name="normal_balance" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="debit">Debit</option>
                            <option value="credit">Kredit</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Induk Akun (Opsional)</label>
                        <select name="parent_id" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg text-sm text-slate-800 bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="">-- Tanpa Induk (Level Atas) --</option>
                            @foreach($parentAccounts as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->code }} - {{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 rounded-lg transition-all shadow-sm hover:shadow active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Akun
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Akun -->
            <div class="lg:col-span-2 ctc-panel rounded-xl border border-slate-200/80 bg-white shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Daftar Bagan Akun</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Struktur hirarki seluruh akun tercatat.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead class="bg-slate-50/80 border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th scope="col" class="py-3.5 px-5">Kode</th>
                                <th scope="col" class="py-3.5 px-5">Nama Akun</th>
                                <th scope="col" class="py-3.5 px-5">Tipe</th>
                                <th scope="col" class="py-3.5 px-5">Saldo Normal</th>
                                <th scope="col" class="py-3.5 px-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($accounts as $acc)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-5 font-mono text-xs font-bold text-slate-900 whitespace-nowrap">
                                        {{ $acc->code }}
                                    </td>
                                    <td class="py-3.5 px-5">
                                        @if($acc->parent_id)
                                            <div class="flex items-center gap-2 pl-4 text-slate-600">
                                                <span class="text-slate-300 font-mono text-xs">└─</span>
                                                <span class="font-medium text-slate-800">{{ $acc->name }}</span>
                                            </div>
                                        @else
                                            <span class="font-semibold text-slate-900">{{ $acc->name }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-5">
                                        @php
                                            $type = strtolower($acc->type);
                                        @endphp
                                        <span @class([
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border',
                                            'bg-blue-50 text-blue-700 border-blue-200/60' => $type === 'asset',
                                            'bg-amber-50 text-amber-700 border-amber-200/60' => $type === 'liability',
                                            'bg-purple-50 text-purple-700 border-purple-200/60' => $type === 'equity',
                                            'bg-emerald-50 text-emerald-700 border-emerald-200/60' => $type === 'revenue',
                                            'bg-rose-50 text-rose-700 border-rose-200/60' => $type === 'expense',
                                            'bg-slate-100 text-slate-700 border-slate-200/60' => !in_array($type, ['asset','liability','equity','revenue','expense']),
                                        ])>
                                            {{ strtoupper($acc->type) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-medium text-xs uppercase">{{ $acc->normal_balance }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <form action="{{ route('admin.chart-of-accounts.destroy', $acc->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center space-y-1">
                                            <svg class="w-8 h-8 text-slate-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <span>Belum ada akun terdaftar dalam sistem.</span>
                                        </div>
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