<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KloterMember extends Model
{
    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';

    // Payment status constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_VERIFIED = 'verified';
    const PAYMENT_PAID = 'paid';

    protected $table = 'kloter_members';
    
    protected $fillable = [
        'kloter_id',
        'user_id',
        'slot_number',
        'monthly_payment',
        'joined_at',
        'status',
        'payment_status',
        'total_paid',
        'verified_at',
        'verified_by',
        'rejection_note'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'verified_at' => 'datetime',
        'slot_number' => 'integer',
        'monthly_payment' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'status' => 'string',
        'payment_status' => 'string'
    ];

    public $timestamps = true;

    /**
     * Relationship to Kloter
     */
    public function kloter(): BelongsTo
    {
        return $this->belongsTo(Kloter::class, 'kloter_id');
    }

    /**
     * Relationship to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship to Admin (verifier)
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'status-pending',
            'approved' => 'status-approved', 
            'rejected' => 'status-rejected',
            'active' => 'status-active',
            'completed' => 'status-completed',
            default => 'status-pending'
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get payment status label
     */
    public function getPaymentStatusLabelAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'Menunggu Pembayaran',
            'verified' => 'Terverifikasi',
            'paid' => 'Lunas',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Scope untuk pending members
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope untuk approved members
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope untuk rejected members
     */
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }
}