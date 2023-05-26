<?php

namespace App\Http\Controllers;

use App\Models\Hit;
use App\Models\Link;
use Illuminate\Http\Request;

class SpaController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return view('spa');
    }

    public function show(Link $link)
    {
        $hit = new Hit;
        $hit->ip = $this->request->ip();
        $hit->user_agent = $this->request->userAgent();
        $link->hits()->save($hit);

        $link->increment('views');

        return redirect()->to($link->url);
    }
}
