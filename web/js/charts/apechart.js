// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(loadFromAJAX);

function loadFromAJAX() {

    $.get(Routing.generate('sndll_platform_ape_chart_json'), function(jsonData) {

        drawApeChart(jsonData);

    });

}

function drawApeChart(jsonData)
{

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    // Set chart options
    var options = {
        'title':'Répartion des différents codes APE',
        'width': '100%',
        'height':'100%',
        'slices': {
            0: { color: 'blue' },
            1: { color: 'red' },
            2: { color: 'black' },
            3: { color: 'grey' }
        },
        'chartArea': { left: 10 }};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_ape'));
    chart.draw(data, options);

}