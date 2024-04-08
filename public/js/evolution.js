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
* Fonction qui retourne les delta des regions entre de 2 années depuis un script php
*/
function getDeltaRegion(annee1, annee2) {
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

        var params = "annee1=" + annee1 + "&annee2=" + annee2;
        xhr.open('POST', 'php/getDeltaRegion.php', true);
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

async function getEvolutionCoursEau(annee1, annee2, codeCoursEau) {
    var tempAnnee = [];
    var anneeTraitement = annee1;
    var total = 0;
    var nbValaurs = 0;

    try {
        const response = await fetch("data/" + codeCoursEau + ".json");
        const fileContent = await response.json();

        fileContent.forEach(data => {
            var annee = parseInt(data["date_mesure_temp"].substring(0, 4));
            var temp = data["resultat"];
            if (annee >= annee1 && annee <= annee2 + 1) {
                if (annee > anneeTraitement) {
                    var moyenne = total / nbValaurs;
                    tempAnnee.push({ moyenne, anneeTraitement });
                    total = 0;
                    nbValaurs = 0;
                    anneeTraitement = annee;
                }

                total += temp;
                nbValaurs++;

            }
        });
    } catch (error) {
        console.error("Erreur lors du chargement du fichier JSON :", error);
    }


    return tempAnnee;
}

