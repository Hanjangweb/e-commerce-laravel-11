<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookiesController extends Controller
{
    //Set
    public function setCookie()
    {
        //create a cookie with a lifetime of 60min
        Cookie::queue(Cookie::make('preferred-language','en','60'));

        return response("Cookie has been set");
    }

    //get
    public function getCookie()
    {
        //retrieve the cookie value
        $value = Cookie::get("preferred_language");

        return response("preferred_language is: {$value}");
    }

    //delete
    public function deleteCookie()
    {
        //forget the cookie
        Cookie::queue(Cookie::forget("preferred_language"));

        return response("Cookie Has been deleted.");
    }
}


