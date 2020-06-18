<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $primaryKey = 'result_id';

    // public function details(){
    //     return $this->hasMany('App\Detail', 'result_id');
    // }

    public function create_result($user_id, $sum){
        $this->user_id = $user_id;
        $this->sum = $sum;
        return $this->save();
    }

}
