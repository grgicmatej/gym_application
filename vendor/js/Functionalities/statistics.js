$('.statistics').on('click', function () {
    fadeIn("#statistics");



    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Statistics/yearlyStats/',
        success: function (responseCurrentYear) {
            $.ajax({
                method: "POST",
                data: {},
                url: urlAddress + 'Statistics/yearlyStatsPreviousYear/',
                success: function (responsePreviousYear) {
                    drawActiveUsersGraph(responseCurrentYear, responsePreviousYear)
                },
                error: function (){

                }
            });

        },
        error: function (){

        }
    });





    function drawActiveUsersGraph(responseCurrentYear, responsePreviousYear)
    {
        var areaChartCanvas = $('#areaChart2').get(0).getContext('2d')


        // dobije string
        // sa parseom prebaci u obj


        let result = JSON.parse(responseCurrentYear).map(({ userData }) => userData)


        let result1 = JSON.parse(responsePreviousYear).map(({ userData }) => userData)



        var areaChartData = {
            labels  : [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            datasets: [
                {
                    label               :  new Date().getFullYear(),
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : result
                },
                {
                    label               : new Date().getFullYear()-1,
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : result1
                },
            ]
        }

        var areaChartOptions = {
            maintainAspectRatio : false,
            responsive : true,
            legend: {
                display: true
            },
            scales: {
                xAxes: [{
                    gridLines : {
                        display : false,
                    }
                }],
                yAxes: [{
                    gridLines : {
                        display : false,
                    }
                }]
            }
        }

        // This will get the first returned node in the jQuery collection.
        new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
        })

        var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
        var lineChartOptions = $.extend(true, {}, areaChartOptions)
        var lineChartData = $.extend(true, {}, areaChartData)
        lineChartData.datasets[0].fill = false;
        lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false

        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        })
    }





});