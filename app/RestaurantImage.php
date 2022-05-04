<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantImage extends Model
{
    //
    public function Restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
