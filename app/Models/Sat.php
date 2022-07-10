<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sat extends Model
{
    use HasFactory;

    protected $fillable = [
        'brend',
        'model',
        'slika',
        'cena',
        'pol',
        'narukvica',
        'mehanizam',
        'garancija',
    ];

    protected $table = 'sats';
}
