<?php
namespace App\Handlers\Rules;

use Illuminate\Support\Facades\Request;

class DomainMatch
{

    public function match($store)
    {
        return $store->whereHas('config', function($q){

            $hostname = Request::server('SERVER_NAME');

            $q->where('key', '=', 'url');

            $q->where('value', '=', $hostname);

        })->first();
    }

}