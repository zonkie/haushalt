<?php
namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;

class MeterlistController
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
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index() {
        $locations = DB::select('select * from locations where active = ?', [ 1 ]);
        foreach ($locations AS &$location) {
            $location->meters = DB::select('select * from meters where location = ? AND active = ?', [ $location->id, 1 ]);
        }

        return view('meters.list', [ 'locations' => $locations ]);
    }

    public function meter($meter_id) {
        $meter = DB::select('select * from meters where location = ?' , [ $meter_id ]);
        $values = DB::select('select * from meter_values where meter = ?', [ $meter_id ]);

        $beforeValue  = null;
        $begin_date   = null;
        $end_date     = null;
        $days_total   = 0;
        $aGraphValues = array(
            'total'         => array(),
            'diff'          => array(),
            'diffPerPerson' => array(),
        );
        foreach ($values AS &$value) {
            if (is_null($begin_date)) {
                $begin_date = new \DateTime($value->read_date);
            }

            $read_date  = new \DateTime($value->read_date);
            $interval   = ( ! is_null($end_date) ? $end_date->diff($read_date)->format('%a') : 0 );
            $days_total = $days_total + $interval;

            $value->days = $days_total;

            $end_date = new \DateTime($value->read_date);

            if (! is_null($beforeValue)) {
                $value->diff          = ( $value->value - $beforeValue );
                $value->diffPerPerson = ( $value->diff / $value->persons );
                $value->diffPerDay          = ($value->diff / $interval); //number_format(...,3,',','');
                $value->diffPerPersonPerDay = ($value->diffPerDay / $interval); //number_format(...,3,',','');
            } else {
                $value->diff                = 0;
                $value->diffPerPerson       = 0;
                $value->diffPerDay          = 0;
                $value->diffPerPersonPerDay = 0;
            }

            $beforeValue                                   = $value->value;
            $aGraphValues['total'][ strtotime($read_date->format('Y-m-d')) ]         = $value->value;
            $aGraphValues['diff'][ strtotime($read_date->format('Y-m-d')) ]          = $value->diff;
            $aGraphValues['diffPerPerson'][ strtotime($read_date->format('Y-m-d')) ] = $value->diffPerPerson;
            $aGraphValues['diffPerDay'][ strtotime($read_date->format('Y-m-d')) ]          = $value->diffPerDay;
            $aGraphValues['diffPerPersonPerDay'][ strtotime($read_date->format('Y-m-d')) ] = $value->diffPerPersonPerDay;
        }

        return view('meters.detail', [ 'meter'=> $meter, 'metervalues' => $values, 'startDate' => $begin_date, 'endDate' => $end_date, 'graphValues' => $aGraphValues ]);

    }

}
