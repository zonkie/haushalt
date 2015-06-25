<?php
namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Input;

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


        $meters    = DB::select('select * from meters where id = ?', [ $meter_id ]);
        $meter     = $meters[0];
        $locations = DB::select('select * from locations where id = ?', [ $meter->location ]);
        $location  = $locations[0];
        $values    = DB::select('select * from meter_values where meter = ? ORDER BY read_date ASC', [ $meter_id ]);

        if (isset( $_POST['value'] )) {
            $read_date = Input::get('read_date') . ' 00:00:00';
            //            $read_date_y = str_pad(Input::get('read_date_y'), 4,'0',STR_PAD_LEFT);
            //            $read_date_m = str_pad(Input::get('read_date_m'), 2,'0',STR_PAD_LEFT);
            //            $read_date_d = str_pad(Input::get('read_date_d'), 2,'0',STR_PAD_LEFT);
            //            $read_date = $read_date_y.'-'.$read_date_m.'-'.$read_date_d.' 00:00:00';

            $value = Input::get('value');

            $id = DB::table('meter_values')->insertGetId(
                    array(
                        'meter'     => $meter_id,
                        'value'     => $value,
                        'read_date' => $read_date,
                        'persons'   => $location->persons,
                    )
            );
        }

        $beforeValue = null;
        $begin_date  = null;
        $end_date    = null;
        $days_total  = 0;
        $max_value   = 0;

        $aGraphValues = array(
            'total'               => array(),
            'diff'                => array(),
            'diffPerPerson'       => array(),
            'diffPerDay'          => array(),
            'diffPerPersonPerDay' => array(),
        );
        foreach ($values AS &$value) {
            if (is_null($begin_date)) {
                $begin_date = new \DateTime( $value->read_date );
            }

            $read_date  = new \DateTime( $value->read_date );
            $interval   = ( !is_null($end_date) ? $end_date->diff($read_date)->format('%a') : 0 );
            $days_total = $days_total + $interval;

            $value->days = $days_total;
            $max_value   = $value->value;
            $end_date    = new \DateTime( $value->read_date );

            if (!is_null($beforeValue)) {
                $value->diff      = ( $value->value - $beforeValue );
                $value->diffPrice = $value->diff * $meter->price_per_unit;
                if ($value->persons > 0) {
                    $value->diffPerPerson      = ( $value->diff / $value->persons );
                    $value->diffPricePerPerson = $value->diffPerPerson * $meter->price_per_unit;
                } else {
                    $value->diffPerPerson = 0;
                }
                if ($interval > 0) {
                    $value->diffPerDay               = ( $value->diff / $interval ); //number_format(...,3,',','');
                    $value->diffPerPersonPerDay      = ( $value->diffPerDay / $interval ); //number_format(...,3,',','');
                    $value->diffPricePerDay          = $value->diffPerDay * $meter->price_per_unit;
                    $value->diffPricePerPersonPerDay = $value->diffPerPersonPerDay * $meter->price_per_unit;
                } else {
                    $value->diffPerDay               = 0;
                    $value->diffPerPersonPerDay      = 0;
                    $value->diffPricePerDay          = 0;
                    $value->diffPricePerPersonPerDay = 0;
                }
            } else {
                $value->diff                     = 0;
                $value->diffPerPerson            = 0;
                $value->diffPrice                = 0;
                $value->diffPricePerPerson       = 0;
                $value->diffPerDay               = 0;
                $value->diffPerPersonPerDay      = 0;
                $value->diffPricePerDay          = 0;
                $value->diffPricePerPersonPerDay = 0;
            }

            $beforeValue                                                                 = $value->value;
            $aGraphValues['total'][strtotime($read_date->format('Y-m-d'))]               = $value->value;
            $aGraphValues['diff'][strtotime($read_date->format('Y-m-d'))]                = $value->diff; //($value->diffPerDay * 30);         //
            $aGraphValues['diffPerPerson'][strtotime($read_date->format('Y-m-d'))]       = $value->diffPerPerson; //($value->diffPerPersonPerDay *30); //
            $aGraphValues['diffPerDay'][strtotime($read_date->format('Y-m-d'))]          = $value->diffPerDay;
            $aGraphValues['diffPerPersonPerDay'][strtotime($read_date->format('Y-m-d'))] = $value->diffPerPersonPerDay;
        }

        return view('meters.detail', [ 'location' => $location, 'meter' => $meter, 'metervalues' => $values, 'startDate' => $begin_date, 'endDate' => $end_date, 'graphValues' => $aGraphValues, 'max_value' => $max_value ]);

    }

}
