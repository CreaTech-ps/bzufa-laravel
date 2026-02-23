<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialTransaction extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'currency',
        'transaction_date',
        'beneficiary_name',
        'beneficiary_type',
        'purpose',
        'reference_type',
        'reference_id',
        'payment_method',
        'bank_reference',
        'status',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function types(): array
    {
        return [
            'expense' => 'مصروف',
            'transfer' => 'تحويل',
            'grant_payment' => 'صرف منحة',
            'project_funding' => 'تمويل مشروع',
        ];
    }

    public static function beneficiaryTypes(): array
    {
        return [
            'student' => 'طالب',
            'institution' => 'مؤسسة',
            'project' => 'مشروع',
            'other' => 'آخر',
        ];
    }

    public static function paymentMethods(): array
    {
        return [
            'bank_transfer' => 'تحويل بنكي',
            'cheque' => 'شيك',
            'cash' => 'نقدي',
        ];
    }

    public static function statuses(): array
    {
        return [
            'draft' => 'مسودة',
            'pending_review' => 'بانتظار المراجعة',
            'approved' => 'معتمد',
            'rejected' => 'مرفوض',
            'completed' => 'مكتمل',
        ];
    }
}
