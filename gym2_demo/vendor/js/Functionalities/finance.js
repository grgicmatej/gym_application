$('.finance').on('click', function () {
    fadeIn("#finance");
    document.getElementById('incomeOnSpecificDate').style.display = 'none';
    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Finances/yearlyIncome/',
        success: function (response) {
            response = JSON.parse(response);
            $("#yearlyIncome").text((response["Users_Memberships_Price_Year"] ?? 0.00)+' HRK');
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Finances/monthlyIncome/',
        success: function (response) {
            response = JSON.parse(response);
            $("#monthlyIncome").text((response["Users_Memberships_Price_Month"] ?? 0.00)+' HRK');
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Finances/yesterdayIncome/',
        success: function (response) {
            response = JSON.parse(response);
            $("#yesterdayIncome").text((response["Users_Memberships_Price_Yesterday"] ?? 0.00)+' HRK');
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Finances/dailyIncome/',
        success: function (response) {
            response = JSON.parse(response);
            $("#dailyIncome").text((response["Users_Memberships_Price_Day"] ?? 0.00)+' HRK');
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Finances/yearlyStatsFinance/',
        success: function (responseCurrentYear) {
            $.ajax({
                method: "POST",
                data: {},
                url: urlAddress + 'Finances/yearlyStatsPreviousYearFinance/',
                success: function (responsePreviousYear) {
                    drawFinanceGraph(responseCurrentYear, responsePreviousYear)
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
        url: urlAddress + 'Finances/yearlyIncomeMemberships/',
        success: function (response) {
            drawYearlyIncomeMembershipsGraph(response)
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });

    $.ajax({
        method: "POST",
        data: {},
        url: urlAddress + 'Finances/yearlyIncomeOther/',
        success: function (response) {
            drawYearlyIncomeOtherGraph(response)
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});

$('#incomeDatesForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: urlAddress + 'Finances/incomeOnSpecificDate/',
        data: $('#incomeDatesForm').serialize(),
        success: function (response) {

            response = JSON.parse(response)
            document.getElementById('incomeOnSpecificDate').style.display = 'block';
            $("#incomeOnSpecificDateMembership").text((response["membershipsSale"] ?? 0.00) +' HRK');
            $("#incomeOnSpecificDateOther").text((response["otherSale"] ?? 0.00)+' HRK');
            $("#specificDate").text(formatDate(response["Sales_Date"]));
            successNotification('Uspješno dohvaćeni podaci.');

            clearInput(1000, 'incomeDatesForm');
        },
        error: function (){
            warningNotification('Došlo je do pogreške. Pokušajte ponovo.');
        }
    });
});

function drawFinanceGraph(responseCurrentYear, responsePreviousYear)
{
    var areaChartCanvas = $('#areaChart3').get(0).getContext('2d')

    let result = JSON.parse(responseCurrentYear).map(({ userFinanceData }) => userFinanceData)
    let result1 = JSON.parse(responsePreviousYear).map(({ userFinanceData }) => userFinanceData)

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

function drawYearlyIncomeMembershipsGraph(response)
{

    let labels =JSON.parse(response).map(({ Sales_Item_Name }) => Sales_Item_Name)
    let result = JSON.parse(response).map(({ salesSum }) => salesSum)

    var areaChartCanvas = $('#barChart1').get(0).getContext('2d')
    var areaChartData = {
        labels  : labels,
        datasets: [
            {
                label               : 'Ovogodišnji prihodi',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : result
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

function drawYearlyIncomeOtherGraph(response)
{
    let labels =JSON.parse(response).map(({ Sales_Warehouse_Item_Name }) => Sales_Warehouse_Item_Name)
    let result = JSON.parse(response).map(({ salesSum }) => salesSum)
    var donutData        = {
        labels: labels,
        datasets: [
            {
                data: result,
                backgroundColor : ['#CCD5E6', '#658DC2', '#B9C6DD', '#4C7DB7', '#A3B5D4', '#4873AB', '#8AA3CC', '#416C9F', '#416C9F', '#32567F'],
            }
        ]
    }

    var pieChartCanvas = $('#pieChart4').get(0).getContext('2d')
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