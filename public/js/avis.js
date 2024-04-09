function envoyerAvis() {
    // Créer une instance de l'objet XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Spécifier la méthode HTTP et l'URL de la route à laquelle vous souhaitez envoyer la requête
    xhr.open("GET", "/votre-route", true);

    // Définir la fonction de rappel à exécuter lorsque la réponse est reçue
    xhr.onreadystatechange = function () {
        // Vérifier si la requête est terminée et que la réponse est prête
        if (xhr.readyState === 4 && xhr.status === 200) {
            // La réponse a été reçue avec succès
            console.log("votre avis à bien etait envoyé");
        }
    };

    // Envoyer la requête
    xhr.send();
}


document.querySelector("#oui").addEventListener("click", function () {
    document.querySelector('#avis').style.display = 'none'
});

document.querySelector("#non").addEventListener("click", function () {
    document.querySelector('#avis').style.display = 'none'
});