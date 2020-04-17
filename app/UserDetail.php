<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    public $table='user_details';

    protected $fillable = [
       'user_id','citizenship_country_id','first_name','last_name','phone_number'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function country(){
        return $this->belongsTo('App\Country', 'citizenship_country_id');
    }


}
