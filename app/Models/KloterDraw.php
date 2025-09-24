<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KloterDraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'kloter_id', 'winner_member_id', 'period', 'draw_date', 
        'total_collected', 'admin_fee_deducted', 'winner_payout', 
        'draw_method', 'is_paid_out', 'payout_date', 'notes'
    ];

    protected $casts = [
        'draw_date' => 'date',
        'payout_date' => 'date',
        'is_paid_out' => 'boolean',
        'total_collected' => 'decimal:2',
        'admin_fee_deducted' => 'decimal:2',
        'winner_payout' => 'decimal:2'
    ];

    public function kloter()
    {
        return $this->belongsTo(Kloter::class);
    }

    public function winner()
    {
        return $this->belongsTo(KloterMember::class, 'winner_member_id');
    }
}
