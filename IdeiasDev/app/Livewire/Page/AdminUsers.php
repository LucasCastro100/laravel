<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminUsers extends Component
{
    public $users;

    protected const ONLINE_THRESHOLD_SECONDS = 300;

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $lastActivityByUser = DB::table('sessions')
            ->whereNotNull('user_id')
            ->select('user_id', DB::raw('MAX(last_activity) as last_activity'))
            ->groupBy('user_id')
            ->pluck('last_activity', 'user_id');

        $onlineSince = now()->subSeconds(self::ONLINE_THRESHOLD_SECONDS)->timestamp;

        $this->users = User::with('role')
            ->orderBy('name')
            ->get()
            ->map(function ($user) use ($lastActivityByUser, $onlineSince) {
                $lastActivity = $lastActivityByUser->get($user->id);

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role?->label ?? '-',
                    'online' => $lastActivity !== null && $lastActivity >= $onlineSince,
                    'last_seen' => $lastActivity ? \Carbon\Carbon::createFromTimestamp($lastActivity)->diffForHumans() : null,
                ];
            });
    }

    public function render()
    {
        return view('livewire.page.admin.users')
            ->layout('layouts.app');
    }
}
