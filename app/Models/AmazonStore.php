<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AmazonStore extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'nom',
        'adresse',
        'pays',
        'code_postal',
        'site_web',
        'logo',
        'localisation',
        'user_id',
        'etat',
        'cree_le',
        'modifie_le',
    ];

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user():BelongsTo{
        return $this->BelongsTo(User::class);
    }
}
