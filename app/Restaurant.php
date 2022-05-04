<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use RestaurantImage;
class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'description',
        'created_at',
        'updated_at',
    ];

    // public function getImage()
    // {
    //     return $this->belongsTo('App\RestaurantImage');
    // }
    public function getImage()
    {
        return $this->hasOne('App\RestaurantImage');
    }
}
