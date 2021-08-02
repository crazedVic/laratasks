<?php

namespace App\Models;

use App\Traits\HasProcess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    use HasProcess;

    public $guarded = [];

    //user task belongs to
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
