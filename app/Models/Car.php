<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [ 'nazwa', 
                            'rejestracja', 
                            'stan_licznika', 
                            'marka', 
                            'model', 
                            'kolor', 
                            'stan_licznika_wymiana_oleju',
                            'ostatni_przeglad_data' ];
}
