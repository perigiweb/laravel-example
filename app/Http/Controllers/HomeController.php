<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
         return view('welcome', [
            'pageTitle' => 'Home',
            'posts' => Post::orderBy('id', 'DESC')->limit(10)->get()
        ]);
    }
}
