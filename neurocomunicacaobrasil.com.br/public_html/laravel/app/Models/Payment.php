<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'user_id',
        'course_id',
        'amount',
        'currency',
        'status',
        'installments',
    ];

    protected $casts = [
        'installments' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
