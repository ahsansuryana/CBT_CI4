<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Template extends BaseController
{
    public function index()
    {
        return view('layout/dashboard_template');
    }
}
