@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div id="meter-charts-absolute" class="col-xs-12 col-sm-6 col-md-4"></div>
            <div id="meter-charts-diff" class="col-xs-12 col-sm-6 col-md-4"></div>
            <div id="meter-charts-day" class="col-xs-12 col-sm-6 col-md-4"></div>
        </div>
        <div class="row addValue">
            {{ Form::open(array('url' => '')) }}
            {{ Form::text('email', 'example@gmail.com')}}
            {{ Form::close() }}
        </div>
        <div class="row">
            <ul class="list-unstyled" >
                @foreach ($metervalues as $value)
                    <li class="col-xs-12 col-sm-6 col-md-4">
                        <div class="panel panel-default ">
                            <div class="panel-heading ">
                                date: {{$value->read_date}}
                            </div>
                            <div class="panel-body ">
                                value: {{number_format($value->value,2,',','')}}<br/>
                                diff: {{number_format($value->diff,2,',','')}}<br/>
                                usage per Person: {{number_format($value->diffPerPerson,2,',','')}}<br/>
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
