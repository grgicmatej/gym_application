// Statistika chartJS
var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

var areaChartData = {
    labels  : ['Siječanj', 'Veljača', 'Ožujak', 'Travanj', 'Svibanj', 'Lipanj', 'Srpanj', 'Kolovoz', 'Rujan', 'Listopad', 'Studeni', 'Prosinac'],
    datasets: [
        {
            label               : 'Aktivni korisnici',
            backgroundColor     : 'rgba(116, 198, 135, 0.5)',
            borderColor         : 'rgba(116, 198, 135, 1)',
            pointRadius         : true,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 55, 40]
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
                display : true,
            }
        }]
    }
}

new Chart(areaChartCanvas, {
    type: 'line',
    data: areaChartData,
    options: areaChartOptions
})
// Statistika chartJS kraj
