<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmazonPlanVente extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'forfait',
        'created_at',
        'updated_at',
    ];
}
