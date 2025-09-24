<?php

// app/Models/KloterPayment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KloterPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'kloter_id', 'member_id', 'period', 'amount', 'admin_fee', 
        'total_amount', 'payment_date', 'due_date', 'status', 
        'payment_proof', 'verified_at', 'verified_by'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'due_date' => 'date',
        'verified_at' => 'datetime',
        'amount' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    public function kloter()
    {
        return $this->belongsTo(Kloter::class);
    }

    public function member()
    {
        return $this->belongsTo(KloterMember::class, 'member_id');
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getIsLateAttribute()
    {
        return $this->due_date < now() && $this->status === 'pending';
    }
}