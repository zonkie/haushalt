jQuery(document).ready(function() {
    var options = {
        hoverable : true,
        shadowSize: 0,
        series    : {
            lines : { show: true },
            points: { show: true }
        },
        xaxis     : {
            tickLength: 0
        },
        yaxis     : {
            //ticks       : 10,
            //min         : 50,
            //max         : 200,
            //tickDecimals: 3
        },
        grid      : {
            backgroundColor: { colors: ["#fff", "#fff"] },
            borderWidth    : 1,
            borderColor    : '#555'
        },
        legend: {
            show: true,
            position: "se",
            backgroundColor: null
        },
        colors: ['#FF9900', '#00FF00', '#AB0000', '#000099']
    };
    var meter_charts_absolute = jQuery('#meter-charts-absolute').css({'height': '220px'});
    var meter_charts_absolute = jQuery('#meter-charts-diff').css({'height': '220px'});

    jQuery.plot("#meter-charts-absolute", [
        { label: "Absolute", data: dataTotal },
    ],options );
    jQuery.plot("#meter-charts-diff", [
        { label: "Usage Total", data: dataUsageTotal },
        { label: "Usage Per Person", data: dataUsagePerPerson }
    ],options );
});