<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\FinancialTransaction;
use App\Models\FinancialAuditLog;
use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;

class FinancialTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = FinancialTransaction::query()->with(['approver', 'creator'])->orderByDesc('transaction_date');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('date_from')) {
            $query->where('transaction_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('transaction_date', '<=', $request->date_to);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('beneficiary_name', 'like', "%{$s}%")
                    ->orWhere('bank_reference', 'like', "%{$s}%")
                    ->orWhere('purpose', 'like', "%{$s}%");
            });
        }

        $transactions = $query->paginate(15)->withQueryString();

        return view('cp.financial.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $scholarshipApplications = ScholarshipApplication::where('status', 'approved')
            ->orderByDesc('created_at')
            ->get(['id', 'applicant_name', 'scholarship_id']);
        return view('cp.financial.transactions.create', compact('scholarshipApplications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:expense,transfer,grant_payment,project_funding'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['nullable', 'string', 'max:10'],
            'transaction_date' => ['required', 'date'],
            'beneficiary_name' => ['required', 'string', 'max:255'],
            'beneficiary_type' => ['required', 'in:student,institution,project,other'],
            'purpose' => ['required', 'string'],
            'scholarship_application_id' => ['nullable', 'exists:scholarship_applications,id'],
            'payment_method' => ['required', 'in:bank_transfer,cheque,cash'],
            'bank_reference' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['currency'] = $validated['currency'] ?? 'ILS';
        $validated['status'] = 'draft';
        $validated['created_by'] = auth()->id();

        if (! empty($validated['scholarship_application_id'])) {
            $validated['reference_type'] = ScholarshipApplication::class;
            $validated['reference_id'] = $validated['scholarship_application_id'];
        }
        unset($validated['scholarship_application_id']);

        $transaction = FinancialTransaction::create($validated);
        FinancialAuditLog::log('created', $transaction, null, $transaction->toArray());

        return redirect()->route('cp.financial-transactions.index')->with('success', 'تم إنشاء الحركة المالية بنجاح.');
    }

    public function show(FinancialTransaction $financialTransaction)
    {
        $financialTransaction->load(['approver', 'creator']);
        if ($financialTransaction->reference_type === ScholarshipApplication::class && $financialTransaction->reference_id) {
            $financialTransaction->loadReference = ScholarshipApplication::with('scholarship')->find($financialTransaction->reference_id);
        }
        return view('cp.financial.transactions.show', compact('financialTransaction'));
    }

    public function edit(FinancialTransaction $financialTransaction)
    {
        if (! in_array($financialTransaction->status, ['draft', 'rejected'])) {
            return back()->with('error', 'لا يمكن تعديل الحركة في حالتها الحالية.');
        }

        $scholarshipApplications = ScholarshipApplication::where('status', 'approved')
            ->orderByDesc('created_at')
            ->get(['id', 'applicant_name', 'scholarship_id']);
        return view('cp.financial.transactions.edit', compact('financialTransaction', 'scholarshipApplications'));
    }

    public function update(Request $request, FinancialTransaction $financialTransaction)
    {
        if (! in_array($financialTransaction->status, ['draft', 'rejected'])) {
            return back()->with('error', 'لا يمكن تعديل الحركة في حالتها الحالية.');
        }

        $validated = $request->validate([
            'type' => ['required', 'in:expense,transfer,grant_payment,project_funding'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['nullable', 'string', 'max:10'],
            'transaction_date' => ['required', 'date'],
            'beneficiary_name' => ['required', 'string', 'max:255'],
            'beneficiary_type' => ['required', 'in:student,institution,project,other'],
            'purpose' => ['required', 'string'],
            'scholarship_application_id' => ['nullable', 'exists:scholarship_applications,id'],
            'payment_method' => ['required', 'in:bank_transfer,cheque,cash'],
            'bank_reference' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['currency'] = $validated['currency'] ?? 'ILS';
        $validated['status'] = 'pending_review';
        $validated['rejection_reason'] = null;

        if (! empty($validated['scholarship_application_id'])) {
            $validated['reference_type'] = ScholarshipApplication::class;
            $validated['reference_id'] = $validated['scholarship_application_id'];
        } else {
            $validated['reference_type'] = null;
            $validated['reference_id'] = null;
        }
        unset($validated['scholarship_application_id']);

        $oldValues = $financialTransaction->toArray();
        $financialTransaction->update($validated);
        FinancialAuditLog::log('updated', $financialTransaction, $oldValues, $financialTransaction->toArray());

        return redirect()->route('cp.financial-transactions.index')->with('success', 'تم تحديث الحركة وإرسالها للمراجعة.');
    }

    public function submitForReview(FinancialTransaction $financialTransaction)
    {
        if ($financialTransaction->status !== 'draft') {
            return back()->with('error', 'لا يمكن إرسال الحركة للمراجعة في حالتها الحالية.');
        }

        $oldValues = $financialTransaction->toArray();
        $financialTransaction->update(['status' => 'pending_review']);
        FinancialAuditLog::log('submitted', $financialTransaction, $oldValues, $financialTransaction->toArray());

        return back()->with('success', 'تم إرسال الحركة للمراجعة.');
    }

    public function approve(FinancialTransaction $financialTransaction)
    {
        if ($financialTransaction->status !== 'pending_review') {
            return back()->with('error', 'لا يمكن اعتماد الحركة في حالتها الحالية.');
        }

        $oldValues = $financialTransaction->toArray();
        $financialTransaction->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejection_reason' => null,
        ]);
        FinancialAuditLog::log('approved', $financialTransaction, $oldValues, $financialTransaction->toArray());

        return back()->with('success', 'تم اعتماد الحركة المالية.');
    }

    public function reject(Request $request, FinancialTransaction $financialTransaction)
    {
        if ($financialTransaction->status !== 'pending_review') {
            return back()->with('error', 'لا يمكن رفض الحركة في حالتها الحالية.');
        }

        $request->validate(['rejection_reason' => ['nullable', 'string', 'max:500']]);

        $oldValues = $financialTransaction->toArray();
        $financialTransaction->update([
            'status' => 'rejected',
            'approved_at' => null,
            'approved_by' => null,
            'rejection_reason' => $request->rejection_reason,
        ]);
        FinancialAuditLog::log('rejected', $financialTransaction, $oldValues, $financialTransaction->toArray());

        return back()->with('success', 'تم رفض الحركة المالية.');
    }

    public function markCompleted(FinancialTransaction $financialTransaction)
    {
        if ($financialTransaction->status !== 'approved') {
            return back()->with('error', 'يجب اعتماد الحركة أولاً.');
        }

        $oldValues = $financialTransaction->toArray();
        $financialTransaction->update(['status' => 'completed']);
        FinancialAuditLog::log('completed', $financialTransaction, $oldValues, $financialTransaction->toArray());

        return back()->with('success', 'تم تسجيل الحركة كمكتملة.');
    }
}
