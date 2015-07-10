<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;


use App\Location;
use App\Meter;
use App\Metervalue;

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
        $locations = Location::where('active', '=', 1)->get(); //DB::select('select * from locations where active = ?', [ 1 ]);
        foreach ($locations AS &$location) {
            $location->meters = Meter::where('location', '=', $location->id)->get(); //DB::select('select * from meters where location = ? AND active = ?', [ $location->id, 1 ]);
        }

        return view('meters.list', [ 'locations' => $locations ]);
    }

    public function meter($meter_id) {
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


        //if($meter_id == 7){
        //    // test meter only...
        //} else {
        //}

        $meter    = Meter::find($meter_id);// DB::select('select * from meters where id = ?', [ $meter_id ]);
        $location = Location::find($meter->location); //DB::select('select * from locations where id = ?', [ $meter->location ]);
        $values    = Metervalue::where('meter', '=', $meter_id)->get(); //DB::select('select * from meter_values where meter = ? ORDER BY read_date ASC', [ $meter_id ]);

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
                $begin_date = new \DateTime($value->read_date);
            }

            $read_date  = new \DateTime($value->read_date);
            $interval   = ( ! is_null($end_date) ? $end_date->diff($read_date)->format('%a') : 0 );
            $days_total = $days_total + $interval;

            $value->days = $days_total;
            $max_value   = $value->value;
            $end_date    = new \DateTime($value->read_date);

            if (! is_null($beforeValue)) {
                $value->diff      = ( $value->value - $beforeValue );
                $value->diffPrice = $value->diff * $meter->price_per_unit;
                if ($value->persons > 0) {
                    $value->diffPerPerson      = ( $value->diff / $value->persons );
                    $value->diffPricePerPerson = ( ( $value->diff * $meter->price_per_unit ) / $value->persons );
                } else {
                    $value->diffPerPerson = 0;
                }
                if ($interval > 0) {
                    $value->diffPerDay               = ( $value->diff / $interval ); //number_format(...,3,',','');
                    $value->diffPerPersonPerDay      = ( ( $value->diff / $location->persons ) / $interval ); //number_format(...,3,',','');
                    $value->diffPricePerDay          = ( $value->diff * $meter->price_per_unit / $interval );
                    $value->diffPricePerPersonPerDay = ( ( $value->diff / $location->persons ) * $meter->price_per_unit / $interval );
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

            $beforeValue = $value->value;
            //            $aGraphValues['total'][strtotime($read_date->format('Y-m-d'))]               = $value->value;
            //            $aGraphValues['diff'][strtotime($read_date->format('Y-m-d'))]                = $value->diff; //($value->diffPerDay * 30);         //
            //            $aGraphValues['diffPerPerson'][strtotime($read_date->format('Y-m-d'))]       = $value->diffPerPerson; //($value->diffPerPersonPerDay *30); //
            //            $aGraphValues['diffPerDay'][strtotime($read_date->format('Y-m-d'))]          = $value->diffPerDay;
            //            $aGraphValues['diffPerPersonPerDay'][strtotime($read_date->format('Y-m-d'))] = $value->diffPerPersonPerDay;
            $aGraphValues['total']              [ $this->_getJsDateString($read_date) ] = $value->value;
            $aGraphValues['diff']               [ $this->_getJsDateString($read_date) ] = $value->diff;
            $aGraphValues['diffPerPerson']      [ $this->_getJsDateString($read_date) ] = $value->diffPerPerson;
            $aGraphValues['diffPerDay']         [ $this->_getJsDateString($read_date) ] = $value->diffPerDay;
            $aGraphValues['diffPerPersonPerDay'][ $this->_getJsDateString($read_date) ] = $value->diffPerPersonPerDay;
        }

        //$values   = array_reverse($values, true);
        $viewname = 'meters.detail';
        if ($meter->id == 7) {
            $viewname = 'meters.detailtest';
        }

        return view($viewname, [ 'location' => $location, 'meter' => $meter, 'metervalues' => $values, 'startDate' => $begin_date, 'endDate' => $end_date, 'graphValues' => $aGraphValues, 'max_value' => $max_value ]);

    }


    public function compare() {

        $types = DB::select('select DISTINCT type from meters');

        $meters = [ ];
        foreach ($types AS $type) {
            $meters[ $type->type ] = DB::select('select * from meters where type = ?', [ $type->type ]);
        }

        $locations       = DB::select('select * from locations');
        $meter_locations = [ ];
        foreach ($locations AS $location) {
            $meter_locations[ $location->id ] = $location;
        }

        $compare_meters = [ ];
        $compare_values = [ ];
        $compare_unit   = '';
        if (isset( $_POST['compare'] )) {
            $meter_ids = Input::get('compare');

            foreach ($meter_ids AS $meter_id) {
                $row                         = DB::select('select * from meters where id = ?', [ $meter_id ]);
                $compare_meters[ $meter_id ] = $row[0];
                $compare_values[ $meter_id ] = DB::select('select * from meter_values where meter = ? ORDER BY read_date ASC', [ $meter_id ]);
            }
            $js_values = [ ];
            foreach ($compare_meters AS $compare_meter_id => $compare_meter) {
                $compare_unit                    = $compare_meter->unit;
                $js_values[ $compare_meter->id ] = array();

                $before_value = 0;
                foreach ($compare_values[ $compare_meter_id ] AS $value) {
                    $date = new \DateTime($value->read_date);
                    if ($before_value > 0) {
                        $js_values[ $compare_meter->id ][ $this->_getJsDateString($date) ]['diffPerMonth'] = ( ( $value->value - $before_value ) / $value->persons );

                        $before_value = $value->value;
                    } else {
                        $js_values[ $compare_meter->id ][ $this->_getJsDateString($date) ]['diffPerMonth'] = 0;


                        $before_value = $value->value;
                    }

                }
            }

        }

        return view('meters.compare', [ 'meters' => $meters, 'locations' => $meter_locations, 'compareMeters' => $compare_meters, 'compareValues' => ( isset( $js_values ) ? $js_values : array() ), 'compareUnit' => $compare_unit ]);
    }

    protected function _getJsDateString($date) {
        $result = "gd(";
        $result .= $date->format('Y') . ',';
        $result .= $date->format('m') . ',';
        $result .= $date->format('d') . ')';

        return $result;

    }
}

