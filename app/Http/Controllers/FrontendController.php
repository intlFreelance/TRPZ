<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FrontendController extends Controller
{
    public function index()
    {
      return view('frontend.home');
    }

    public function about()
    {
      return view('frontend.about');
    }
}
