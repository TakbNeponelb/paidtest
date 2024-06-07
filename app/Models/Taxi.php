<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'key', 
        'price',
        'color_id',
    ];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
