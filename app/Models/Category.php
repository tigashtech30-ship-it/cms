<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'code', 'description', 'is_active', 'branch_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}