<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmazonPlanVente extends Model
{
    use HasFactory;
    protected $table = 'amazon_plan_ventes';

    protected $fillable = [
        'name',
        'details',
        'montant',
        'created_at',
        'updated_at',
    ];
}
