<script>
    function gd(year, month, day) {
        return new Date(year, month, day).getTime();
    }
    var unit = '{{$compareUnit}}';
    jQuery(document).ready(function(){

        compare_options = {
            hoverable : true,
            shadowSize: 0,
            series    : {
                lines : {show: true},
                points: {show: true}
            },
            xaxis     : {
                mode              : "time",
                tickSize          : [1, "month"],
                tickLength        : 0,
                axisLabelUseCanvas: true,
                tickLength        : 0
            },
            yaxis     : {
                axisLabel              : "Diff",
                axisLabelUseCanvas     : true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily    : 'Verdana, Arial',
                axisLabelPadding       : 3
            },
            grid      : {
                backgroundColor: {colors: ["#fff", "#EEE"]},
                borderWidth    : 1,
                borderColor    : '#555',
                hoverable      : true
            },
            legend    : {
                show           : true,
                position       : "se",
                backgroundColor: null,
                opacity        : 0.7
            }
        };

         dataUsageTotal = [];

        @if(count($compareValues) >0)
            @foreach($compareValues AS $meter_id => $values )
                meter_{{$meter_id}}  = [];
                @foreach($values AS $day => $value )
                    meter_{{$meter_id}}.push( [ {{$day}}, {{ $value['diffPerMonth'] }} ] );
                @endforeach

            dataUsageTotal.push( { label: '{{$compareMeters[$meter_id]->name}}', data: meter_{{$meter_id}}  } );
            @endforeach
        @endif



        jQuery('#compare_graph').css({'height': '220px'});
        jQuery.plot("#compare_graph", dataUsageTotal, compare_options );
        jQuery('#compare_graph').UseTooltip();

    });
</script>