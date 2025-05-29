<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WakilKesiswaan extends Model
{
    use HasFactory;

    protected $table = 'wakil_kesiswaan';
    
    protected $fillable = [
        'user_id',
        'nip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}