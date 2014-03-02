<?php

namespace SQLBoss\Cache\Adapter;

use SQLBoss\Cache\Cacher;
use \Cache;

class CakePhp implements Cacher
{
    public function read($cache_key)
    {
        return Cache::read($cache_key);
    }

    public function write($cache_key, $data)
    {
        return Cache::write($cache_key, $data);
    }

    public function delete($cache_key)
    {
        return Cache::delete($cache_key);
    }
}
