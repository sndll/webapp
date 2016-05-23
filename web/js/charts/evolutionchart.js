// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(loadFromAJAX);

function loadFromAJAX() {

    $.get(Routing.generate('sndll_platform_evolution_adhesions_chart_json'), function(jsonData) {

        drawEvolutionAdhesionsChart(jsonData);

    });

}

function drawEvolutionAdhesionsChart(jsonData)
{

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(jsonData);

    var options = {
        title: "Evolution du nombre d\'adhérent",
        width: '100%',
        'height':'100%',
        bar: {groupWidth: "95%"},
        legend: { position: "none" }
        vAxis: {minValue: 0}
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("chart_evolution_adhesions"));
    chart.draw(data, options);

}