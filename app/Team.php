<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = 
        [
            'id',
            'name',
            'shortName',
            'tla',
            'crestUrl',
            'address',
            'phone',
            'website',
            'email',
            'founded',
            'clubColors',
            'venue',
            'lastUpdated'
        ];
}