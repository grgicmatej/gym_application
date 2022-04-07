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
                    warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
                }
            });
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });



    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Statistics/popularMemberships/',
        success: function (popularMemberships) {
            drawMembershipsGraph(popularMemberships)
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Statistics/ageOfUsers/',
        success: function (ageOfUsers) {
            drawAgeOfUsersGraph(ageOfUsers)
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });





});



function drawActiveUsersGraph(responseCurrentYear, responsePreviousYear)
{
    var areaChartCanvas = $('#areaChart2').get(0).getContext('2d')

    let result = JSON.parse(responseCurrentYear).map(({ userData }) => userData)
    let result1 = JSON.parse(responsePreviousYear).map(({ userData }) => userData)

    var areaChartData = {
        labels  : [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        datasets: [
            {
                label               :  new Date().getFullYear(),
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : true,
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
                pointRadius         : true,
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
                    display : true,
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
}

function drawMembershipsGraph(popularMemberships)
{
    let labels =JSON.parse(popularMemberships).map(({ Users_Memberships_Membership_Name }) => Users_Memberships_Membership_Name)
    let result = JSON.parse(popularMemberships).map(({ membershipsCount }) => membershipsCount)
    console.log(labels)
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
        labels: labels,
        datasets: [
            {
                data: result,
                backgroundColor : ['#FF0000', '#FF8001', '#FFFF00', '#00FF80', '#80FF02', '#02FFFF', '#00FF01', '#0280FF', '#0600FF', '#8001FF', '#FF00FF', '#FF0080'],
            }
        ]
    }
    var donutOptions     = {
        maintainAspectRatio : false,
        responsive : true,
    }
    new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
    })

}


function drawAgeOfUsersGraph(ageOfUsers)
{
    //let result = JSON.parse(popularMemberships).map(({ membershipsCount }) => membershipsCount)
    let result1 = JSON.parse(ageOfUsers).map(({ data1 }) => data1)
    let result2 = JSON.parse(ageOfUsers).map(({ data2 }) => data2)
    let result3 = JSON.parse(ageOfUsers).map(({ data3 }) => data3)
    let result4 = JSON.parse(ageOfUsers).map(({ data4 }) => data4)
    let result5 = JSON.parse(ageOfUsers).map(({ data5 }) => data5)
    let result6 = JSON.parse(ageOfUsers).map(({ data6 }) => data6)

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#barChart').get(0).getContext('2d')

    var areaChartData = {
        labels  : ['<20', '21-30', '31-40', '41-50', '51-60', '>60'],
        datasets: [
            {
                label               : 'Broj korisnika',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : result1, result2, result3, result4, result5, result6
            },
        ]
    }

    var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
            display: false
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

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
        type: 'bar',
        data: areaChartData,
        options: areaChartOptions
    })
}