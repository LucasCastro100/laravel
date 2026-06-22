<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientAccount extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'plan_id',
        'description',
        'value',
        'due_date',
        'paid_date',
        'paid',
        'category',
        'notes',
        'month',
        'year',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'paid' => 'boolean',
            'due_date' => 'date',
            'paid_date' => 'date',
            'cancelled_at' => 'datetime',
            'value' => 'decimal:2',
        ];
    }

    public function scopeActive($query)
    {
        return $query->whereNull('cancelled_at');
    }

    public function scopePending($query)
    {
        return $query->whereNull('cancelled_at')->where('paid', false);
    }

    public function scopePaid($query)
    {
        return $query->whereNull('cancelled_at')->where('paid', true);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
