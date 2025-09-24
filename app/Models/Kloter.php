<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kloter extends Model
{
    use HasFactory;

    protected $table = 'kloters';  // Tabel DB: kloters (plural)

    protected $fillable = [
        'name', 'description', 'category', 'nominal', 'duration_value', 'duration_unit',
        'total_slots', 'filled_slots', 'admin_fee_percentage', 'admin_fee_amount',
        'status', 'payment_schedule', 'draw_schedule', 'start_date', 'current_period',
        'manager_name', 'payment_method'
    ];

    protected $casts = [
        'start_date' => 'date',
        'nominal' => 'decimal:2',
        'admin_fee_percentage' => 'decimal:2',
        'admin_fee_amount' => 'decimal:2',
        'current_period' => 'integer',
        'total_slots' => 'integer',
        'filled_slots' => 'integer',
        'duration_value' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessors untuk progress
    public function getProgressPercentageAttribute()
    {
        $total = max((int) $this->total_slots, 1);
        $current = (int) $this->current_period;
        $filled = (int) $this->filled_slots;

        $percentage = $this->status === 'running' 
            ? ($current / $total) * 100 
            : ($filled / $total) * 100;

        return round($percentage);
    }

    public function getProgressLabelAttribute()
    {
        $total = max((int) $this->total_slots, 1);
        if ($this->status === 'running') {
            return $this->current_period . '/' . $total;
        }
        return round($this->progress_percentage) . '%';
    }

    public function getIsRunningAttribute()
    {
        return $this->status === 'running';
    }

    /**
     * Relationship to KloterRule
     */
    public function rules(): HasMany
    {
        return $this->hasMany(KloterRule::class, 'kloter_id');
    }

    /**
     * Relationship to KloterMember
     */
    public function members(): HasMany
    {
        return $this->hasMany(KloterMember::class, 'kloter_id');
    }

    /**
     * Relationship to User through KloterMember
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'kloter_members', 'kloter_id', 'user_id')
                    ->withPivot('joined_at', 'status')
                    ->withTimestamps();
    }

    /**
     * Relationship to KloterMemberRequest (permintaan bergabung)
     */
    public function requests(): HasMany
    {
        return $this->hasMany(KloterMemberRequest::class, 'kloter_id');
    }
}