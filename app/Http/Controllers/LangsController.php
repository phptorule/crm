<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangsController extends Controller
{
    public function get()
    {
        $locale = app()->getLocale();
        $path = base_path('resources/lang/').$locale.'.json';

        if (file_exists($path))
        {
            return json_decode(file_get_contents($path), TRUE);
        }

        return [];
    }
}
