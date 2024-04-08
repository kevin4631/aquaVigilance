function afficheEvo() {
    var elem = document.querySelector('#evo');
    elem.style.display = document.getElementById('checkbox').checked ? 'inline' : 'none';
}

function drawGraphique(annee1, annee2, tab_Region, tab_delta) {
    const ctx = document.getElementById('myChart');

    // Vérifier si un graphique existe déjà
    if (myChart) {
        // Si oui, le détruire avant d'en créer un nouveau
        myChart.destroy();
    }

    const data = {
        labels: tab_Region,
        datasets: [{
            data: tab_delta,
            borderColor: 'rgba(0, 153, 255, 1)',
            backgroundColor: 'rgba(0, 153, 255, 0.5)',
        }]
    };

    myChart = new Chart(ctx, {
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
                    text: 'evolution entre ' + annee1 + " et " + annee2
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

function loadGraphique(annee1, annee2) {
    var tab_delta = [];
    var tab_Region = [];

    getDeltaRegion(annee1, annee2).then(function (tab_deltaRegion) {
        //console.log(tab_deltaRegion);

        tab_deltaRegion.forEach(deltaRegion => {
            tab_Region.push(regions[deltaRegion[0]]);
            tab_delta.push(deltaRegion[1]);
        });

        //console.log(tab_delta);
        //console.log(tab_Region);

        drawGraphique(annee1, annee2, tab_Region, tab_delta);
    }).catch(function (error) {
        console.error(error);
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