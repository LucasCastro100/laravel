<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeService extends Model
{
    use HasFactory, HasUuids;

    protected $servicesArray;

    protected $fillable = [
        'type_service'
    ];

    protected $casts = [
        'connected_type_services' => 'array',
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function clients(){
        return $this->hasMany(Client::class);
    }

    public function getAll(){
        $this->servicesArray = [];

        $services = TypeService::orderBy('type_service', 'asc')->get();

        foreach($services as $service) {
            $this->servicesArray[] = [
                'value' => $service->id, 
                'name' => $service->type_service
            ];
        }

        return $this->servicesArray;
    }
}