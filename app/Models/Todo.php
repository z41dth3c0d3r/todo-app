<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $primaryKey = "id";

    protected $guarded = [];

    protected $casts = [
        'expireAt' => 'datetime',
        'completedAt' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
