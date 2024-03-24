// --------------- RECUP TEMPERATURE COURS D'EAUX ---------------
var tabDeltaCoursEau;

/** 
 * lance un appel ajax pour recup les delta des cours d'eau
 */
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        // Ci-dessous on traite la réponse quand elle arrive
        tabDeltaCoursEau = JSON.parse(this.responseText); // Parsez le JSON en un objet JavaScript
        // une fois les données recup on lance le chargement des cours d'eau
        load();
    } else if (this.readyState == 4) {
        alert(this.status);
    }
};

xhr.open('POST', 'php/getDelta.php', true);
xhr.send();