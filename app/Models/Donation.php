<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    protected $fillable = [
        'donor_name',
        'donor_email',
        'donor_phone',
        'donor_type',
        'amount',
        'currency',
        'donation_method',
        'donation_date',
        'reference_number',
        'purpose',
        'purpose_id',
        'notes',
        'status',
        'reviewed_at',
        'reviewed_by',
        'rejection_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'donation_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public static function donorTypes(): array
    {
        return [
            'individual' => 'فرد',
            'institution' => 'مؤسسة',
            'anonymous' => 'مجهول',
        ];
    }

    public static function donationMethods(): array
    {
        return [
            'bank_transfer' => 'تحويل بنكي',
            'cash' => 'نقدي',
            'card' => 'بطاقة',
            'electronic' => 'منصة إلكترونية',
            'other' => 'أخرى',
        ];
    }

    public static function purposes(): array
    {
        return [
            'general' => 'عام',
            'scholarship' => 'منحة محددة',
            'project' => 'مشروع محدد',
            'tribute' => 'تكريم',
        ];
    }

    public static function statuses(): array
    {
        return [
            'pending' => 'قيد الانتظار',
            'approved' => 'معتمد',
            'rejected' => 'مرفوض',
            'refunded' => 'مسترد',
        ];
    }
}
