<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Student extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'registration'
    ];

    protected static function booted()
    {
        static::creating(function ($student) {
            do {
                $registration = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            } while (self::where('registration', $registration)->exists());

            $student->registration = $registration;
        });
    }

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
