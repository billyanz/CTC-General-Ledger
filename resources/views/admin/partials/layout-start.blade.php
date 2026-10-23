<aside class="ctc-sidebar" x-data="{ sidebarOpen: false }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen" :class="sidebarOpen ? 'is-mobile-open' : ''">
    <a href="{{ route('dashboard') }}" class="ctc-brand">
        <span class="ctc-brand-mark flex items-center justify-center overflow-hidden !bg-transparent !border-0 !shadow-none p-0">
            <img src="{{ asset('images/logo_CTC.png') }}" alt="CTC Logo" class="w-full h-full object-contain">
        </span>
        <span>
            <strong>CTC Finance</strong>
            <small>General Ledger</small>
        </span>
    </a>

    <nav class="ctc-navigation" aria-label="Navigasi utama">
        {{-- Ringkasan (Semua Role) --}}
        <a href="{{ route('dashboard') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('dashboard')])>
            <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span> Ringkasan
        </a>

        {{-- MASTER DATA (HANYA ADMIN) --}}
        @role('admin')
            <p class="ctc-nav-group">Master data</p>
            <a href="{{ route('admin.users.index') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.users.*')])>
                <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m8-14a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm4 1h4m-2-2v4"/></svg></span> Pengguna
            </a>
            <a href="{{ route('admin.chart-of-accounts.index') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.chart-of-accounts.*')])>
                <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A1.5 1.5 0 0 1 5.5 4H20v14H5.5A1.5 1.5 0 0 0 4 19.5v-14ZM4 19.5A1.5 1.5 0 0 1 5.5 18H20M8 8h8M8 11h8"/></svg></span> Bagan akun
            </a>
        @endrole

        {{-- AKUNTANSI (ADMIN & AKUNTAN SAJA) --}}
        @hasanyrole('admin|akuntan')
            <p class="ctc-nav-group">Akuntansi</p>
            @can('manage-journals')
                <a href="{{ route('admin.journals.index') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.journals.*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3.75h7l4 4V20a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4.75a1 1 0 0 1 1-1ZM14 4v4h4m-8 4h6m-6 4h6"/></svg></span> Jurnal umum
                </a>
            @endcan
            @can('manage-bank-reconciliations')
                <a href="{{ route('admin.bank-reconciliations.index') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.bank-reconciliations.*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 9h18L12 4 3 9Zm2 2v7m5-7v7m4-7v7m5-7v7M3 21h18M2 18h20"/></svg></span> Rekonsiliasi bank
                </a>
            @endcan
            @can('manage-adjustments')
                <a href="{{ route('admin.adjustments.index') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.adjustments.*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h9m4 0h3M4 17h3m4 0h9M13 4v6M7 14v6"/></svg></span> Jurnal penyesuaian
                </a>
            @endcan
            @can('process-taxes')
                <a href="{{ route('admin.taxes.index') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.taxes.*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m9 15 6-6m-5.5 0h.01M14.5 15h.01"/></svg></span> Pemrosesan pajak
                </a>
            @endcan
        @endhasanyrole

        {{-- OPERASIONAL (ADMIN, AKUNTAN, DAN STAFF) --}}
        @hasanyrole('admin|akuntan|staff')
            <p class="ctc-nav-group">Operasional</p>
            @can('manage-cash-transactions')
                <a href="{{ route('admin.cash-transactions.index') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.cash-transactions.*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="6" width="18" height="14" rx="2"/><path d="M3 10h18m-5 5h2M7 6V4h12"/></svg></span> Transaksi kas
                </a>
            @endcan
            @can('manage-payrolls')
                <a href="{{ route('admin.payrolls.index') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.payrolls.*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M7 9h4m-4 4h2m5-2h3m-3 3h3"/></svg></span> Penggajian
                </a>
            @endcan
        @endhasanyrole

        {{-- LAPORAN (ADMIN & AKUNTAN SAJA - PAJAK & PENGGAJIAN DIHAPUS) --}}
        @hasanyrole('admin|akuntan')
            <p class="ctc-nav-group">Laporan</p>
            @can('view-reports-general-ledger')
                <a href="{{ route('admin.reports.general-ledger') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.reports.general-ledger*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4h14v16H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm3 4h8m-8 4h8m-8 4h5"/></svg></span> Buku besar
                </a>
            @endcan
            @can('view-reports-profit-loss')
                <a href="{{ route('admin.reports.profit-loss') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.reports.profit-loss*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19V5m0 14h16M7 15l4-4 3 2 6-7m-5 0h5v5"/></svg></span> Laba rugi
                </a>
            @endcan
            @can('view-reports-balance-sheet')
                <a href="{{ route('admin.reports.balance-sheet') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.reports.balance-sheet*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v18M5 6h14M7 6l-4 8h8L7 6Zm10 0-4 8h8l-4-8ZM5 21h14"/></svg></span> Neraca
                </a>
            @endcan
        @endhasanyrole
    </nav>

    <div class="ctc-sidebar-footer">
        <details class="ctc-user-menu">
            <summary class="ctc-user-menu-trigger" aria-label="Menu pengguna">
                <span class="ctc-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span class="ctc-user-details">
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>{{ auth()->user()->getRoleNames()->first() ?? session('active_role', 'GUEST') }}</small>
                </span>
                <svg class="ctc-user-menu-chevron" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="m5 7.5 5 5 5-5" />
                </svg>
            </summary>
            <div class="ctc-user-menu-panel">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="ctc-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </details>
    </div>
</aside>

<div class="ctc-admin-main">
    <header class="ctc-topbar">
        <div class="flex items-center gap-3">
            {{-- Tombol Hamburger Mobile di Pojok Kiri Topbar --}}
            <button @click="$dispatch('toggle-sidebar')" class="ctc-mobile-toggle md:hidden p-1 text-slate-600 focus:outline-none" aria-label="Toggle menu">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div>
                <p class="ctc-topbar-eyebrow">CTC Finance</p>
                <!--<h1>{{ $pageTitle }}</h1>-->
            </div>
        </div>
        <span class="ctc-topbar-role">{{ auth()->user()->getRoleNames()->first() ?? session('active_role', 'GUEST') }}</span>
    </header>
    <main class="ctc-page-content">