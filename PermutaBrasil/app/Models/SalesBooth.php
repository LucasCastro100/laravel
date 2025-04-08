<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesBooth extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    } 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
