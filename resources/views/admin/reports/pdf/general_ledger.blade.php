<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku Besar - {{ $reportData['selected_account']->code }}</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 10px; 
            margin: 15px; 
            color: #1e293b; 
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 2px solid #059669; 
            padding-bottom: 10px; 
        }
        .header-eyebrow {
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #059669;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .header h2 { 
            margin: 0; 
            text-transform: uppercase; 
            color: #0f172a; 
            font-size: 15px; 
        }
        .account-title { 
            font-size: 12px; 
            font-weight: bold; 
            color: #0f172a; 
            margin: 4px 0 2px 0; 
        }
        .header p { 
            margin: 2px 0; 
            color: #475569; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #cbd5e1; 
            padding: 6px 7px; 
            text-align: left; 
        }
        th { 
            background-color: #f8fafc; 
            color: #475569; 
            text-transform: uppercase; 
            font-size: 8px; 
            font-weight: bold; 
        }
        .text-right { text-align: right; }
        .font-mono { font-family: monospace; }
        .bg-opening { background-color: #f1f5f9; font-weight: bold; }
        .bg-total { background-color: #f8fafc; font-weight: bold; }
        .footer-sign { 
            margin-top: 40px; 
            width: 100%; 
            border: none; 
        }
        .footer-sign td { 
            border: none; 
            text-align: center; 
            vertical-align: top; 
            width: 50%; 
        }
    </style>
</head>
<body>
    <div class="header">
        <p class="header-eyebrow">CTC Finance Report</p>
        <h2>Laporan Buku Besar</h2>
        <p class="account-title">{{ $reportData['selected_account']->code }} - {{ $reportData['selected_account']->name }}</p>
        <p>Periode: {{ \Carbon\Carbon::parse($reportData['start_date'])->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($reportData['end_date'])->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 15%;">No. Jurnal</th>
                <th>Keterangan / Memo</th>
                <th class="text-right" style="width: 14%;">Debit</th>
                <th class="text-right" style="width: 14%;">Kredit</th>
                <th class="text-right" style="width: 16%;">Saldo Running</th>
            </tr>
        </thead>
        <tbody>
            <!-- Row Saldo Awal -->
            <tr class="bg-opening">
                <td>{{ $reportData['start_date'] }}</td>
                <td class="font-mono" style="color: #94a3b8;">-</td>
                <td style="text-transform: uppercase; font-weight: bold;">SALDO AWAL PERIODE</td>
                <td class="text-right font-mono" style="color: #94a3b8;">-</td>
                <td class="text-right font-mono" style="color: #94a3b8;">-</td>
                <td class="text-right font-mono">Rp {{ number_format($reportData['opening_balance'], 0, ',', '.') }}</td>
            </tr>

            <!-- Detail Transaksi -->
            @forelse($reportData['ledger_entries'] as $entry)
                <tr>
                    <td>{{ $entry->journal->journal_date }}</td>
                    <td class="font-mono" style="font-weight: bold;">{{ $entry->journal->journal_number }}</td>
                    <td>{{ $entry->memo ?? $entry->journal->description }}</td>
                    <td class="text-right font-mono">{{ $entry->debit > 0 ? 'Rp ' . number_format($entry->debit, 0, ',', '.') : '-' }}</td>
                    <td class="text-right font-mono">{{ $entry->credit > 0 ? 'Rp ' . number_format($entry->credit, 0, ',', '.') : '-' }}</td>
                    <td class="text-right font-mono" style="font-weight: bold;">Rp {{ number_format($entry->running_balance, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 20px;">
                        Tidak ada transaksi jurnal pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="bg-total">
                <td colspan="3" class="text-right" style="text-transform: uppercase; font-size: 8px;">Total Mutasi & Saldo Akhir:</td>
                <td class="text-right font-mono" style="color: #047857;">Rp {{ number_format($reportData['total_debit'], 0, ',', '.') }}</td>
                <td class="text-right font-mono" style="color: #b91c1c;">Rp {{ number_format($reportData['total_credit'], 0, ',', '.') }}</td>
                <td class="text-right font-mono" style="background-color: #e2e8f0;">Rp {{ number_format($reportData['ending_balance'], 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <table class="footer-sign">
        <tr>
            <td>
                <p>Dibuat Oleh,</p>
                <br><br><br>
                <p><strong><u>{{ auth()->user()->name }}</u></strong></p>
                <p style="font-size: 9px; color: #64748b;">Staff Keuangan / Akuntan</p>
            </td>
            <td>
                <p>Disetujui Oleh,</p>
                <br><br><br>
                <p><strong><u>( .................................... )</u></strong></p>
                <p style="font-size: 9px; color: #64748b;">Manager Keuangan</p>
            </td>
        </tr>
    </table>
</body>
</html>