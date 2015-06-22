@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Water</div>

                    <div class="panel-body">
                        <form class="insertWaterCold" action="">
                            <div class="col-xs-3">
                                <label for="coldWater">
                                    Cold Water
                                </label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" id="coldWater" name="waterAmount"/><input type="submit" name="saveWater" value="save"/>
                            </div>
                        </form>
                        <form class="insertWaterWarm" action="">
                            <div class="col-xs-3">
                                <label for="warmWater">
                                    Warm Water
                                </label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" id="warmWater" name="waterAmount"/><input type="submit" name="saveWater" value="save"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
