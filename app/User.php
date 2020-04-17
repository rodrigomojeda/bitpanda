<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\UserDetail;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','active'
    ];


    public function details(){
        return $this->hasMany(UserDetail::class, 'user_id', 'id');

    }
}
