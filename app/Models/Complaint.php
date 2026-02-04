<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'complaint_number',
        'product_name',
        'problem_type',
        'description',
        'photo',
        'incident_date',
        'status',
        'priority',
        'assigned_to',
        'admin_response',
        'resolved_at',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'resolved_at' => 'datetime',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function solutions()
    {
        return $this->belongsToMany(Solution::class, 'complaint_solution')
                    ->withTimestamps();
    }

    // Helper methods
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'submitted' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPriorityBadgeClass()
    {
        return match($this->priority) {
            'low' => 'bg-green-100 text-green-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'submitted' => 'Diajukan',
            'in_progress' => 'Diproses',
            'resolved' => 'Selesai',
            'closed' => 'Ditutup',
            default => 'Unknown',
        };
    }

    public function getPriorityLabel()
    {
        return match($this->priority) {
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            default => 'Unknown',
        };
    }

    // Generate complaint number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($complaint) {
            if (!$complaint->complaint_number) {
                $complaint->complaint_number = 'CPL-' . date('Ymd') . '-' . str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}