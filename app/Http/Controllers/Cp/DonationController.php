<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\FinancialAuditLog;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::query()->with('reviewer')->orderByDesc('donation_date');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('donation_method')) {
            $query->where('donation_method', $request->donation_method);
        }
        if ($request->filled('date_from')) {
            $query->where('donation_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('donation_date', '<=', $request->date_to);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('donor_name', 'like', "%{$s}%")
                    ->orWhere('donor_email', 'like', "%{$s}%")
                    ->orWhere('reference_number', 'like', "%{$s}%");
            });
        }

        $donations = $query->paginate(15)->withQueryString();

        return view('cp.financial.donations.index', compact('donations'));
    }

    public function create()
    {
        return view('cp.financial.donations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => ['required', 'string', 'max:255'],
            'donor_email' => ['nullable', 'email'],
            'donor_phone' => ['nullable', 'string', 'max:50'],
            'donor_type' => ['required', 'in:individual,institution,anonymous'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['nullable', 'string', 'max:10'],
            'donation_method' => ['required', 'in:bank_transfer,cash,card,electronic,other'],
            'donation_date' => ['required', 'date'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'purpose' => ['nullable', 'in:general,scholarship,project,tribute'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['currency'] = $validated['currency'] ?? 'ILS';
        $validated['status'] = 'pending';

        $donation = Donation::create($validated);
        FinancialAuditLog::log('created', $donation, null, $donation->toArray());

        return redirect()->route('cp.donations.index')->with('success', 'تم إضافة التبرع بنجاح.');
    }

    public function show(Donation $donation)
    {
        $donation->load('reviewer');
        return view('cp.financial.donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        return view('cp.financial.donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'donor_name' => ['required', 'string', 'max:255'],
            'donor_email' => ['nullable', 'email'],
            'donor_phone' => ['nullable', 'string', 'max:50'],
            'donor_type' => ['required', 'in:individual,institution,anonymous'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['nullable', 'string', 'max:10'],
            'donation_method' => ['required', 'in:bank_transfer,cash,card,electronic,other'],
            'donation_date' => ['required', 'date'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'purpose' => ['nullable', 'in:general,scholarship,project,tribute'],
            'notes' => ['nullable', 'string'],
        ]);

        $oldValues = $donation->toArray();
        $donation->update($validated);
        FinancialAuditLog::log('updated', $donation, $oldValues, $donation->toArray());

        return redirect()->route('cp.donations.index')->with('success', 'تم تحديث التبرع بنجاح.');
    }

    public function approve(Donation $donation)
    {
        if ($donation->status !== 'pending') {
            return back()->with('error', 'لا يمكن اعتماد تبرع غير قيد الانتظار.');
        }

        $oldValues = $donation->toArray();
        $donation->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'rejection_reason' => null,
        ]);
        FinancialAuditLog::log('approved', $donation, $oldValues, $donation->toArray());

        return back()->with('success', 'تم اعتماد التبرع.');
    }

    public function reject(Request $request, Donation $donation)
    {
        if ($donation->status !== 'pending') {
            return back()->with('error', 'لا يمكن رفض تبرع غير قيد الانتظار.');
        }

        $request->validate(['rejection_reason' => ['nullable', 'string', 'max:500']]);

        $oldValues = $donation->toArray();
        $donation->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'rejection_reason' => $request->rejection_reason,
        ]);
        FinancialAuditLog::log('rejected', $donation, $oldValues, $donation->toArray());

        return back()->with('success', 'تم رفض التبرع.');
    }
}
