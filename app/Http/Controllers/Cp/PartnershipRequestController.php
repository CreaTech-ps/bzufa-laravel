<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\PartnershipRequest;
use Illuminate\Http\Request;

class PartnershipRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnershipRequest::query()->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('company_name', 'like', "%{$q}%")
                    ->orWhere('contact_name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%");
            });
        }

        $requests = $query->paginate(15)->withQueryString();

        return view('cp.partnership-requests.index', compact('requests'));
    }

    public function edit(PartnershipRequest $partnership_request)
    {
        return view('cp.partnership-requests.edit', compact('partnership_request'));
    }

    public function update(Request $request, PartnershipRequest $partnership_request)
    {
        $request->validate([
            'status' => ['required', 'in:pending,under_review,approved,rejected'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $partnership_request->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('cp.partnership-requests.index')->with('success', 'تم تحديث حالة الطلب.');
    }
}
