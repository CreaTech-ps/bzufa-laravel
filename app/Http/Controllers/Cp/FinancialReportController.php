<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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

    protected function exportCashFlowPdf(array $stats, Request $request)
    {
        $html = view('cp.financial.reports.pdf.cash-flow', [
            'stats' => $stats,
        ])->render();

        return $this->renderPdf($html, 'تقرير-التدفق-النقدي-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function renderPdf(string $html, string $filename)
    {
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
                ->setPaper('a4')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);
            return $pdf->download($filename);
        }

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=utf-8',
            'Content-Disposition' => 'inline; filename="' . $filename . '.html"',
        ]);
    }
}
