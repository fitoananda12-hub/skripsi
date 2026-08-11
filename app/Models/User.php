<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nik',
        'jabatan',
        'departemen',
        'phone',
        'address',
        'password',
        'role',
        'is_active',
        'registration_status',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at'       => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // Relasi
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function assignedComplaints()
    {
        return $this->hasMany(Complaint::class, 'assigned_to');
    }

    public function solutions()
    {
        return $this->hasMany(Solution::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helper methods - Role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    // Helper methods - Registration Status
    public function isPending()
    {
        return $this->registration_status === 'pending';
    }

    public function isApproved()
    {
        return $this->registration_status === 'approved';
    }

    public function isRejected()
    {
        return $this->registration_status === 'rejected';
    }
}