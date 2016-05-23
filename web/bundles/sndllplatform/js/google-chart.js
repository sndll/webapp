// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawChart1);
google.setOnLoadCallback(drawChart2);

// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawChart1()
{
    var jsonData = $.ajax({
        url: "http://sndll-webapp/app_dev.php/chart1JsonData",
        dataType:"json",
        async: false
    }).responseText;

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    // Set chart options
    var options = {
        'title':'Rapport de convertion établissements / adhérents',
        'width':500,
        'height':400,
        'slices': {
            0: { color: 'green' },
            1: { color: 'orange' },
            2: { color: 'red' }
        },
        chartArea : { left: 10 }};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

function drawChart2()
{
    var jsonData = $.ajax({
        url: "http://sndll-webapp/app_dev.php/chart2JsonData",
        dataType:"json",
        async: false
    }).responseText;

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    var options = {
        title: "Evolution du nombre d\'adhérents",
        width: 400,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" }
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart"));
    chart.draw(data, options);
}