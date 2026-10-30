<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard - Sistem Keuangan & Payroll CTC')</title>

    {{-- Script Eksekusi Tercepat (Zero-Flicker Theme Engine) --}}
    <script>
        (function() {
            if (localStorage.getItem('sidebar_collapsed') === 'true') {
                document.documentElement.classList.add('sidebar-collapsed');
            }
            const savedTheme = localStorage.getItem('theme');
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    
    <!-- Font Awesome Icons -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Laravel Vite: Tailwind CSS & Application JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }

        /* ========================================================= */
        /* 1. LIGHT MODE DEFAULT                                     */
        /* ========================================================= */
        :root {
            --bg-main: #F6F8F6;
            --surface: #FFFFFF;
            --text-primary: #202B25;
            --text-secondary: #68756D;
            --border-color: #E1E8E2;
            --input-bg: #FFFFFF;

            /* Sidebar Light Mode */
            --sidebar-bg: #FFFFFF;
            --sidebar-border: #E1E8E2;
            --sidebar-brand-text: #202B25;
            --sidebar-section-text: #89958D;
            --sidebar-link-text: #526057;
            --sidebar-link-hover-bg: #F3F7F4;
            --sidebar-link-hover-text: #104B35;
            
            --sidebar-active-bg: #E8F4EC;
            --sidebar-active-text: #176B45;
            --sidebar-active-border: #176B45;

            --user-card-bg: #F9FAFB;
            --user-card-border: #E5E7EB;
            --user-card-avatar-bg: #176B45;
            --user-card-name-text: #202B25;

            --logout-btn-bg: #FEF2F2;
            --logout-btn-border: #FECACA;
            --logout-btn-text: #DC2626;

            --color-success: #16A34A;
            --color-success-bg: #F0FDF4;
            --color-success-border: #BBF7D0;

            --color-danger: #DC2626;
            --color-danger-bg: #FEF2F2;
            --color-danger-border: #FECACA;

            --color-warning: #D97706;
            --color-warning-bg: #FFFBEB;
            --color-warning-border: #FDE68A;

            --color-info: #2563EB;
            --color-info-bg: #EFF6FF;
            --color-info-border: #BFDBFE;
        }

        /* Preservasi Warna RGB Aksesibel (Kas Keluar & Stat Cards) */
        .text-red-500, .text-red-600, .text-red-700,
        .text-rose-500, .text-rose-600, .text-rose-700,
        .text-amber-500, .text-amber-600 {
            color: #E11D48 !important;
        }
        .text-emerald-500, .text-emerald-600, .text-green-500, .text-green-600 {
            color: #10B981 !important;
        }

        /* ========================================================= */
        /* 2. DARK MODE / BLACK THEME                                */
        /* ========================================================= */
        html.dark {
            --bg-main: #09090B;
            --surface: #121215;
            --text-primary: #FAFAFA;
            --text-secondary: #A1A1AA;
            --border-color: #27272A;
            --input-bg: #18181B;

            --sidebar-bg: #0C0C0E;
            --sidebar-border: #1F1F23;
            --sidebar-brand-text: #FAFAFA;
            --sidebar-section-text: #71717A;
            --sidebar-link-text: #FAFAFA;
            --sidebar-link-hover-bg: #18181B;
            --sidebar-link-hover-text: #FFFFFF;

            --sidebar-active-bg: #27272A;
            --sidebar-active-text: #FFFFFF;
            --sidebar-active-border: #FAFAFA;

            --user-card-bg: #18181B;
            --user-card-border: #27272A;
            --user-card-avatar-bg: #27272A;
            --user-card-name-text: #FAFAFA;

            --logout-btn-bg: rgba(220, 38, 38, 0.15);
            --logout-btn-border: rgba(220, 38, 38, 0.3);
            --logout-btn-text: #EF4444;

            --color-success: #22C55E;
            --color-success-bg: rgba(34, 197, 94, 0.12);
            --color-success-border: rgba(34, 197, 94, 0.3);

            --color-danger: #EF4444;
            --color-danger-bg: rgba(239, 68, 68, 0.12);
            --color-danger-border: rgba(239, 68, 68, 0.3);

            --color-warning: #F59E0B;
            --color-warning-bg: rgba(245, 158, 11, 0.12);
            --color-warning-border: rgba(245, 158, 11, 0.3);

            --color-info: #3B82F6;
            --color-info-bg: rgba(59, 130, 246, 0.12);
            --color-info-border: rgba(59, 130, 246, 0.3);
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: var(--bg-main);
            color: var(--text-primary);
            overflow-x: clip;
            transition: background-color 200ms ease, color 200ms ease;
        }

        .sidebar-scroll {
            min-width: 0;
            overflow-x: hidden;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(120, 120, 120, 0.2) transparent;
        }

        .app-sidebar {
            background-color: var(--sidebar-bg);
            border-color: var(--sidebar-border);
            color: var(--sidebar-link-text);
            box-sizing: border-box;
            flex: 0 0 auto;
            min-width: 0;
            overflow-x: hidden;
            transition: width 220ms cubic-bezier(0.4, 0, 0.2, 1), transform 250ms ease, background-color 200ms ease, border-color 200ms ease;
        }

        .sidebar-section-label {
            display: block;
            color: var(--sidebar-section-text) !important;
            font-size: 0.625rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .sidebar-link {
            box-sizing: border-box;
            display: flex;
            align-items: center;
            min-width: 0;
            max-width: 100%;
            overflow: hidden;
            white-space: nowrap;
            gap: 0.75rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            color: var(--sidebar-link-text) !important;
            border-radius: 0.75rem;
            transition: all 150ms ease;
        }
        .sidebar-link:hover {
            background-color: var(--sidebar-link-hover-bg);
            color: var(--sidebar-link-hover-text) !important;
            transform: translateX(3px);
        }

        .sidebar-link[aria-current="page"] {
            color: var(--sidebar-active-text) !important;
            background-color: var(--sidebar-active-bg) !important;
            box-shadow: inset 3px 0 0 var(--sidebar-active-border);
            font-weight: 700;
        }
        .sidebar-link[aria-current="page"] .sidebar-icon {
            color: var(--sidebar-active-text) !important;
        }

        .sidebar-icon {
            flex: 0 0 1.25rem;
            width: 1.25rem;
            text-align: center;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .sidebar-label, .sidebar-brand-copy, .sidebar-user-text {
            display: inline-block;
            min-width: 0;
            max-width: 180px;
            opacity: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: max-width 220ms cubic-bezier(0.4, 0, 0.2, 1), opacity 160ms ease;
        }

        .sidebar-brand-logo {
            display: block;
            flex: 0 0 auto;
            width: 2.375rem;
            height: 2.375rem;
            object-fit: contain;
        }

        @media (min-width: 1024px) {
            .sidebar-collapsed .app-sidebar { width: 5.25rem !important; }
        }

        .sidebar-collapsed .fa-bars-staggered { transform: rotate(180deg); }
        .sidebar-collapsed .sidebar-section-label,
        .sidebar-collapsed .sidebar-label,
        .sidebar-collapsed .sidebar-brand-copy,
        .sidebar-collapsed .sidebar-user-text {
            max-width: 0 !important;
            max-height: 0 !important;
            opacity: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            pointer-events: none;
        }

        .sidebar-collapsed .sidebar-link {
            justify-content: flex-start;
            gap: 0;
            width: 100%;
            padding-left: 1.125rem;
            padding-right: 0;
            overflow: visible;
            transform: none;
        }
        .sidebar-collapsed .sidebar-link:hover { transform: scale(1.04); }
        .sidebar-collapsed .sidebar-icon { flex: 0 0 1.25rem; }
        .sidebar-collapsed .sidebar-tooltip { display: block; z-index: 100; }

        .app-topbar {
            background-color: var(--surface);
            border-color: var(--border-color);
            transition: background-color 200ms ease, border-color 200ms ease;
        }

        .mono-card {
            background-color: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            transition: background-color 200ms ease, border-color 200ms ease;
        }

        .mono-table thead {
            background-color: var(--bg-main);
            border-bottom: 1px solid var(--border-color);
        }
        .mono-table th {
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .mono-table td {
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        /* SEMANTIC BADGES */
        .badge-success {
            background-color: var(--color-success-bg);
            border: 1px solid var(--color-success-border);
            color: var(--color-success);
        }
        .badge-danger {
            background-color: var(--color-danger-bg);
            border: 1px solid var(--color-danger-border);
            color: var(--color-danger);
        }
        .badge-warning {
            background-color: var(--color-warning-bg);
            border: 1px solid var(--color-warning-border);
            color: var(--color-warning);
        }
        .badge-info {
            background-color: var(--color-info-bg);
            border: 1px solid var(--color-info-border);
            color: var(--color-info);
        }

        .btn-press { transition: transform 0.15s ease, background-color 0.15s ease; }
        .btn-press:active { transform: scale(0.96); }

        /* ========================================================= */
        /* GLOBAL DARK MODE INTERCEPTOR                             */
        /* ========================================================= */
        html.dark {
            /* 1. Modal Popup & Overlays */
            .fixed.inset-0 .bg-white,
            [role="dialog"],
            [role="dialog"] .bg-white,
            .modal-content,
            div[class*="fixed"] div[class*="bg-white"],
            div[class*="fixed"] div[class*="bg-gray-"] {
                background-color: #121215 !important;
                color: #FAFAFA !important;
                border-color: #27272A !important;
            }

            /* 2. Form Input Box */
            input:not([type="checkbox"]):not([type="radio"]):not([type="hidden"]),
            select,
            textarea {
                background-color: #18181B !important;
                border-color: #27272A !important;
                color: #FAFAFA !important;
            }

            input::placeholder, textarea::placeholder {
                color: #71717A !important;
            }

            option, optgroup {
                background-color: #18181B !important;
                color: #FAFAFA !important;
            }

            /* 3. Kartu & Box Konten Utama */
            [class*="bg-white"]:not(button):not(.badge),
            [class*="bg-gray-50"], [class*="bg-gray-100"], [class*="bg-gray-200"], [class*="bg-gray-300"],
            [class*="bg-slate-50"], [class*="bg-slate-100"], [class*="bg-slate-200"], [class*="bg-slate-300"],
            [class*="bg-neutral-50"], [class*="bg-neutral-100"], [class*="bg-neutral-200"],
            [class*="bg-[#F6F8F6]"], [class*="bg-[#FFFFFF]"], [class*="bg-[#F9FAFB]"] {
                background-color: var(--surface) !important;
                color: var(--text-primary) !important;
            }

            /* 4. Fix Label Form / Subtitle dalam Modal & Halaman */
            label,
            [class*="text-gray-400"], [class*="text-gray-500"], [class*="text-gray-600"],
            [class*="text-slate-400"], [class*="text-slate-500"], [class*="text-slate-600"],
            [class*="text-neutral-400"], [class*="text-neutral-500"], [class*="text-[#68756D]"] {
                color: #A1A1AA !important;
            }
            
            [class*="text-gray-700"], [class*="text-gray-800"], [class*="text-gray-900"],
            [class*="text-slate-700"], [class*="text-slate-800"], [class*="text-slate-900"],
            [class*="text-[#202B25]"], [class*="text-black"] {
                color: #FAFAFA !important;
            }

            /* 5. Tabel & Hover Row */
            table, tbody, thead, tr, td, th {
                background-color: transparent !important;
                color: var(--text-primary) !important;
                border-color: var(--border-color) !important;
            }
            tr:hover, tr:hover td, tr:hover th,
            [class*="hover:bg-white"]:hover,
            [class*="hover:bg-gray-"]:hover,
            [class*="hover:bg-slate-"]:hover {
                background-color: #1F1F23 !important;
                color: #FAFAFA !important;
            }

            /* 6. Header Seksi Laporan Keuangan (Hijau Gelap Netral) */
            [class*="bg-emerald-"], [class*="bg-green-"],
            [class*="bg-[#E8F4EC]"], [class*="bg-[#F0FDF4]"] {
                background-color: #131F19 !important;
                color: #22C55E !important;
                border-color: rgba(34, 197, 94, 0.3) !important;
            }

            /* 7. Kas Keluar & Transaksi Merah (Preservasi Warna RGB Merah/Rose) */
            p[class*="text-red-"], span[class*="text-red-"], div[class*="text-red-"],
            p[class*="text-rose-"], span[class*="text-rose-"], div[class*="text-rose-"],
            .text-red-500, .text-red-600, .text-rose-500, .text-rose-600,
            [class*="text-red-"], [class*="text-rose-"] {
                background-color: transparent !important;
                color: #F43F5E !important;
            }
            p[class*="text-emerald-"], span[class*="text-emerald-"], div[class*="text-emerald-"],
            p[class*="text-green-"], span[class*="text-green-"], div[class*="text-green-"],
            .text-emerald-500, .text-emerald-600, .text-green-500, .text-green-600,
            [class*="text-emerald-"], [class*="text-green-"] {
                background-color: transparent !important;
                color: #10B981 !important;
            }

            [class*="bg-red-900"], [class*="bg-red-950"],
            span[class*="bg-red-"], span[class*="bg-rose-"],
            div[class*="bg-red-50"], div[class*="bg-red-100"] {
                background-color: rgba(244, 63, 94, 0.15) !important;
                color: #F43F5E !important;
                border-color: rgba(244, 63, 94, 0.3) !important;
            }
            [class*="bg-green-900"], [class*="bg-emerald-950"] {
                background-color: rgba(16, 185, 129, 0.15) !important;
                color: #10B981 !important;
            }
        }
    </style>
    @yield('styles')
</head>

<body class="min-h-screen overflow-x-hidden antialiased select-none"
    x-data="{
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('sidebar_collapsed') === 'true',
        darkMode: document.documentElement.classList.contains('dark'),

        toggleCollapse() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('sidebar_collapsed', this.sidebarCollapsed);
            if (this.sidebarCollapsed) {
                document.documentElement.classList.add('sidebar-collapsed');
            } else {
                document.documentElement.classList.remove('sidebar-collapsed');
            }
        },

        toggleTheme() {
            this.darkMode = !this.darkMode;
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    }"
    @keydown.escape.window="sidebarOpen = false">

    {{-- Mobile Sidebar Backdrop --}}
    <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false"
        x-transition:enter="transition-opacity ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-black/60 backdrop-blur-xs lg:hidden" aria-hidden="true">
    </div>

    <div class="app-shell flex min-h-screen w-full">

        {{-- MAIN SIDEBAR --}}
        <aside id="main-navigation"
            class="app-sidebar fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r shadow-xl lg:sticky lg:top-0 lg:h-screen lg:translate-x-0 lg:shadow-none"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" aria-label="Navigasi utama">

            {{-- Header Logo / Brand --}}
            <div class="sidebar-brand-header flex min-h-[4.5rem] items-center justify-between border-b border-[var(--sidebar-border)] px-4 py-3">
                <a href="{{ route('dashboard') }}" class="sidebar-brand flex min-w-0 items-center gap-3" title="CTC General Ledger">
                    <img src="{{ asset('images/Logo_CTC.png') }}" alt="Logo CTC" class="sidebar-brand-logo filter drop-shadow-xs">
                    <span class="sidebar-brand-copy min-w-0">
                        <span class="block truncate text-sm font-extrabold tracking-tight" style="color: var(--sidebar-brand-text)">SIK & Payroll</span>
                        <span class="mt-0.5 block truncate text-[10px] font-semibold uppercase tracking-wider text-[#176B45] dark:text-neutral-400">CTC General Ledger</span>
                    </span>
                </a>

                {{-- Toggle Desktop --}}
                <button type="button" @click="toggleCollapse()" title="Toggle Size Sidebar"
                    class="btn-press hidden h-7 w-7 shrink-0 items-center justify-center rounded-lg border border-[var(--border-color)] bg-[var(--surface)] text-[var(--text-secondary)] transition hover:text-[var(--text-primary)] focus:outline-none lg:flex">
                    <i class="fa-solid fa-bars-staggered text-[11px]"></i>
                </button>

                {{-- Close Mobile --}}
                <button type="button" @click="sidebarOpen = false"
                    class="btn-press rounded-lg p-1.5 text-[var(--text-secondary)] hover:text-[var(--text-primary)] lg:hidden">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

            {{-- Menu Navigasi --}}
            <nav id="sidebar-nav-container" x-ref="sidebarNav"
                @scroll.debounce.100ms="sessionStorage.setItem('ctc_sidebar_scroll', $event.target.scrollTop)"
                class="min-h-0 flex-1 space-y-1 overflow-y-auto sidebar-scroll px-3 py-4" aria-label="Menu aplikasi">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif
                    class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                    <i class="sidebar-icon fa-solid fa-gauge-high text-sm w-5 text-center shrink-0"></i>
                    <span class="sidebar-label">Dashboard</span>
                    <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                        Dashboard Utama
                    </div>
                </a>

                {{-- Master Data --}}
                @role('admin')
                    <p class="sidebar-section-label px-3 pt-5 pb-1.5 text-[10px]">Master Data</p>

                    <a href="{{ route('admin.users.index') }}" @if(request()->routeIs('admin.users.*')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-users-gear text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Manajemen User</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Manajemen User
                        </div>
                    </a>

                    <a href="{{ route('admin.chart-of-accounts.index') }}" @if(request()->routeIs('admin.chart-of-accounts.*')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-folder-tree text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Rekening (COA)</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Rekening (COA)
                        </div>
                    </a>
                @endrole

                {{-- Akuntansi & Transaksi --}}
                @hasanyrole('admin|akuntan')
                    <p class="sidebar-section-label px-3 pt-5 pb-1.5 text-[10px]">Akuntansi & Transaksi</p>

                    <a href="{{ route('admin.journals.index') }}" @if(request()->routeIs('admin.journals.index')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-book-journal-whills text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Jurnal Umum</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Jurnal Umum
                        </div>
                    </a>

                    <a href="{{ route('admin.journals.reversals.index') }}" @if(request()->routeIs('admin.journals.reversals.index')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-arrow-rotate-left text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Jurnal Pembalikan</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Jurnal Pembalikan
                        </div>
                    </a>

                    <a href="{{ route('admin.bank-reconciliations.index') }}" @if(request()->routeIs('admin.bank-reconciliations.*')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-building-columns text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Rekonsiliasi Bank</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Rekonsiliasi Bank
                        </div>
                    </a>

                    <a href="{{ route('admin.adjustments.index') }}" @if(request()->routeIs('admin.adjustments.*')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-sliders text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Jurnal Penyesuaian</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Jurnal Penyesuaian
                        </div>
                    </a>

                    <a href="{{ route('admin.taxes.index') }}" @if(request()->routeIs('admin.taxes.*', 'admin.reports.tax*')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-file-invoice-dollar text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Perpajakan</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Perpajakan (PPN & PPh)
                        </div>
                    </a>
                @endhasanyrole

                {{-- Operasional --}}
                @hasanyrole('admin|akuntan|staff')
                    <p class="sidebar-section-label px-3 pt-5 pb-1.5 text-[10px]">Operasional</p>

                    <a href="{{ route('admin.cash-transactions.index') }}" @if(request()->routeIs('admin.cash-transactions.*')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-wallet text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Transaksi Kas</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Transaksi Kas & Bank
                        </div>
                    </a>

                    <a href="{{ route('admin.payrolls.index') }}" @if(request()->routeIs('admin.payrolls.*', 'admin.reports.payroll*')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-money-check-dollar text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Penggajian (Payroll)</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Penggajian (Payroll)
                        </div>
                    </a>
                @endhasanyrole

                {{-- Laporan Keuangan --}}
                @hasanyrole('admin|akuntan')
                    <p class="sidebar-section-label px-3 pt-5 pb-1.5 text-[10px]">Laporan Keuangan</p>

                    <a href="{{ route('admin.reports.general-ledger') }}" @if(request()->routeIs('admin.reports.general-ledger*')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-book text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Buku Besar</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Laporan Buku Besar
                        </div>
                    </a>

                    <a href="{{ route('admin.reports.profit-loss') }}" @if(request()->routeIs('admin.reports.profit-loss*')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-chart-line text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Laba Rugi</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Laporan Laba Rugi
                        </div>
                    </a>

                    <a href="{{ route('admin.reports.balance-sheet') }}" @if(request()->routeIs('admin.reports.balance-sheet*')) aria-current="page" @endif
                       class="sidebar-link relative group flex items-center rounded-xl py-2.5 text-xs font-semibold">
                        <i class="sidebar-icon fa-solid fa-scale-balanced text-sm w-5 text-center shrink-0"></i>
                        <span class="sidebar-label">Neraca</span>
                        <div class="sidebar-tooltip hidden absolute left-full ml-3 px-3 py-1.5 bg-slate-900 border border-neutral-700 text-white text-xs font-semibold rounded-xl shadow-xl whitespace-nowrap pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                            Laporan Neraca
                        </div>
                    </a>
                @endhasanyrole
            </nav>

            {{-- Profil User Bottom Card --}}
            <div class="border-t border-[var(--sidebar-border)] p-3 shrink-0">
                <div class="sidebar-user-card flex items-center justify-between rounded-xl p-2 transition-colors"
                     style="background-color: var(--user-card-bg); border: 1px solid var(--user-card-border);">
                    <div class="sidebar-user-info flex items-center gap-2.5 min-w-0">
                        <div class="w-7 h-7 rounded-lg text-white font-extrabold flex items-center justify-center text-xs shrink-0 shadow-xs"
                             style="background-color: var(--user-card-avatar-bg);" title="{{ auth()->user()->name }}">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="sidebar-user-text min-w-0 leading-tight">
                            <p class="text-xs font-bold truncate" style="color: var(--user-card-name-text);">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] capitalize font-medium truncate" style="color: var(--text-secondary);">
                                {{ auth()->user()->getRoleNames()->first() ?? 'User' }}
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Keluar Sesi MERAH --}}
                    <div class="flex items-center gap-1 shrink-0">
                        <form action="{{ route('logout') }}" method="POST" class="inline-flex">
                            @csrf
                            <button type="submit" title="Keluar Sesi"
                                class="btn-press w-7 h-7 rounded-lg flex items-center justify-center transition"
                                style="background-color: var(--logout-btn-bg); border: 1px solid var(--logout-btn-border); color: var(--logout-btn-text);">
                                <i class="fa-solid fa-right-from-bracket text-[10px]"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                (function() {
                    const nav = document.getElementById('sidebar-nav-container');
                    const savedScroll = sessionStorage.getItem('ctc_sidebar_scroll');
                    if (nav && savedScroll) { nav.scrollTop = savedScroll; }
                })();
            </script>
        </aside>

        {{-- Main Area --}}
        <div class="flex min-h-screen min-w-0 flex-1 flex-col">

            {{-- Topbar Header --}}
            <header class="app-topbar sticky top-0 z-30 flex min-h-[4.25rem] items-center justify-between gap-2 border-b px-3.5 shadow-sm backdrop-blur sm:px-5 lg:px-7">
                <div class="flex min-w-0 items-center gap-2.5 sm:gap-3">
                    <button type="button" @click="sidebarOpen = true" aria-label="Buka navigasi"
                        class="btn-press flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-[var(--border-color)] bg-[var(--surface)] text-[#176B45] dark:text-neutral-200 hover:bg-[var(--bg-main)] focus:outline-none lg:hidden">
                        <i class="fa-solid fa-bars text-base"></i>
                    </button>

                    <div class="min-w-0">
                        <p class="truncate text-xs font-bold text-[var(--text-primary)] sm:text-base">Sistem Keuangan & Payroll</p>
                        <p class="hidden truncate text-xs text-[var(--text-secondary)] md:block">CTC General Ledger — Dual Theme Edition</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 shrink-0">
                    {{-- Dual Theme Switcher Toggle (Light/Dark) --}}
                    <button type="button" @click="toggleTheme()" title="Ubah Tema (Light/Dark)"
                        class="btn-press relative flex h-9 w-9 items-center justify-center rounded-xl border border-[var(--border-color)] bg-[var(--surface)] text-[var(--text-primary)] hover:bg-[var(--bg-main)] focus:outline-none">
                        <i x-show="!darkMode" class="fa-solid fa-moon text-sm"></i>
                        <i x-show="darkMode" class="fa-solid fa-sun text-sm text-amber-400" x-cloak></i>
                    </button>

                    <div class="h-5 w-px bg-[var(--border-color)] hidden sm:block"></div>

                    {{-- Badge User Topbar Kanan Atas (Container Abu-Abu di Light Mode, Font Admin Putih & Samping Tetap Hijau CTC) --}}
                    @php($activeRole = auth()->user()->getRoleNames()->first() ?? session('active_role', 'GUEST'))
                    <div class="inline-flex items-center gap-2 rounded-xl border border-gray-300 dark:border-emerald-800/50 bg-gray-200 dark:bg-emerald-950/60 px-3 py-1.5 text-xs font-semibold shadow-2xs transition-colors">
                        <span class="hidden sm:inline-block font-bold text-gray-800 dark:text-emerald-300 text-xs max-w-[140px] md:max-w-[200px] lg:max-w-none truncate">
                            Halo, {{ auth()->user()->name }}
                        </span>
                        <span class="rounded-md bg-[#176B45] dark:bg-emerald-500 text-white dark:text-slate-950 px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider shrink-0 shadow-xs">
                            {{ str_contains(strtolower($activeRole), 'admin') ? 'Admin' : $activeRole }}
                        </span>
                    </div>
                </div>
            </header>

            {{-- Content Area --}}
            <main id="app-main" class="feature-page min-w-0 flex-1 overflow-x-hidden">
                @yield('content')
            </main>

            <footer class="border-t border-[var(--border-color)] bg-[var(--surface)] px-4 py-3 text-center text-xs text-[var(--text-secondary)] sm:px-6">
                CTC General Ledger <span class="mx-1">&middot;</span> Sistem Keuangan & Payroll
            </footer>
        </div>
    </div>

    @yield('scripts')
</body>
</html>