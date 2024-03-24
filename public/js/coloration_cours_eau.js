// Fonction pour obtenir une couleur entre le bleu et le rouge en fonction d'une valeur donnée
function getColor(value) {
    // Convertir la valeur en un nombre entre 0 et 1
    var normalizedValue = (value + 5) / 10;

    // Calculer les composantes RGB en fonction de la valeur normalisée
    var red = Math.round(255 * normalizedValue);
    var blue = Math.round(255 * (1 - normalizedValue));
    var green = 0;

    // Retourner la couleur au format CSS RGB
    return 'rgb(' + red + ',' + green + ',' + blue + ')';
}

var sizeInput = document.getElementById("size");
    var size2Input = document.getElementById("size2");

    sizeInput.addEventListener("input", function() {
        var currentValue = parseInt(sizeInput.value);
        size2Input.min = currentValue + 1;
    });

    document.querySelectorAll('input[type="range"]').forEach(function(input) {
        input.addEventListener("input", function() {
            var label = this.nextElementSibling;
            label.innerText = this.value;
        });
    });

    