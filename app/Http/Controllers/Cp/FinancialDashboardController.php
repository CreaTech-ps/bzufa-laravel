<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\FinancialTransaction;
use Illuminate\Support\Facades\DB;

class FinancialDashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfYear = $now->copy()->startOfYear();

        $donationsTotal = Donation::where('status', 'approved')->sum('amount');
        $donationsMonth = Donation::where('status', 'approved')->where('donation_date', '>=', $startOfMonth)->sum('amount');
        $donationsYear = Donation::where('status', 'approved')->where('donation_date', '>=', $startOfYear)->sum('amount');
        $donationsPending = Donation::where('status', 'pending')->count();
        $donationsPendingAmount = Donation::where('status', 'pending')->sum('amount');

        $expensesTotal = FinancialTransaction::whereIn('status', ['approved', 'completed'])
            ->whereIn('type', ['expense', 'grant_payment', 'project_funding'])->sum('amount');
        $expensesMonth = FinancialTransaction::whereIn('status', ['approved', 'completed'])
            ->whereIn('type', ['expense', 'grant_payment', 'project_funding'])
            ->where('transaction_date', '>=', $startOfMonth)->sum('amount');
        $expensesYear = FinancialTransaction::whereIn('status', ['approved', 'completed'])
            ->whereIn('type', ['expense', 'grant_payment', 'project_funding'])
            ->where('transaction_date', '>=', $startOfYear)->sum('amount');
        $transactionsPending = FinancialTransaction::where('status', 'pending_review')->count();

        $balance = $donationsTotal - $expensesTotal;

        $donationsByMonth = Donation::where('status', 'approved')
            ->where('donation_date', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->get(['donation_date', 'amount'])
            ->groupBy(fn ($d) => $d->donation_date->format('Y-m'))
            ->map(fn ($g) => (object) ['month' => $g->keys()->first(), 'total' => $g->sum('amount')])
            ->values()
            ->sortBy('month')
            ->values();

        $expensesByMonth = FinancialTransaction::whereIn('status', ['approved', 'completed'])
            ->whereIn('type', ['expense', 'grant_payment', 'project_funding'])
            ->where('transaction_date', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->get(['transaction_date', 'amount'])
            ->groupBy(fn ($t) => $t->transaction_date->format('Y-m'))
            ->map(fn ($g) => (object) ['month' => $g->keys()->first(), 'total' => $g->sum('amount')])
            ->values()
            ->sortBy('month')
            ->values();

        $recentDonations = Donation::with('reviewer')->orderByDesc('created_at')->take(5)->get();
        $recentTransactions = FinancialTransaction::with(['approver', 'creator'])->orderByDesc('created_at')->take(5)->get();

        $stats = [
            'donations_total' => $donationsTotal,
            'donations_month' => $donationsMonth,
            'donations_year' => $donationsYear,
            'donations_pending' => $donationsPending,
            'donations_pending_amount' => $donationsPendingAmount,
            'expenses_total' => $expensesTotal,
            'expenses_month' => $expensesMonth,
            'expenses_year' => $expensesYear,
            'transactions_pending' => $transactionsPending,
            'balance' => $balance,
        ];

        return view('cp.financial.index', compact(
            'stats',
            'donationsByMonth',
            'expensesByMonth',
            'recentDonations',
            'recentTransactions'
        ));
    }
}
