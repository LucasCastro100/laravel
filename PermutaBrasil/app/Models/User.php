<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'role',
        'actived',
        'email_change_token',
        'access_time',
        'access_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'role' => RoleStatus::class,
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];

    public function isAdmin(): bool
    {
        return $this->role === RoleStatus::ADMIN->value;
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function controlExchangesAsProvider()
    {
        return $this->hasMany(Extract::class, 'service_provider_id');
    }

    public function controlExchangesAsTaker()
    {
        return $this->hasMany(Extract::class, 'service_taker_id');
    }

    public function connections()
    {
        return $this->belongsToMany(User::class, 'connections', 'user_id', 'connected_user_id');
    }
    
    public function connectedBy()
    {
        return $this->belongsToMany(User::class, 'connections', 'connected_user_id', 'user_id');
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'message_user')
                    ->withPivot('deleted_at') // Inclui o campo 'deleted_at' da tabela intermediária
                    ->withTimestamps();
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }
}
