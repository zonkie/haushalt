@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div id="meter-charts-absolute" class="col-xs-12 col-sm-6 col-md-6"></div>
        <div id="meter-charts-diff" class="col-xs-12 col-sm-6 col-md-6"></div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-xs-12">

            @foreach ($metervalues as $value)
            <div class="panel panel-default col-xs-12 col-sm-6 col-md-4">
                <div class="panel-heading col-xs-12 col-md-12">
                    date: {{$value->read_date}}
                </div>
                <div class="panel-body col-xs-12 col-md-12">
                    value: {{number_format($value->value,2,',','')}}<br/>
                    diff: {{number_format($value->diff,2,',','')}}<br/>
                    usage per Person: {{number_format($value->diffPerPerson,2,',','')}}<br/>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
<script>
//    var minY = '2015-02-15';
//    var maxY = '2015-06-15';
    var dataTotal = [];
    var dataUsageTotal = [];
    var dataUsagePerPerson = [];
{{$i=0}}
    @foreach ($metervalues as $value)
        dataTotal.push([ {{$i}},  {{$value->value}} ]);
        dataUsageTotal.push([ {{$i}},  {{$value->diff}} ]);
        dataUsagePerPerson.push([ {{$i}},  {{$value->diffPerPerson}} ]);
        {{$i++}}
    @endforeach
    console.log(dataTotal);

</script>
@endsection
