<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('feedback');
    }

    public function submit(Request $request)
    {
        // validate content

        // save to db

        var_dump($request->input('category'));
        var_dump($request->input('feedback'));
        var_dump($request->input('email'));
        var_dump($request->input('anonymous'));
    }
}
