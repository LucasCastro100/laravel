<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Connection extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'connected_user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function connectedUser()
    {
        return $this->belongsTo(User::class, 'connected_user_id');
    }

    public function connectedClient()
    {
        return $this->hasOneThrough(Client::class, User::class, 'id', 'user_id', 'connected_user_id', 'id');
    }

    public function createConnection()
    {
        $chek = true;
        $user = Auth::user();

        $limits = [
            0 => 5,
            1 => 15,
            2 => 100,
            3 => 1000
        ];

        $maxConnections = $limits[$user->role->value] ?? 0;

        $currentUniqueConnections = Connection::where('user_id', $user->id)
            ->distinct()
            ->pluck('connected_user_id')
            ->count();

        if ($currentUniqueConnections >= $maxConnections) {
            $chek = false;
        }

        $remainingConnections = $maxConnections - $currentUniqueConnections;

        $messageRemaining = "Você ainda tem {$remainingConnections} usuários para fazer Negócios!";
        $messageLimit = "Você pode ter no máximo {$maxConnections} usuários conectados.";

        return [
            'remaining' => $messageRemaining,
            'limit' => $messageLimit,
            'check' => $chek,
        ];
    }

    public function allConections()
    {
        $currentUniqueConnections = Connection::distinct()
            ->pluck('connected_user_id')
            ->count();

        return $currentUniqueConnections;
    }

    public function usersConections()
    {
        $currentUsersConnections = Connection::with(['user', 'connectedUser', 'connectedClient'])        
        ->orderBy('user_id')
        ->get();

        $uniqueConnections = $currentUsersConnections->unique(function ($item) {
            return $item->user_id . '-' . $item->connected_user_id;
        });

        $groupedConnections = $uniqueConnections->groupBy('user_id');

        $groupedConnections->each(function ($connections, $userID) {
            $client = Client::where('user_id', $userID)->first();
    
            if ($client) {
                $connections->first()->client_name = $client->name;
            }
        });

        return $groupedConnections;
    }
}
