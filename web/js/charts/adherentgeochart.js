// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(loadFromAJAX);

function loadFromAJAX() {

    $.get(Routing.generate('sndll_platform_geo_chart_json'), function(jsonData) {

        drawGeoChart(jsonData);

    });

}

function drawGeoChart(jsonData) {

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    var options = {

        region: 'FR',
        title:'Carte des adhérents en cours',
        width: '100%',
        height:550,
        displayMode: 'markers',
        colorAxis: {colors: ['green', 'blue']}

    };

    var chart = new google.visualization.GeoChart(document.getElementById('geochart_adherent'));
    chart.draw(data, options);

}