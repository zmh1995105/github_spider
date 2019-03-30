<?php
namespace App\Handlers\Rules;

use Illuminate\Support\Facades\Request;

class SubdomainMatch
{

    public function match($store)
    {
        $hostname = Request::server('SERVER_NAME');

        $host = explode('.', $hostname);

        if(isset($host[count($host) - 3])){

            $subdomain = $host[count($host) - 3];

            return $store->whereHas('config', function ($q) use ($subdomain){

                $q->where('key', '=', 'subdomain');

                $q->where('value', '=', $subdomain);

            })->first();
        }

        return false;
    }

}