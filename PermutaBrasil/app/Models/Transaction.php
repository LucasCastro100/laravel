<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'total_price',
        'signature_id',
        'status'
    ];

    protected $casts = [
        'status' => TransactionStatus::class
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }   

    public function signature(){
        return $this->belongsTo(Signature::class);
    }
}
