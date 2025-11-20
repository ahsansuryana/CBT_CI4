<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class GlobalStore extends BaseController
{
    private static $data = [];

    public static function set($key, $value)
    {
        self::$data[$key] = $value;
    }

    public static function get($key)
    {
        return self::$data[$key] ?? null;
    }
    public function index()
    {
        //
    }
}
