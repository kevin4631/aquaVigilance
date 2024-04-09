function envoyerAvis(avis) {
    var xhr = new XMLHttpRequest();

    // Définir la fonction de rappel à exécuter lorsque la réponse est reçue
    xhr.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                // Ci-dessous on traite la réponse quand elle arrive
                console.log("Réponse du serveur : " + JSON.parse(xhr.responseText));
            } else {
                console.log("Réponse du serveur : " + this.status);
            }
        }
    };

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var params = "reponse=" + avis;
    
    xhr.open("POST", "/laisser_avis", true);
    xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}

document.querySelector("#oui").addEventListener("click", function () {
    document.querySelector('#avis').style.display = 'none';
    envoyerAvis('oui');
});

document.querySelector("#non").addEventListener("click", function () {
    document.querySelector('#avis').style.display = 'none';
    envoyerAvis('non');
});
