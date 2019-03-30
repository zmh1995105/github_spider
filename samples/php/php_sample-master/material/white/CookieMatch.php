<?php
namespace App\Handlers\Rules;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class CookieMatch
{

    public function match($store)
    {
        $cookie = Cookie::get('store');

        if($cookie && $store_id = Crypt::decrypt($cookie)){

            return $store->find($store_id);

        }

        return false;
    }

}