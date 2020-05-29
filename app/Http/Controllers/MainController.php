<?php

namespace App\Http\Controllers;

use App\Stylist;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function mainPage()
    {
        return view('main/main');
    }

    public function saloon()
    {
        $stylists = Stylist::orderBy('id', 'asc')
                        ->with('user')
                        ->with('treatments')
                        ->get();
        return view('main/saloon', compact('stylists'));
    }
}
