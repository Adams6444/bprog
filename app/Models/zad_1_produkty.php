<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\zad_1_ceny;

class zad_1_produkty extends Model
{
    use HasFactory;

    protected $table = "zad_1_produkty";

    protected $fillable = [
        'name',
    ];

    public function getPrices()
    {
        return $this->hasMany(zad_1_ceny::class, 'product_id', 'id');
    }
}
