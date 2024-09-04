<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function coutactUs(){
        return view('contact');
    }

    public function privacyPolicy(){
        return view('privacy-policy');
    }

}