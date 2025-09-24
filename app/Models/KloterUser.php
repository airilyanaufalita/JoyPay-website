<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KloterUser extends Pivot
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory; // Tambah factory jika perlu

    protected $table = 'kloter_users';

    protected $fillable = [
        'kloter_id',
        'user_id',
        'slot',
        'join_status',
        'harga_bayar',
        'joined_at'
    ];

    protected $casts = [
        'harga_bayar' => 'decimal:2',
        'joined_at' => 'datetime',
    ];

    // Relasi ke Kloter
    public function kloter(): BelongsTo
    {
        return $this->belongsTo(Kloter::class);
    }

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}