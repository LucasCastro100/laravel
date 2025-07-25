<?php

namespace App\Models;

use App\Enums\SignatureStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signature extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'client_id',
        'plan_id',
        'status'
    ];

    protected $casts = [
        'status' => SignatureStatus::class
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }  

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function signatureHistory(){
        return $this->hasMany(SignatureHistory::class);
    }
}
