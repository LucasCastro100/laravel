<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $statesArray;

    protected $fillable = [
        'state',  // Nome do estado
        'uf',     // Sigla do estado
    ];
  
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function getAll(){
        $this->statesArray = [];

        $states = State::all();

        foreach($states as $state) {
            $this->statesArray[] = [
                'value' => $state->id, 
                'name' => $state->state
            ];
        }

        return $this->statesArray;
    }
}
