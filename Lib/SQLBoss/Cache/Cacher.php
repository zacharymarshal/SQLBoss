<?php

namespace SQLBoss\Cache;

interface Cacher
{
    public function read($cache_key);
    public function write($cache_key, $data);
    public function delete($cache_key);
}
