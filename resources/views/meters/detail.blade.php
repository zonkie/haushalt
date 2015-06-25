@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <h2>{{$location->name}}</h2>
            <span>{{$meter->name}} {{($meter->price_per_unit/100)}}&euro; / {{$meter->unit}}</span>
        </div>
        <div class="row">
            <div id="meter-charts-absolute" class="col-xs-12 col-sm-6 col-md-4"></div>
            <div id="meter-charts-diff" class="col-xs-12 col-sm-6 col-md-4"></div>
            <div id="meter-charts-day" class="col-xs-12 col-sm-6 col-md-4"></div>
        </div>
        <div class="row addValue">
            <div class="panel">
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
            </div>
        </div>
        <div class="row">
            <ul class="list-unstyled" >
                @foreach ($metervalues as $value)
                    <li class="col-xs-12 col-sm-12 col-md-12">
                        <div class="panel panel-default ">
                            <div class="panel-heading ">
                                date: {{$value->read_date}}
                            </div>
                            <div class="panel-body ">
                                value: {{number_format($value->value,2,',','')}}<br/>
                                diff: {{number_format($value->diff,2,',','')}}<br/>
                                usage per Person: {{number_format($value->diffPerPerson,2,',','')}}<br/>
                                diff per Day: {{number_format($value->diffPerDay,2,',','')}}<br/>
                                usage per Person per Day: {{number_format($value->diffPerPersonPerDay,2,',','')}}<br/><br />

                                Price total: {{number_format(($value->diffPrice/100),2,',','')}}&euro;<br />
                                Price Total Per Person: {{number_format(($value->diffPricePerPerson/100),2,',','')}}&euro;<br />
                                Price per day: {{number_format(($value->diffPricePerDay/100),2,',','')}}&euro;<br />
                                Price per person per day: {{number_format(($value->diffPricePerPersonPerDay/100),2,',','')}}&euro;<br />
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
    <script>
        var dataTotal = [];
        @foreach($graphValues['total'] AS $day => $value )
            dataTotal.push([{{$day}}, {{$value}}]);
        @endforeach

        var dataUsageTotal = [];
        @foreach($graphValues['diff'] AS $day => $value )
            dataUsageTotal.push([{{$day}}, {{$value}}]);
        @endforeach

        var dataUsagePerPerson = [];
        @foreach($graphValues['diffPerPerson'] AS $day => $value )
            dataUsagePerPerson.push([{{$day}}, {{$value}}]);
        @endforeach

        var dataUsageTotalPerDay = [];
        @foreach($graphValues['diffPerDay'] AS $day => $value )
            dataUsageTotalPerDay.push([{{$day}}, {{$value}}]);
        @endforeach

        var dataUsagePerPersonPerDay = [];
        @foreach($graphValues['diffPerPersonPerDay'] AS $day => $value )
            dataUsagePerPersonPerDay.push([{{$day}}, {{$value}}]);
        @endforeach


    </script>
@endsection
