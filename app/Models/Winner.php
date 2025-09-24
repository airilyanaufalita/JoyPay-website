<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pemenang',
        'email_pemenang',
        'no_telepon',
        'kloter_name',
        'periode',
        'jumlah_hadiah',
        'tanggal_undian',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_undian' => 'date',
        'jumlah_hadiah' => 'decimal:2'
    ];

    public function getFormattedHadiahAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_hadiah, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="status-badge pending">Menunggu</span>',
            'confirmed' => '<span class="status-badge confirmed">Dikonfirmasi</span>',
            'paid' => '<span class="status-badge paid">Dibayar</span>'
        ];

        return $badges[$this->status] ?? '<span class="status-badge">Unknown</span>';
    }
}