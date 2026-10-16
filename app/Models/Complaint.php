<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'tracking_number',
        'customer_id',
        'customer_name',
        'complaint_type',
        'title',
        'description',
        'status',
        'priority',
        'branch_id',
        'category_id',
        'created_by',
        'assigned_at',
        'admin_note',
        'attachment',
        'branch_attachment',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}