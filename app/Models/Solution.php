<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'problem_category',
        'solution_description',
        'technical_steps',
        'prevention_tips',
        'is_active',
        'usage_count',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function complaints()
    {
        return $this->belongsToMany(Complaint::class, 'complaint_solution')
                    ->withTimestamps();
    }

    // Helper methods
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }
}