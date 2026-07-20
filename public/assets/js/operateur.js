/**
 * Operateur - activation de la validation Bootstrap (front-end)
 * pour les formulaires du back-office operateur (frais, prefixe, login).
 * N'affecte pas la logique/les routes existantes : bloque simplement
 * l'envoi tant que les criteres de validation ne sont pas respectes,
 * et affiche les messages d'erreur Bootstrap correspondants.
 */
(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var forms = document.querySelectorAll(".op-needs-validation");

    Array.prototype.slice.call(forms).forEach(function (form) {
      form.addEventListener(
        "submit",
        function (event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add("was-validated");
        },
        false
      );
    });

    // Coherence min/max pour les formulaires de frais : le montant max
    // doit rester superieur ou egal au montant min (cote client uniquement,
    // la regle serveur reste gérée par le modele).
    var minInput = document.querySelector('[data-op-role="montant-min"]');
    var maxInput = document.querySelector('[data-op-role="montant-max"]');

    if (minInput && maxInput) {
      var syncMinMax = function () {
        if (minInput.value !== "") {
          maxInput.min = minInput.value;
        }
      };
      minInput.addEventListener("input", syncMinMax);
      syncMinMax();
    }
  });
})();
