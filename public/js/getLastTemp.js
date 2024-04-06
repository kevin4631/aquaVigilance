/*
* Fonction qui retourne le delta de la temp entre 2 années sur un cours d'eau depuis un script php
*/
function getLastTemp(code_cours_eau) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    // Ci-dessous on traite la réponse quand elle arrive
                    resolve(JSON.parse(this.responseText)); // Parsez le JSON en un objet JavaScript et résolvez la promesse avec les données
                } else {
                    reject(new Error('Une erreur s\'est produite. Statut de la requête: ' + this.status));
                }
            }
        };

        var params = "code_cours_eau=" + code_cours_eau;
        xhr.open('POST', 'php/getLastTemp.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(params);
    });
}