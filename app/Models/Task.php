<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Volunteer;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
}
