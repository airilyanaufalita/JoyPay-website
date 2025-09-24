<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Kloter;
use App\Models\Admin;
use App\Models\KloterUser; // Tambah import untuk pivot model

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'address',
        'phone',
        'emergency_phone',
        'social_media',
        'bank',
        'account_number',
        'password',
        'role_id', // tambahin role
        'status',
        'type',
    'status',
    'approved_by',
    'approved_at',
    'rejected_by', 
    'rejected_at',
    'rejection_reason',
    'improvement_suggestion',
        'improvement_suggestion',
        'notes',
        'occupation',
        'income',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // Relasi ke role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relasi ke kloter (many-to-many) - Updated untuk match migration & model pivot
    public function kloters()
    {
        return $this->belongsToMany(Kloter::class, 'kloter_users')
                    ->using(KloterUser::class)
                    ->withPivot('slot', 'join_status', 'harga_bayar', 'joined_at') // Updated pivot fields
                    ->withTimestamps()
                    ->orderBy('kloter_users.joined_at', 'desc'); // Urut terbaru
    }

    // Relasi alternatif: Ke pivot langsung untuk detail membership
    public function kloterMemberships()
    {
        return $this->hasMany(KloterUser::class, 'user_id');
    }

    // Relationship untuk admin yang meng-approve
    public function approvedBy()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    // Relationship untuk admin yang me-reject
    public function rejectedBy()
    {
        return $this->belongsTo(Admin::class, 'rejected_by');
    }

    // Accessor untuk mendapatkan reviewer (admin yang mereview)
    public function getReviewerAttribute()
    {
        if ($this->approved_by) {
            return $this->approvedBy;
        } elseif ($this->rejected_by) {
            return $this->rejectedBy;
        }
        return null;
    }

    // Scope untuk filter status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Scope untuk filter berdasarkan type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\Auth\CustomResetPassword($token));
    }
}