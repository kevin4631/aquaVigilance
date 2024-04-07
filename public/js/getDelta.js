/*
* Fonction qui retourne le delta de la temp entre 2 années sur un cours d'eau depuis un script php
*/
function getDelta(annee1, annee2, code_cours_eau) {
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

        var params = "annee1=" + annee1 + "&annee2=" + annee2 + "&code_cours_eau=" + code_cours_eau;
        xhr.open('POST', 'php/getDelta.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(params);
    });
}

// --------------------------------------------------------------------------------------------------------------------------------------
// Définir les années
const annee1 = 2019;
const annee2 = 2020;

// Créer un tableau pour stocker les deltas des cours d'eau
const deltas_cours_eau = [];

// Fonction pour récupérer les codes des cours d'eau depuis le serveur
function getCodesCoursEau() {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    resolve(JSON.parse(this.responseText));
                } else {
                    reject(new Error('Une erreur s\'est produite lors de la récupération des codes des cours d\'eau. Statut de la requête: ' + this.status));
                }
            }
        };
        xhr.open('GET', 'php/getCodesCoursEau.php', true);
        xhr.send();
    });
}

// Fonction pour obtenir les deltas pour chaque cours d'eau et les stocker dans le tableau
async function getDeltasForCoursEau() {
    try {
        // Récupérer les codes des cours d'eau depuis le serveur
        const codes_cours_eau = await getCodesCoursEau();

        // Pour chaque code de cours d'eau, récupérer le delta et le stocker dans le tableau
        for (const code_cours_eau of codes_cours_eau) {
            const delta = await getDelta(annee1, annee2, code_cours_eau);
            deltas_cours_eau.push({ code_cours_eau, delta });
            console.log(`Delta pour ${code_cours_eau} : ${delta}`);
        }
        console.log("Deltas des cours d'eau:", deltas_cours_eau);
    } catch (error) {
        console.error('Une erreur s\'est produite lors de la récupération des deltas des cours d\'eau:', error);
    }
}

// Appeler la fonction pour obtenir les deltas pour chaque cours d'eau
getDeltasForCoursEau();



