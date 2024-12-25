<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations{

    public static function decryptId($value){

        try {
            $value = Crypt::decrypt($value);
        } catch (DecryptException $er) {
            
            return null;
        }

        return $value;

    }
}