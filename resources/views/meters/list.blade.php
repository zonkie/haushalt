@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-xs-12">
            @foreach($locations AS $location)
            <div class="panel panel-default col-xs-12 col-md-4">
                <div class="panel-heading col-xs-12 col-md-12">
                    <h2>{{$location->name}}</h2>
                    {{$location->persons}} Persons</div>

                <div class="panel-body col-xs-12 col-md-12">
                    @foreach ($location->meters as $meter)
                    <p>
                        <a href="/meters/{{$meter->id}}">{{$meter->name}}</a>
                        {{$meter->price_per_unit / 100}}&euro; / {{$meter->unit}}
                    </p>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection