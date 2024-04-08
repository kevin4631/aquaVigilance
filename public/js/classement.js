function afficheEvo() {
    var elem = document.querySelector('#evo');
    elem.style.display = document.getElementById('checkbox').checked ? 'inline' : 'none';
}

function drawGraphique() {
    const ctx = document.getElementById('myChart');

    const data = {
        labels: tab_Region,
        datasets: [{
            data: tab_delta,
            borderColor: 'rgba(0, 153, 255, 1)',
            backgroundColor: 'rgba(0, 153, 255, 0.5)',
        }]
    };

    new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            indexAxis: 'y',
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each horizontal bar to be 2px wide
            elements: {
                bar: {
                    borderWidth: 2,
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'evolution'
                }
            },
            scales: {
                x: {
                    min: -5,
                    max: 5
                }
            },
            maintainAspectRatio: false,
        },
    });
}

const regions = {
    11: "Île-de-France",
    24: "Centre-Val de Loire",
    27: "Bourgogne-Franche-Comté",
    28: "Normandie",
    32: "Hauts-de-France",
    44: "Grand Est",
    52: "Pays de la Loire",
    53: "Bretagne",
    75: "Nouvelle-Aquitaine",
    76: "Occitanie",
    84: "Auvergne-Rhône-Alpes",
    93: "Provence-Alpes-Côte d'Azur",
    94: "Corse"
};