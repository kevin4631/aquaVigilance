// --------------- COLORATION COURS D'EAUX ---------------

function getColor(temp, min, max) {
    // pour l'evolution
    if (temp == 999)
        return "rgba(0,0,0,0.4)";

    // Bleu pour les températures inférieures au min
    if (temp < min)
        return 'rgb(0, 0, 255)';

    // Rouge pour les températures supérieures au max
    if (temp > max)
        return 'rgb(255, 0, 0)';

    // Calcul de la proportion entre le bleu et le rouge en fonction de la température
    var ratio = (temp + Math.abs(min)) / (max + Math.abs(min));

    var red = Math.round(255 * ratio);
    var blue = Math.round(255 * (1 - ratio));

    return 'rgb(' + red + ', 0, ' + blue + ')';
}

function showEvolution(annee1, annee2, tab_coursEau) {
    document.querySelector('#max').innerHTML = '⩾ + 5°C';
    document.querySelector('#min').innerHTML = '⩽ - 5°C';

    tab_coursEau.forEach(coursEau => {
        // on attend que la requette ajax termine
        getDelta(annee1, annee2, getCodeCoursEau(coursEau)).then(function (delta) {
            //console.log(delta);
            setColorCoursEau(coursEau, getColor(delta, -5, 5))
            if (delta == 999)
                setPopUpCoursEau(coursEau, "pas de données d'évolution pour ce cours d'eau entre " + annee1 + " et " + annee2);
            else if (delta > 0)
                setPopUpCoursEau(coursEau, "Augmentation de +" + delta.toFixed(2) + "°C entre " + annee1 + " et " + annee2);
            else if (delta < 0)
                setPopUpCoursEau(coursEau, "Diminution de " + delta.toFixed(2) + "°C entre " + annee1 + " et " + annee2);
            else if (delta == 0)
                setPopUpCoursEau(coursEau, " Pas d'évolution entre " + annee1 + " et " + annee2);
        }).catch(function (error) {
            console.error(error);
        });
    });
}

function showLastTemp(tab_coursEau) {
    document.querySelector('#max').innerHTML = '⩾ 30°C';
    document.querySelector('#min').innerHTML = '⩽ 0°C';

    tab_coursEau.forEach(coursEau => {
        // on attend que la requette ajax termine
        getLastTemp(getCodeCoursEau(coursEau)).then(function (lastTemp) {
            //console.log(lastTemp);
            setColorCoursEau(coursEau, getColor(lastTemp["resultat"], 0, 30))
            setPopUpCoursEau(coursEau, "Derniére température enregistré : " + lastTemp["resultat"].toFixed(2) + "°C"
                + "<br>le " + lastTemp["date_mesure_temp"] + " à " + lastTemp["heure_mesure_temp"]);
        }).catch(function (error) {
            console.error(error);
        });
    });
}