<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Exports\ArrayExport;
use App\Models\Donation;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $stats = $this->getStats($request);
        return view('cp.financial.reports.index', compact('stats'));
    }

    public function donations(Request $request)
    {
        $query = Donation::query()->with('reviewer')
            ->where('status', 'approved')
            ->orderBy('donation_date');

        if ($request->filled('date_from')) {
            $query->where('donation_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('donation_date', '<=', $request->date_to);
        }
        if ($request->filled('donation_method')) {
            $query->where('donation_method', $request->donation_method);
        }

        $donations = $request->has('export') ? $query->get() : $query->paginate(20)->withQueryString();
        $total = $query->sum('amount');

        if ($request->get('export') === 'pdf') {
            return $this->exportDonationsPdf($donations, $total, $request);
        }
        if ($request->get('export') === 'excel') {
            return $this->exportDonationsExcel($donations, $total, $request);
        }

        return view('cp.financial.reports.donations', compact('donations', 'total'));
    }

    public function expenses(Request $request)
    {
        $query = FinancialTransaction::query()->with(['approver', 'creator'])
            ->whereIn('status', ['approved', 'completed'])
            ->whereIn('type', ['expense', 'grant_payment', 'project_funding'])
            ->orderBy('transaction_date');

        if ($request->filled('date_from')) {
            $query->where('transaction_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('transaction_date', '<=', $request->date_to);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $request->has('export') ? $query->get() : $query->paginate(20)->withQueryString();
        $total = (clone $query)->sum('amount');

        if ($request->get('export') === 'pdf') {
            return $this->exportExpensesPdf($transactions, $total, $request);
        }
        if ($request->get('export') === 'excel') {
            return $this->exportExpensesExcel($transactions, $total, $request);
        }

        return view('cp.financial.reports.expenses', compact('transactions', 'total'));
    }

    public function cashFlow(Request $request)
    {
        $queryDonations = Donation::where('status', 'approved');
        $queryExpenses = FinancialTransaction::whereIn('status', ['approved', 'completed'])
            ->whereIn('type', ['expense', 'grant_payment', 'project_funding']);

        if ($request->filled('date_from')) {
            $queryDonations->where('donation_date', '>=', $request->date_from);
            $queryExpenses->where('transaction_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $queryDonations->where('donation_date', '<=', $request->date_to);
            $queryExpenses->where('transaction_date', '<=', $request->date_to);
        }

        $donationsTotal = $queryDonations->sum('amount');
        $expensesTotal = (clone $queryExpenses)->sum('amount');
        $balance = $donationsTotal - $expensesTotal;

        $stats = [
            'donations_total' => $donationsTotal,
            'expenses_total' => $expensesTotal,
            'balance' => $balance,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        if ($request->get('export') === 'pdf') {
            return $this->exportCashFlowPdf($stats, $request);
        }
        if ($request->get('export') === 'excel') {
            return $this->exportCashFlowExcel($stats, $request);
        }

        return view('cp.financial.reports.cash-flow', compact('stats'));
    }

    protected function getStats(Request $request): array
    {
        $queryDonations = Donation::where('status', 'approved');
        $queryExpenses = FinancialTransaction::whereIn('status', ['approved', 'completed'])
            ->whereIn('type', ['expense', 'grant_payment', 'project_funding']);

        if ($request->filled('date_from')) {
            $queryDonations->where('donation_date', '>=', $request->date_from);
            $queryExpenses->where('transaction_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $queryDonations->where('donation_date', '<=', $request->date_to);
            $queryExpenses->where('transaction_date', '<=', $request->date_to);
        }

        return [
            'donations_total' => $queryDonations->sum('amount'),
            'expenses_total' => (clone $queryExpenses)->sum('amount'),
            'donations_count' => (clone $queryDonations)->count(),
            'expenses_count' => (clone $queryExpenses)->count(),
        ];
    }

    protected function exportDonationsPdf($donations, float $total, Request $request)
    {
        $html = view('cp.financial.reports.pdf.donations', [
            'donations' => $donations instanceof \Illuminate\Pagination\LengthAwarePaginator ? $donations->items() : $donations,
            'total' => $total,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
        ])->render();

        return $this->renderPdf($html, 'تقرير-التبرعات-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function exportDonationsExcel($donations, float $total, Request $request)
    {
        $items = $donations instanceof \Illuminate\Pagination\LengthAwarePaginator ? $donations->items() : $donations;
        $headings = ['#', 'المتبرع', 'المبلغ', 'الطريقة', 'التاريخ'];
        $rows = collect($items)->values()->map(function ($d, $i) {
            return [
                $i + 1,
                $d->donor_name,
                number_format((float) $d->amount, 2) . ' ' . $d->currency,
                Donation::donationMethods()[$d->donation_method] ?? $d->donation_method,
                optional($d->donation_date)->format('Y-m-d') ?: '—',
            ];
        })->all();
        $rows[] = ['', 'الإجمالي', number_format($total, 2) . ' ILS', '', ''];

        try {
            if (class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
                return \Maatwebsite\Excel\Facades\Excel::download(
                    new ArrayExport($headings, $rows, 'تقرير التبرعات — جمعية أصدقاء جامعة بيرزيت'),
                    'financial-donations-report-' . now()->format('Y-m-d') . '.xlsx'
                );
            }
        } catch (\Throwable) {
        }

        $html = view('cp.financial.reports.excel.donations', [
            'donations' => $items,
            'total' => $total,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
        ])->render();

        return $this->renderExcel($html, 'تقرير-التبرعات-' . now()->format('Y-m-d') . '.xls');
    }

    protected function exportExpensesPdf($transactions, float $total, Request $request)
    {
        $items = $transactions instanceof \Illuminate\Pagination\LengthAwarePaginator ? $transactions->items() : $transactions;
        $html = view('cp.financial.reports.pdf.expenses', [
            'transactions' => $items,
            'total' => $total,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
        ])->render();

        return $this->renderPdf($html, 'تقرير-المصروفات-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function exportExpensesExcel($transactions, float $total, Request $request)
    {
        $items = $transactions instanceof \Illuminate\Pagination\LengthAwarePaginator ? $transactions->items() : $transactions;
        $headings = ['#', 'النوع', 'المستفيد', 'المبلغ', 'التاريخ'];
        $rows = collect($items)->values()->map(function ($t, $i) {
            return [
                $i + 1,
                FinancialTransaction::types()[$t->type] ?? $t->type,
                $t->beneficiary_name,
                number_format((float) $t->amount, 2) . ' ' . $t->currency,
                optional($t->transaction_date)->format('Y-m-d') ?: '—',
            ];
        })->all();
        $rows[] = ['', 'الإجمالي', '', number_format($total, 2) . ' ILS', ''];

        try {
            if (class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
                return \Maatwebsite\Excel\Facades\Excel::download(
                    new ArrayExport($headings, $rows, 'تقرير المصروفات — جمعية أصدقاء جامعة بيرزيت'),
                    'financial-expenses-report-' . now()->format('Y-m-d') . '.xlsx'
                );
            }
        } catch (\Throwable) {
        }

        $html = view('cp.financial.reports.excel.expenses', [
            'transactions' => $items,
            'total' => $total,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
        ])->render();

        return $this->renderExcel($html, 'تقرير-المصروفات-' . now()->format('Y-m-d') . '.xls');
    }

    protected function exportCashFlowPdf(array $stats, Request $request)
    {
        $html = view('cp.financial.reports.pdf.cash-flow', [
            'stats' => $stats,
        ])->render();

        return $this->renderPdf($html, 'تقرير-التدفق-النقدي-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function exportCashFlowExcel(array $stats, Request $request)
    {
        $headings = ['البند', 'القيمة'];
        $rows = [
            ['إجمالي التبرعات (الإيرادات)', number_format((float) ($stats['donations_total'] ?? 0), 2) . ' ILS'],
            ['إجمالي المصروفات', number_format((float) ($stats['expenses_total'] ?? 0), 2) . ' ILS'],
            ['الرصيد', number_format((float) ($stats['balance'] ?? 0), 2) . ' ILS'],
        ];

        try {
            if (class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
                return \Maatwebsite\Excel\Facades\Excel::download(
                    new ArrayExport($headings, $rows, 'تقرير التدفق النقدي — جمعية أصدقاء جامعة بيرزيت'),
                    'financial-cash-flow-report-' . now()->format('Y-m-d') . '.xlsx'
                );
            }
        } catch (\Throwable) {
        }

        $html = view('cp.financial.reports.excel.cash_flow', [
            'stats' => $stats,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
        ])->render();

        return $this->renderExcel($html, 'تقرير-التدفق-النقدي-' . now()->format('Y-m-d') . '.xls');
    }

    protected function renderExcel(string $html, string $filename): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }

    protected function renderPdf(string $html, string $filename)
    {
        if (class_exists(\Mpdf\Mpdf::class)) {
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'default_font' => 'dejavusans',
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
            ]);
            $mpdf->SetDirectionality('rtl');
            $mpdf->WriteHTML($html);

            return response($mpdf->Output($filename, 'S'), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
                ->setPaper('a4')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('defaultFont', 'DejaVu Sans')
                ->setOption('isFontSubsettingEnabled', true);
            return $pdf->download($filename);
        }

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=utf-8',
            'Content-Disposition' => 'inline; filename="' . $filename . '.html"',
        ]);
    }

}
