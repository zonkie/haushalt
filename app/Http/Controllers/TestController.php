<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;

use App\Meter;

class TestController
    extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Tutorial Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */ 
    public function index()
    {

        $meters = Meter::get();

        foreach ($meters AS $meter) {
            echo $meter->name;
            echo "<br />";
        }
         exit( "huargh! " . __FILE__ . ':' . __LINE__ );

        return view('');
    }

}

