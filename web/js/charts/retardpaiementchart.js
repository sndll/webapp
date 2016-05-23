// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(loadFromAJAX);

function loadFromAJAX() {

    $.get(Routing.generate('sndll_platform_retard_chart_json'), function(jsonData) {

        drawRetardChart(jsonData);

    });

}

function drawRetardChart(jsonData)
{

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    // Set chart options
    var options = {
        'title':'Rapport des retards de paiement des adhérents de l\’année précédente',
        'width': '100%',
        'height':'100%',
        'slices': {
            0: { color: 'green' },
            1: { color: 'orange' }
        },
        chartArea : { left: 10 }};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_retard'));
    chart.draw(data, options);

}