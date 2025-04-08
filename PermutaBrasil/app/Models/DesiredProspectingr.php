<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesiredProspectingr extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'client_id',
        'prospecting',
        'company'
    ];
    
    public $timestamps = true;

    /**
     * Relacionamento com o usuário.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
