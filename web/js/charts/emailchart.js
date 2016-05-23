// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

google.setOnLoadCallback(loadFromAJAX);

function loadFromAJAX() {

    $.get(Routing.generate('sndll_site_chart_json'), function(jsonData) {

        drawEmailChart(jsonData);

    });

}

function drawEmailChart(jsonData)
{

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    // Set chart options
    var options = {
        'title':'Adhérents avec / sans adresse email',
        'width': '100%',
        'height':225,
        'slices': {
            0: { color: 'green' },
            1: { color: 'orange' }
        }
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_email'));
    chart.draw(data, options);
}