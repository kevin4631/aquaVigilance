/*
* Fonction qui retourne le delta de la temp entre 2 années sur un cours d'eau depuis un script php
*/
function getDelta(annee1, annee2, code_cours_eau) {
    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    // Ci-dessous on traite la réponse quand elle arrive
                    resolve(JSON.parse(this.responseText)); // Parsez le JSON en un objet JavaScript et résolvez la promesse avec les données
                } else {
                    reject(new Error('Une erreur s\'est produite. Statut de la requête: ' + this.status));
                }
            }
        };

        var params = "annee1=" + annee1 + "&annee2=" + annee2 + "&code_cours_eau=" + code_cours_eau;
        xhr.open('POST', 'php/getDelta.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(params);
    });
}

/*
* Fontion qui retourn un tableu qui associe les codes cours eau avec leur delta de temp entre 2 années
*/
async function getTabDelta(annee1, annee2, tab_codeCoursEau) {
    var promises = tab_codeCoursEau.map(async codeCoursEau => {
        try {
            const delta = await getDelta(annee1, annee2, codeCoursEau);
            return { codeCoursEau, delta };
        } catch (error) {
            console.error(error);
            return { codeCoursEau, delta: null }; // Vous pouvez définir le delta comme null ou une autre valeur par défaut en cas d'erreur
        }
    });

    return Promise.all(promises);
}

