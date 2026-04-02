<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    public function home()
    {
        $packages = DB::table('pricing_packages')->orderBy('price', 'asc')->get();
        return view('home', [
            'packages' => $packages,
            'laravelVersion' => \Illuminate\Foundation\Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function docs()
    {
        return view('docs');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }
}
