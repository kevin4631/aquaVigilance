// --------------- AJOUT TRACES COURS D'EAUX ---------------
var tabFileNameTraceCoursEau;

/**
 * lance un appel ajax pour recup les noms des cours d'eau
 */
function load() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Ci-dessous on traite la réponse quand elle arrive
            tabFileNameTraceCoursEau = JSON.parse(this.responseText); // Parsez le JSON en un objet JavaScript
            // un fois les noms recup on affiche les traces
            ajoutTraceCoursEau();
        } else if (this.readyState == 4) {
            alert(this.status);
        }
    };

    xhr.open('POST', 'php/getFileNameCoursEau.php', true);
    xhr.send();
}