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

    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Statistics/usersGender/',
        success: function (usersGender) {
           drawUsersGenderGraph(usersGender)
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Statistics/usersStatus/',
        success: function (usersStatus) {
            drawUsersStatusGraph(usersStatus)
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Statistics/usersReference/',
        success: function (usersReference) {
            drawUsersReferenceGraph(usersReference)
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
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
        labels: labels,
        datasets: [
            {
                data: result,
                backgroundColor : ['#CCD5E6', '#658DC2', '#B9C6DD', '#4C7DB7', '#A3B5D4', '#4873AB', '#8AA3CC', '#416C9F', '#416C9F', '#32567F'],
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

    let result1 = 0;
    let result2 = 0;
    let result3 = 0;
    let result4 = 0;
    let result5 = 0;
    let result6 = 0;
    JSON.parse(ageOfUsers, function (key, value) {
        switch(key) {
            case "data1":
                result1 = value;
                break;
            case "data2":
                result2 = value;
                break;
            case "data3":
                result3 = value;
                break;
            case "data4":
                result4 = value;
                break;
            case "data5":
                result5 = value;
                break;
            case "data6":
                result6 = value;
                break;
        }
    });

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
                data                : [result1, result2, result3, result4, result5, result6]
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

function drawUsersGenderGraph(usersGender)
{
    let labels =JSON.parse(usersGender).map(({ Users_Gender }) => Users_Gender)
    let result = JSON.parse(usersGender).map(({ genderCount }) => genderCount)
    var donutData        = {
        labels: labels,
        datasets: [
            {
                data: result,
                backgroundColor : ['#CCD5E6', '#658DC2', '#B9C6DD', '#4C7DB7', '#A3B5D4', '#4873AB', '#8AA3CC', '#416C9F', '#416C9F', '#32567F'],
            }
        ]
    }

    var pieChartCanvas = $('#pieChart1').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
    }

    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    })

}

function drawUsersStatusGraph(usersStatus)
{
    let labels =JSON.parse(usersStatus).map(({ Users_Status }) => Users_Status)
    let result = JSON.parse(usersStatus).map(({ statusCount }) => statusCount)
    var donutData        = {
        labels: labels,
        datasets: [
            {
                data: result,
                backgroundColor : ['#CCD5E6', '#658DC2', '#B9C6DD', '#4C7DB7', '#A3B5D4', '#4873AB', '#8AA3CC', '#416C9F', '#416C9F', '#32567F'],
            }
        ]
    }

    var pieChartCanvas = $('#pieChart2').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
    }

    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    })

}

function drawUsersReferenceGraph(usersReference)
{
    let labels =JSON.parse(usersReference).map(({ Users_Reference }) => Users_Reference)
    let result = JSON.parse(usersReference).map(({ referenceCount }) => referenceCount)
    var donutData        = {
        labels: labels,
        datasets: [
            {
                data: result,
                backgroundColor : ['#CCD5E6', '#658DC2', '#B9C6DD', '#4C7DB7', '#A3B5D4', '#4873AB', '#8AA3CC', '#416C9F', '#416C9F', '#32567F'],
            }
        ]
    }

    var pieChartCanvas = $('#pieChart3').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
    }

    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    })

}