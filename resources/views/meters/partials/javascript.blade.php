<script>
    function gd(year, month, day) {
        return new Date(year, month, day).getTime();
    }

    var unit = '{{$meter->unit}}';
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