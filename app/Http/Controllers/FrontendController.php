<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;

class FrontendController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::all();
        return view('frontend.home', $data);
    }

    public function about()
    {
      return view('frontend.about');
    }
    
    public function category($id){
        $data['category'] = Category::find($id);
        return view('frontend.category', $data);
    }
}
