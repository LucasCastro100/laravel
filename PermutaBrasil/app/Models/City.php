<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $citiesArray;

    protected $fillable = [
        'city',  
        'state_id',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function getAll(){
        $this->citiesArray = [];

        $cities = City::all();

        foreach($cities as $city) {
            $this->citiesArray[] = [                
                'name' => $city->city
            ];
        }

        return $this->citiesArray;
    }
}
