<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;


class Metervalue
    extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'meter_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'meter','value','read_date','persons', ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];

}
