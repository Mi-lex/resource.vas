/**
 * Необходимо извлечь
 * 1) Дату последнего потребления var lastConsumptionDatetime
 * Информацию нужно получить в отдельном запросе
 * 2) id опрашиваемого устройства var deviceId
 */

var lastConsumptionDatetime, deviceId;
var currentLocation = window.location.href.split('/');
var id = currentLocation[currentLocation.length - 1];

var url = 'http://resource.test/meters/' + id + '/consumption/30';

$(document).ready(function () {
    $('.sidebar-menu').tree()
    // updateTimeFromSuccess();
    // setInterval(updateTimeFromSuccess, 1000);
    refreshData();
    showChart();
})

function showChart() {
    $.get(url, function (consumptionsObject) {
        const [labels, plotData] = getChartData(consumptionsObject);
    
        loadDataToChart(labels, plotData);
    });
}

function getChartData(consumptionObject) {
    const plotData = [];
    // Each day consists two consumption (at the start and at the end)
    days = [...Object.keys(consumptionObject)];

    consumptionName = 'sumDirectActive';

    days.forEach((key) => {
        // get dayly consumptions by subtracting max and min values
        const diff = (consumptionObject[key][1][consumptionName] -
            consumptionObject[key][0][consumptionName]).toFixed(2);

        // push that difference into the plotData
        plotData.push(diff);
    });

    return [
        days,
        plotData
    ]
}

function loadDataToChart(labels, plotData) {
    $(function () {
        /* ChartJS
          * -------
          * Here we will create a few charts using ChartJS
          */
        var areaChartData = {
            labels: labels,
            datasets: [
                {
                    label: 'Потребление энергии',
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: plotData
                }
            ]
        }

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChart = new Chart(barChartCanvas)
        var barChartData = areaChartData
        barChartData.datasets[0].fillColor = '#00a65a'
        barChartData.datasets[0].strokeColor = '#00a65a'
        barChartData.datasets[0].pointColor = '#00a65a'
        var barChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true
        }

        barChartOptions.datasetFill = false
        barChart.Bar(barChartData, barChartOptions)
    })
};


var autoRefresh = $('#autoRefresh').is(':checked');
var successTime = new Date(lastConsumptionDatetime);
var errorMaxCount = 5;
var errorCount = 0;


$("#getFreshData").click(refreshData);

$('#autoRefresh').change(function () {
    autoRefresh = $('#autoRefresh').is(':checked');
    if (autoRefresh) {
        errorCount = 0;
        refreshData();
    };
});

function setStatusPending() {
    $("#statusHeading").html('<i class="icon fa fa-spin fa-spinner"></i> Сведения обновляются...</h4>');
}

function setStatusSuccess() {
    $("#statusPanel").removeClass();
    $("#statusPanel").addClass("alert alert-success");
    $("#statusHeading").html('<i class="icon fa fa-check"></i> Сведения актуальны</h4>');
}
function setStatusError() {
    $("#statusPanel").removeClass();
    $("#statusPanel").addClass("alert alert-danger");
    $("#statusHeading").html('<i class="icon fa fa-times"></i> Сведения могут быть не актуальны</h4>')
}

function refreshData() {
    const url = 'http://resource.test/meters/'+ id +'/last_electricity_consumption';

    $.get(url, function (lastConsumption) {
        console.log(lastConsumption);

        $("#a1").text(lastConsumption.t1DirectActive.toFixed(2));
        $("#r1").text(lastConsumption.t1DirectReactive.toFixed(2));
        $("#a2").text(lastConsumption.t2DirectActive.toFixed(2));
        $("#r2").text(lastConsumption.t2DirectReactive.toFixed(2));
    });
}

// function refreshData() {
//     $.ajax({
//         url: 'http://resource.test/meters/'+ id +'/last_electricity_consumption',
//         type: 'GET',
//         dataType: 'json',
//         data: { deviceId: deviceId },
//         beforeSend: setStatusPending()
//     })
//         .done(function (data) {
//             errorCount = 0;
//             $("#a1").text(data.t1DirectActive.toFixed(2));
//             $("#r1").text(data.t1DirectReactive.toFixed(2));
//             $("#a2").text(data.t2DirectActive.toFixed(2));
//             $("#r2").text(data.t2DirectReactive.toFixed(2));
//             successTime = new Date();
//             updateTimeFromSuccess();
//             setStatusSuccess();
//         })
//         .fail(function (data) {
//             setStatusError();
//             errorCount++;
//             // alert("Произошла ошибка. Сведения не обновлены.")
//             console.warn(data.responseText)
//         })
//         .always(function () {
//             if (autoRefresh) {
//                 if (errorCount <= errorMaxCount) {
//                     setTimeout(refreshData, 1000);
//                     if (errorCount > 0) {
//                         console.info("Не выполнено запросов подряд: " + errorCount);
//                     }
//                 } else {
//                     console.error("Автоматическое обновление остановлено. Превышел лимит ошибок.")
//                     $('#autoRefresh').prop("checked", false)
//                     autoRefresh = false;
//                 }
//             }
//         });
// }

function updateTimeFromSuccess() {
    $('#timeFromSuccess').text(moment(successTime).fromNow());
}