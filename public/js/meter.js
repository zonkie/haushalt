jQuery(document).ready(function() {

    var dataSources = {
        absolute            : dataTotal,
        usageTotal          : dataUsageTotal,
        usagePerPerson      : dataUsagePerPerson,
        usageTotalPerDay    : dataUsageTotalPerDay,
        usagePerPersonPerDay: dataUsagePerPersonPerDay
    };
    var dataLables = {
        absolute            : "Absolute",
        usageTotal          : "Total Usage",
        usagePerPerson      : "Total Usage Per Person",
        usageTotalPerDay    : "Daily usage",
        usagePerPersonPerDay: "Daily usage Per Person"
    };
    var dataYAxes = {
        absolute            : 1,
        usageTotal          : 2,
        usagePerPerson      : 2,
        usageTotalPerDay    : 3,
        usagePerPersonPerDay: 3
    };
    var dataXAxes = {
        absolute            : 1,
        usageTotal          : 1,
        usagePerPerson      : 1,
        usageTotalPerDay    : 2,
        usagePerPersonPerDay: 2
    };

    var dataColors = {
        absolute            : '#FF9900',
        usageTotal          : '#00FF00',
        usagePerPerson      : '#AB0000',
        usageTotalPerDay    : '#000099',
        usagePerPersonPerDay: '#009900'
    };

    var options = {
        hoverable : true,
        shadowSize: 0,
        series    : {
            lines : {show: true},
            points: {show: true}
        },
        xaxes     : [
            {
                mode              : "time",
                tickSize          : [1, "month"],
                tickLength        : 0,
                axisLabelUseCanvas: true,
                tickLength        : 0
            },
            {
                mode              : "time",
                tickSize          : [10, "day"],
                tickLength        : 0,
                axisLabelUseCanvas: true,
                tickLength        : 0
            }
        ],
        yaxes     : [
            {
                axisLabel              : "Absolute",
                axisLabelUseCanvas     : true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily    : 'Verdana, Arial',
                axisLabelPadding       : 3,
                color                  : dataColors.total
            },
            {
                position               : "right",
                axisLabel              : "Total Usage",
                axisLabelUseCanvas     : true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily    : 'Verdana, Arial',
                axisLabelPadding       : 3,
                color                  : dataColors.total
            },
            {
                position               : "right",
                axisLabel              : "Total Usage Per Person",
                axisLabelUseCanvas     : true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily    : 'Verdana, Arial',
                axisLabelPadding       : 3,
                color                  : dataColors.total
            },
            {
                position               : "right",
                axisLabel              : "Daily Usage",
                axisLabelUseCanvas     : true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily    : 'Verdana, Arial',
                axisLabelPadding       : 3,
                color                  : dataColors.total
            },
            {
                position               : "right",
                axisLabel              : "Daily Usage Per Person",
                axisLabelUseCanvas     : true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily    : 'Verdana, Arial',
                axisLabelPadding       : 3,
                color                  : dataColors.total
            }
        ],
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

    try {
        var meter_charts_absolute = jQuery('#meter-charts-all-in-one').css({'height': '220px'});
        jQuery.plot("#meter-charts-all-in-one", [
            {color: '#FF9900', label: "Absolute", data: dataTotal, },
            {color: '#00FF00', label: "Total Usage", data: dataUsageTotal, yaxis: 2},
            {color: '#AB0000', label: "Total Usage Per Person", data: dataUsagePerPerson, yaxis: 2},
            {color: '#000099', label: "Daily usage", data: dataUsageTotalPerDay, yaxis: 3, xaxis: 2},
            {color: '#009900', label: "Daily usage Per Person", data: dataUsagePerPersonPerDay, yaxis: 3, xaxis: 2}
        ], options);

    } catch (e) {
    }

    var meter_charts_absolute = jQuery('#meter-charts-absolute').css({'height': '220px'});
    var meter_charts_diff = jQuery('#meter-charts-diff').css({'height': '220px'});
    var meter_charts_day = jQuery('#meter-charts-day').css({'height': '220px'});

    jQuery.plot("#meter-charts-absolute", [
        {color: '#FF9900', label: "Absolute", data: dataTotal}
    ], options);
    jQuery.plot("#meter-charts-diff", [
        {color: '#00FF00', label: "Total Usage", data: dataUsageTotal},
        {color: '#AB0000', label: "Total Usage Per Person", data: dataUsagePerPerson}
    ], options);

    jQuery.plot("#meter-charts-day", [
        {color: '#000099', label: "Daily usage", data: dataUsageTotalPerDay, xaxis: 2},
        {color: '#009900', label: "Daily usage Per Person", data: dataUsagePerPersonPerDay, xaxis: 2}
    ], options);

    jQuery('#meter-charts-all-in-one').UseTooltip();
    jQuery('#meter-charts-absolute').UseTooltip();
    jQuery('#meter-charts-diff').UseTooltip();
    jQuery('#meter-charts-day').UseTooltip();

    jQuery('.date-picker').datepicker();
//    jQuery('.knob').knob();



    jQuery.each(dataColors, function(index, value) {
        console.log(index);
        console.log(value);
        console.log(jQuery('label.' + index));
        console.log('.' + index + " i");
        jQuery('.' + index + " i").css('color', value);
        jQuery('td.value.' + index).css('color', value);
    });
    function DoToggling() {
        var dataSet = [];
        jQuery("#form-meter-charts-all-in-one").find("input[type='checkbox']").each(function() {
            if ($(this).is(":checked")) {
                var position = $(this).val();
                dataSet.push(
                    {
                        label: dataLables[position],
                        data : dataSources[position],
                        xaxis: dataXAxes[position],
                        yaxis: dataYAxes[position],
                        color: dataColors[position]
                    }
                );
            }
        });
        jQuery.plot("#meter-charts-all-in-one", dataSet, options);
    }

    $(document).ready(function() {
        DoToggling();

        $("#form-meter-charts-all-in-one").find("input[type='checkbox']").click(function() {
            $(this).parent('label').button('toggle');
            DoToggling();
        });
    });

});

var previousPoint = null, previousLabel = null;
var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

jQuery.fn.UseTooltip = function() {
    jQuery(this).bind("plothover", function(event, pos, item) {
        if (item) {
            if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                previousPoint = item.dataIndex;
                previousLabel = item.series.label;
                jQuery("#tooltip").remove();

                var x = item.datapoint[0];
                var y = item.datapoint[1];

                var color = item.series.color;
                var month = new Date(x).getMonth();

                if (item.seriesIndex == 0) {
                    showTooltip(item.pageX, item.pageY, color, "<strong>" + item.series.label + "</strong><br>" + monthNames[month] + " : <strong>" + y.toFixed(3) + " " + unit + "</strong>");
                } else {
                    showTooltip(item.pageX, item.pageY, color, "<strong>" + item.series.label + "</strong><br>" + monthNames[month] + " : <strong>" + y.toFixed(3) + " " + unit + "</strong>");
                }
            }
        } else {
            window.setTimeout(function() {
                jQuery("#tooltip").fadeOut(function() {
                    jQuery("#tooltip").remove();
                });
                previousPoint = null;
            }, 1000);
        }
    });
};

function showTooltip(x, y, color, contents) {
    jQuery('<div id="tooltip">' + contents + '</div>').css({
        position            : 'absolute',
        display             : 'none',
        top                 : y + 5,
        left                : x + 5,
        border              : '1px solid ' + color,
        padding             : '3px',
        'font-size'         : '9px',
        'border-radius'     : '1px',
        'background-color'  : '#fff',
        'background-opacity': '0.3',
        'font-family'       : 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
        opacity             : 0.9
    }).appendTo("body").fadeIn(200);
}
