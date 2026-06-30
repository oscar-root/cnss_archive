<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archive extends Model
{
    protected $fillable = ['intitule', 'projet', 'date_projet', 'fichier_path', 'status', 'user_id', 'commentaires_chef'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}