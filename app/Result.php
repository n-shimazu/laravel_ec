<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $primaryKey = 'result_id';


    public static function create_result($user_id, $sum){
    $result = new Result;

        $result->user_id = $user_id;
        $result->sum = $sum;
        $result->save();
        return $result;
    }

}
