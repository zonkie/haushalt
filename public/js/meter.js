jQuery(document).ready(function() {
    var options = {
        hoverable : true,
        shadowSize: 0,
        series    : {
            lines : {show: true},
            points: {show: true}
        },
        xaxis     : {
            mode              : "time",
            tickSize          : [1, "day"],
            axisLabelUseCanvas: true,
            tickLength        : 0
        },
        yaxes     : [
            {
                axisLabel: "Absolute",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3
            },
            {
                position: "right",
                axisLabel: "Per Person",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3
            },
            {
                position: "right",
                axisLabel: "Per Person Per Day",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3
            }
        ],
        grid      : {
            backgroundColor: {colors: ["#fff", "#EEE"]},
            borderWidth    : 1,
            borderColor    : '#555',
            hoverable: true
        },
        legend    : {
            show           : true,
            position       : "se",
            backgroundColor: null,
            opacity: 0.7
        },
        colors    : ['#FF9900', '#00FF00', '#AB0000', '#000099', '#009900']
    };
    var meter_charts_absolute = jQuery('#meter-charts-absolute').css({'height': '220px'});
    var meter_charts_diff = jQuery('#meter-charts-diff').css({'height': '220px'});
    var meter_charts_day = jQuery('#meter-charts-day').css({'height': '220px'});

    jQuery.plot("#meter-charts-absolute", [
        {label: "Absolute", data: dataTotal},
        //{label: "Total Usage", data: dataUsageTotal, yaxis: 2},
        //{label: "Total Usage Per Person", data: dataUsagePerPerson, yaxis: 2},
        //{label: "Daily usage", data: dataUsageTotalPerDay,yaxis: 3},
        //{label: "Daily usage Per Person", data: dataUsagePerPersonPerDay,yaxis: 3}
    ], options);
    jQuery.plot("#meter-charts-diff", [
        {label: "Total Usage", data: dataUsageTotal},
        {label: "Total Usage Per Person", data: dataUsagePerPerson}
    ], options);

    jQuery.plot("#meter-charts-day", [
        {label: "Daily usage", data: dataUsageTotalPerDay},
        {label: "Daily usage Per Person", data: dataUsagePerPersonPerDay}
    ], options);
});