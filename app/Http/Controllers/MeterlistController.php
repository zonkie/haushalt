<?php
    namespace App\Http\Controllers;

    use DB;
    use App\Http\Controllers\Controller;

    class MeterlistController extends Controller
    {

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
        public function __construct()
        {
            //$this->middleware('auth');
        }

        /**
         * Show the application dashboard to the user.
         *
         * @return Response
         */
        public function index()
        {   $locations = DB::select('select * from locations where active = ?', [1]);
            foreach($locations AS &$location){

                $location->meters = DB::select('select * from meters where location = '. $location->id .' AND active = ?', [1]);
            }
            return view('meters.list', ['locations' => $locations]);
        }

        public function meter($meter_id){

            $values = DB::select('select * from meter_values where meter = ?', [$meter_id]);

            $beforeValue = null ;
            $begin_date = null;
            $end_Date = null;

            foreach($values AS &$value){
                if(is_null($begin_date)){
                    $begin_date = date("Y-m-d",strtotime($value->read_date));
                }

                $end_date = date("Y-m-d",strtotime($value->read_date));
                $value->read_date = date("Y-m-d",strtotime($value->read_date));
                if(!is_null($beforeValue)){
                    $value->diff = ($value->value - $beforeValue);
                    $value->diffPerPerson = ($value->diff / $value->persons);
                } else {
                    $value->diff = 0;
                    $value->diffPerPerson = 0;
                }
                $beforeValue = $value->value;
            }

            return view('meters.detail', ['metervalues' => $values, 'startDate' => $begin_date, 'endDate' =>$end_Date]);
            
        }

    }
