google.load('visualization', '1.0', {'packages':['corechart']});
google.setOnLoadCallback(loadFromAJAX);

function loadFromAJAX() {

    $.get(Routing.generate('sndll_platform_conversion_chart_json'), function(jsonData) {

        drawConversionChart(jsonData);

    });

}

function drawConversionChart(jsonData)
{

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    // Set chart options
    var options = {

        'title':'Rapport de conversion établissements / adhérents',
        'width': '100%',
        'height':'100%',
        'slices': {

            0: { color: 'green' },
            1: { color: 'orange' },
            2: { color: 'red' }

        }};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_conversion'));
    chart.draw(data, options);

}