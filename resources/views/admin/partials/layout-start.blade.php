<aside class="ctc-sidebar">
    <a href="{{ route('dashboard') }}" class="ctc-brand">
        <span class="ctc-brand-mark">C</span>
        <span>
            <strong>CTC Finance</strong>
            <small>General Ledger</small>
        </span>
    </a>

    <nav class="ctc-navigation" aria-label="Navigasi utama">
        <a href="{{ route('dashboard') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('dashboard')])>
            <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span> Ringkasan
        </a>

        @role('admin')
            <p class="ctc-nav-group">Master data</p>
            <a href="{{ route('admin.users.index') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.users.*')])>
                <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m8-14a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm4 1h4m-2-2v4"/></svg></span> Pengguna
            </a>
            <a href="{{ route('admin.chart-of-accounts.index') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.chart-of-accounts.*')])>
                <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A1.5 1.5 0 0 1 5.5 4H20v14H5.5A1.5 1.5 0 0 0 4 19.5v-14ZM4 19.5A1.5 1.5 0 0 1 5.5 18H20M8 8h8M8 11h8"/></svg></span> Bagan akun
            </a>
        @endrole

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
            @can('view-reports-tax')
                <a href="{{ route('admin.reports.tax') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.reports.tax*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h10l3 3v15H4V6l3-3Zm3 6h4m-5 4h6m-6 4h4"/></svg></span> Pajak
                </a>
            @endcan
            @can('view-reports-payroll')
                <a href="{{ route('admin.reports.payroll') }}" @class(['ctc-nav-link', 'is-active' => request()->routeIs('admin.reports.payroll*')])>
                    <span class="ctc-nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19V5m0 14h16m-12-3v-4m5 4V8m5 8v-6"/></svg></span> Laporan penggajian
                </a>
            @endcan
        @endhasanyrole
    </nav>

    <div class="ctc-sidebar-footer">
        <span class="ctc-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        <span class="ctc-user-details">
            <strong>{{ auth()->user()->name }}</strong>
            <small>{{ auth()->user()->getRoleNames()->first() ?? session('active_role', 'GUEST') }}</small>
        </span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="ctc-logout" aria-label="Keluar sesi" title="Keluar sesi">↗</button>
        </form>
    </div>
</aside>

<div class="ctc-admin-main">
    <header class="ctc-topbar">
        <div>
            <p class="ctc-topbar-eyebrow">CTC Finance</p>
            <h1>{{ $pageTitle }}</h1>
        </div>
        <span class="ctc-topbar-role">{{ auth()->user()->getRoleNames()->first() ?? session('active_role', 'GUEST') }}</span>
    </header>
    <main class="ctc-page-content">
