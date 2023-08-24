<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmazonCategorieProduit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'frais_vente_min',
        'frais_vente_max',
        'frais_cloture',
        'frais_expedition',
        'frais_stockage',
        'frais_traitement_retour',
    ];
}
