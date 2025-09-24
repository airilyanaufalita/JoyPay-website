<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KloterMemberRequest extends Model
{
    use HasFactory;

    protected $table = 'kloter_member_requests';

    protected $fillable = [
        'kloter_id',
        'user_id',
        'slot_number',
        'monthly_payment',
        'status',
        'rejection_note',
        'joined_at',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'verified_at' => 'datetime',
        'slot_number' => 'integer',
        'monthly_payment' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * Relationship to Kloter
     */
    public function kloter(): BelongsTo
    {
        return $this->belongsTo(Kloter::class, 'kloter_id');
    }

    /**
     * Relationship to User (requestor)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship to Admin who verified (adjust based on your admin table)
     * If using separate Admin model, change to BelongsTo(Admin::class, 'verified_by')
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by')->withDefault(['name' => 'Unknown Admin']);
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-warning',
            self::STATUS_APPROVED => 'bg-success',
            self::STATUS_REJECTED => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Verifikasi',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_REJECTED => 'Ditolak',
            default => 'Status Tidak Diketahui'
        };
    }

    /**
     * Get formatted monthly payment
     */
    public function getFormattedMonthlyPaymentAttribute(): string
    {
        return 'Rp ' . number_format($this->monthly_payment, 0, ',', '.');
    }

    /**
     * Check if request is still pending
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if request was approved
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if request was rejected
     */
    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Scope to get only pending requests
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope to get requests by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get requests for specific kloter
     */
    public function scopeForKloter($query, $kloterId)
    {
        return $query->where('kloter_id', $kloterId);
    }

    /**
     * Approve the request (to be called by admin)
     */
    public function approve($adminId)
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'verified_at' => now(),
            'verified_by' => $adminId
        ]);

        // Optional: Move to KloterMember if using separate table
        // $this->kloter->members()->create([
        //     'user_id' => $this->user_id,
        //     'slot_number' => $this->slot_number,
        //     'monthly_payment' => $this->monthly_payment,
        //     'status' => 'active'
        // ]);

        return $this;
    }

    /**
     * Reject the request (to be called by admin)
     */
    public function reject($rejectionNote = null)
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'rejection_note' => $rejectionNote,
            'verified_at' => now()
        ]);

        return $this;
    }
}