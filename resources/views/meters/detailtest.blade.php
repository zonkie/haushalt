@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <h2>{{$location->name}}</h2>
        <span>{{$meter->name}} {{($meter->price_per_unit/100)}}&euro; / {{$meter->unit}}</span>
    </div>
    <div class="row">
        <div id="meter-charts-all-in-one" class="col-xs-12"></div>
        <div class="col-xs-12 text-center meter-charts-all-in-one input-group">
            <form action="" class="form-group toggleGraphs" data-graph="meter-charts-all-in-one" id="form-meter-charts-all-in-one">
                <div class="btn-group text-center col-xs-12" role="group">
                    <label class="btn btn-default active col-xs-12 col-md-2 absolute" for="meter-charts-all-in-one_total">
                        <input checked type="checkbox" id="meter-charts-all-in-one_total" name="meter-charts-all-in-one" value="absolute"/>
                        <i class="fa fa-line-chart"></i> Absolute
                    </label>
                    <label class="btn btn-default active col-xs-12 col-md-2 usageTotal" for="meter-charts-all-in-one_diff">
                        <input checked type="checkbox" id="meter-charts-all-in-one_diff" name="meter-charts-all-in-one" value="usageTotal"/>
                        <i class="fa fa-line-chart"></i> Total Usage
                    </label>
                    <label class="btn btn-default active col-xs-12 col-md-3 usagePerPerson" for="meter-charts-all-in-one_diffPerPerson">
                        <input checked type="checkbox" id="meter-charts-all-in-one_diffPerPerson" name="meter-charts-all-in-one" value="usagePerPerson"/>
                        <i class="fa fa-line-chart"></i> Total Usage Per Person
                    </label>
                    <label class="btn btn-default active col-xs-12 col-md-2 usageTotalPerDay" for="meter-charts-all-in-one_diffPerDay">
                        <input checked type="checkbox" id="meter-charts-all-in-one_diffPerDay" name="meter-charts-all-in-one" value="usageTotalPerDay"/>
                        <i class="fa fa-line-chart"></i> Daily usage
                    </label>
                    <label class="btn btn-default active col-xs-12 col-md-3 usagePerPersonPerDay" for="meter-charts-all-in-one_diffPerPersonPerDay">
                        <input checked type="checkbox" id="meter-charts-all-in-one_diffPerPersonPerDay" name="meter-charts-all-in-one" value="usagePerPersonPerDay"/>
                        <i class="fa fa-line-chart"></i> Daily usage Per Person
                    </label>
                </div>
            </form>
        </div>

        <div id="meter-charts-absolute" class="col-xs-12 col-sm-6 col-md-4"></div>
        <div id="meter-charts-diff" class="col-xs-12 col-sm-6 col-md-4"></div>
        <div id="meter-charts-day" class="col-xs-12 col-sm-6 col-md-4"></div>
        <div class="col-xs-4 meter-charts-absolute"></div>
        <div class="col-xs-4 meter-charts-diff"></div>
        <div class="col-xs-4 meter-charts-day"></div>
    </div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                Add Value for <b>{{$meter->name}}</b> at <b>{{$location->name}}</b>
            </div>
            <div class="panel-body">
                {!! Form::open(array('route' => array('meterdetails', $meter->id))) !!}
                <div class="form-group">
                    <div class="col-xs-2">
                        {!! Form::label("read_Date", "Date (Y-M-D)") !!}
                    </div>
                    <div class="col-xs-10">
                        {!! Form::text("read_date", date('Y-m-d'), array('class'=>"date-picker", 'id'=>"id-date-picker-1", 'type'=>"text", 'data-date-format'=>"yyyy-mm-dd" ) ) !!}
                        <!--                            {!! Form::text("read_date_y", date('Y'), array('class'=>'input-small knob', 'value'=>date('Y'), 'data-min'=>"2014", 'data-max'=>"2020", 'data-step'=>"1", 'data-width'=>"80", 'data-height'=>"80", 'data-thickness'=>".2", 'data-fgColor'=>"#2091CF",'data-angleOffset'=>"0", 'data-cursor'=>"true") ) !!}-->
                        <!--                            {!! Form::text("read_date_m", date('m'), array('class'=>'input-small knob', 'value'=>date('m'), 'data-min'=>"1", 'data-max'=>"12", 'data-step'=>"1", 'data-width'=>"80", 'data-height'=>"80", 'data-thickness'=>".2", 'data-fgColor'=>"#2091CF",'data-angleOffset'=>"0", 'data-cursor'=>"true") ) !!}-->
                        <!--                            {!! Form::text("read_date_d", date('d'), array('class'=>'input-small knob', 'value'=>date('d'), 'data-min'=>"1", 'data-max'=>"30", 'data-step'=>"1", 'data-width'=>"80", 'data-height'=>"80", 'data-thickness'=>".2", 'data-fgColor'=>"#2091CF",'data-angleOffset'=>"0", 'data-cursor'=>"true") ) !!}-->
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-2">
                        {!! Form::label("value", "Value") !!}
                    </div>
                    <div class="col-xs-10">
                        {!! Form::text('value', $max_value) !!}
                        <!--                            {!! Form::text("value", ($max_value), array('class'=>'input-small knob', 'value'=>($max_value), 'data-min'=>($max_value), 'data-max'=>($max_value+100), 'data-step'=>"0.001", 'data-width'=>"80", 'data-height'=>"80", 'data-thickness'=>".2", 'data-fgColor'=>"#2091CF",) ) !!}-->

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-2"></div>
                    <div class="col-xs-10">
                        {!! Form::submit('save', '') !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="panel-heading">
                Meter Values of <b>{{$meter->name}}</b> at <b>{{$location->name}}</b>
            </div>
            <div class="panel-body">

                Prices do not contain monthly base fees, just the plain price per unit.
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>
                            date
                        </th>
                        <th>
                            total
                        </th>
                        <th>
                            total / month
                        </th>
                        <th>
                            usage per Person
                        </th>
                        <th>
                            Usage per Day
                        </th>
                        <th>
                            Usage per Person per Day
                        </th>
                        <th class="hidden-xs hidden-sm">
                            Price total
                        </th>
                        <th class="hidden-xs hidden-sm">
                            Price Total Per Person
                        </th>
                        <th class="hidden-xs hidden-sm">
                            Price per day
                        </th>
                        <th class="hidden-xs hidden-sm">
                            Price per person per day
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($metervalues as $value)
                    <tr class="value-{{$value->id}}">
                        <td class="value value-read_date hidden-xs hidden-sm">
                            {{date('d.m.Y', strtotime($value->read_date)) }}
                        </td>
                        <td class="value value-read_date hidden-md hidden-lg">
                            {{date('d.m', strtotime($value->read_date)) }}
                        </td>
                        <td class="value value-value absolute">
                            {{number_format($value->value,2,',','')}} {{$meter->unit}}
                        </td>
                        <td class="value value-diff usageTotal">
                            {{number_format($value->diff,2,',','')}} {{$meter->unit}}
                        </td>
                        <td class="value value-diffPerPerson usagePerPerson">
                            {{number_format($value->diffPerPerson,2,',','')}} {{$meter->unit}}
                        </td>
                        <td class="value value-diffPerDay usageTotalPerDay">
                            {{number_format($value->diffPerDay,4,',','')}} {{$meter->unit}}
                        </td>
                        <td class="value value-diffPerPersonPerDay usagePerPersonPerDay">
                            {{number_format($value->diffPerPersonPerDay,4,',','')}} {{$meter->unit}}
                        </td>
                        <td class="value value-diffPrice usageTotal hidden-xs hidden-sm">
                            {{number_format(($value->diffPrice/100),2,',','')}} &euro;
                        </td>
                        <td class="value value-diffPricePerPerson usagePerPerson hidden-xs hidden-sm">
                            {{number_format(($value->diffPricePerPerson/100),2,',','')}} &euro;
                        </td>
                        <td class="value value-diffPricePerDay usageTotalPerDay hidden-xs hidden-sm">
                            {{number_format(($value->diffPricePerDay/100),4,',','')}} &euro;
                        </td>
                        <td class="value value-diffPricePerPersonPerDay usagePerPersonPerDay hidden-xs hidden-sm">
                            {{number_format(($value->diffPricePerPersonPerDay/100),4,',','')}} &euro;
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('meters.partials.javascripttest')

