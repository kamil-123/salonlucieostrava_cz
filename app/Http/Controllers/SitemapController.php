<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function sitemap(Request $request): Response
    {
        $urls = [];

        $hostName = $request->getSchemeAndHttpHost();

        $urls[] = ['loc' => URL::route('mainPage')];
        $urls[] = ['loc' => URL::route('saloon')];
//        dd($urls);
        $response = new Response( view('sitemap/sitemap', compact(['urls'])),200);
        $response->header('Content-Type', 'text/xml;charset=utf-8');
        return $response;
    }


}
