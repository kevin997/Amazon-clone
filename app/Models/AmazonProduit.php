<?php

namespace App\Models;

use App\Models\AmazonCategorieProduit;
use App\Models\AmazonStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmazonProduit extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorie_produit_id',
        'store_id',
        'designation',
        'unite_emballage',
        'devise',
        'etat',
        'prix_unitaire',
        'prix_gros',
        'niveau_alerte',
        'seuil_recompletement',
        'created_at',
        'updated_at',
    ];

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie_produit():BelongsTo{
        return $this->BelongsTo(AmazonCategorieProduit::class);
    }

    public function store():BelongsTo{
        return $this->BelongsTo(AmazonStore::class);
    }
}
