<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memo
{
    //
    public static function generateNewMemoCode($table, $col, $chars = 20){
        $unique = false;
        $tested = [];
        do{
            $random = str_random($chars);
            if( in_array($random, $tested) ){
                continue;
            }
            $count = \DB::table($table)->where($col, '=', $random)->count();
            $tested[] = $random;
            if( $count == 0){
                $unique = true;
            }
        }
        while(!$unique);
        return $random;
    }
}
