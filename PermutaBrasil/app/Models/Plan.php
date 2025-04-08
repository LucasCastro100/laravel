<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'short_description',
        'price'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function signatures(){
        return $this->hasMany(Signature::class);
    }
}
