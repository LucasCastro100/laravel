<?php

namespace App\Models;

use App\Enums\SignatureStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'signature_id',
        'last_update_at',
        'last_plan_id',
        'last_status'
    ];

    protected $casts = [
        'last_status' => SignatureStatus::class
    ];

    public function signature(){
        return $this->belongsTo(Signature::class);
    }
}
