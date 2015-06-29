@extends('app')

@section('content')

<div class="container">
    <div class="row graph">
        <div id="compare_graph" class="col-xs-12"></div>

    </div>
    <div class="row">
        @foreach($meters AS $type=>$type_meters)
        <div class="panel col-xs-4">
            <div class="panel-heading">
                {{$type}}
            </div>
            <div class="panel-body">
                {!! Form::open(array('route' => array('metercompare'))) !!}
                @foreach($type_meters AS $type_meter)
                <div class="checkcol-xs-12 clearfix">

                    <div class="onoffswitch pull-right">
                        <input type="checkbox" name="compare[]" class="onoffswitch-checkbox" id="meter_{{$type_meter->id}}" value="{{$type_meter->id}}" checked>
                        <label class="onoffswitch-label" for="meter_{{$type_meter->id}}">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                    <span class="">
                        {{$type_meter->name}} ( {{ $locations[$type_meter->location]->name}} )
                    </span>
                </div>

                @endforeach

                {!! Form::submit('Compare', array('class'=>'btn btn-success')) !!}
                {!! Form::close() !!}
            </div>
        </div>
        @endforeach

    </div>

</div>
@endsection

@section('javaScript')
    @if(is_array($compareValues))
        @include('meters.partials.javascriptcompare')
    @endif
@endsection
