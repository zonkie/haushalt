<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;


class Meter
    extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'meters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'location', 'type', 'meter_id', 'unit', 'active' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];

}
