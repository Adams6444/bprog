<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zad_1_ceny extends Model
{
    use HasFactory;

    protected $table = "zad_1_ceny";

    protected $fillable = [
        'product_id',
        'value',
        'type',
    ];
}
