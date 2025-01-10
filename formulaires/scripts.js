// Sélection des éléments HTML pour les étapes et les pages
const etapes = document.querySelectorAll(".etape");
const pages = document.querySelectorAll(".page");
let currentEtape = 0;

// Initialisation au chargement de la page
window.onload = () => {
  // Activer la première page et la première étape dès le chargement
  pages[0].classList.add("active");
  etapes[0].classList.add("active");

  // Initialisation de la validation des champs
  initValidation();

  // Ajout d'un événement "click" pour chaque bouton "next" (suivant)
  document.querySelectorAll(".next").forEach((button) => {
    button.addEventListener("click", nextPage);
  });

  // Ajout d'un événement "click" pour chaque bouton "prev" (précédent)
  document.querySelectorAll(".prev").forEach((button) => {
    button.addEventListener("click", previousPage);
  });
};

// Fonction pour initialiser la validation des champs
function initValidation() {
  pages.forEach((page, index) => {
    const nextButton = page.querySelector(".next");
    if (nextButton) {
      // Vérifie la validité initiale
      nextButton.disabled = !validatePage(page);

      // Ajoute un écouteur sur tous les champs de la page
      const inputs = page.querySelectorAll("input, select, textarea");
      inputs.forEach((input) => {
        input.addEventListener("input", () => {
          nextButton.disabled = !validatePage(page);
        });
      });
    }
  });
}

// Fonction pour valider les champs de la page actuelle
function validatePage(page) {
  const inputs = page.querySelectorAll("input, select, textarea");
  for (let input of inputs) {
    if (input.required && !input.checkValidity()) {
      return false;
    }
  }
  return true;
}

// Fonction pour passer à l'étape suivante
function nextPage() {
  if (currentEtape < etapes.length - 1) {
    pages[currentEtape].classList.remove("active");
    etapes[currentEtape].classList.remove("active");
    currentEtape++;
    pages[currentEtape].classList.add("active");
    etapes[currentEtape].classList.add("active");
  }
}

// Fonction pour revenir à l'étape précédente
function previousPage() {
  if (currentEtape > 0) {
    pages[currentEtape].classList.remove("active");
    etapes[currentEtape].classList.remove("active");
    currentEtape--;
    pages[currentEtape].classList.add("active");
    etapes[currentEtape].classList.add("active");
  }
}

// Fonction pour convertir une date ISO (YYYY-MM-DD) en DD/MM/YYYY
function convertirDate(dateISO) {
  const parts = dateISO.split("-");
  return "${parts[2]}/${parts[1]}/${parts[0]}; // Format Jour/Mois/Année";
}

// Fonction appelée lors de la soumission du formulaire
function traiterFormulaire(event) {
  event.preventDefault(); // Empêche le rechargement de la page

  const dateNaissance = document.getElementById("annee_naissance").value;

  if (!dateNaissance) {
    alert("Veuillez sélectionner une date valide.");
    return false;
  }

  const dateFormatFr = convertirDate(dateNaissance);

  document.getElementById("resultat").innerHTML =
    "<p><strong>Date au format ISO (YYYY-MM-DD) :</strong> ${dateNaissance}</p>";
  ("<p><strong>Date au format FR (DD/MM/YYYY) :</strong> ${dateFormatFr}</p>");

  return false;
}

// Validation progressive du numéro de sécurité sociale
document
  .getElementById("num_secu_sociale")
  .addEventListener("blur", function () {
    const input = this; // Référence à l'élément input
    const sexe = document.getElementById("sexe").value; // Sexe (1 ou 2)
    const dateNaissance = document.getElementById("annee_naissance").value; // Format : YYYY-MM-DD
    const numSecu = input.value; // Numéro de sécurité sociale saisi
    const nextButton = pages[currentEtape].querySelector(".next"); // Bouton "Suivant" de l'étape actuelle

    let valid = true; // Par défaut, supposons que le numéro est valide

    // Vérification si le champ est vide
    if (!numSecu) {
      alert("Le numéro de sécurité sociale est obligatoire.");
      valid = false;
    }

    // Vérification de la longueur du numéro
    if (numSecu.length !== 15) {
      alert(
        "Le numéro de sécurité sociale doit contenir exactement 15 chiffres."
      );
      valid = false;
    }

    // Validation avec regex
    const regex =
      /^[12][0-9]{2}[0-1][0-9](2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}[0-9]{2}$/;
    if (!regex.test(numSecu)) {
      alert(
        "Le numéro de sécurité sociale est invalide. Assurez-vous qu'il est au bon format."
      );
      valid = false;
    }

    // Vérifications des correspondances avec les informations fournies
    if (valid) {
      const [anneeNaissance, moisNaissance] = dateNaissance.split("-");
      const numSecuSexe = numSecu.charAt(0);
      const numSecuAnnee = parseInt(numSecu.slice(1, 3), 10); // Année (2 chiffres)
      const numSecuMois = numSecu.slice(3, 5); // Mois

      const anneeSecuComplete =
        numSecuAnnee + (parseInt(anneeNaissance, 10) >= 2000 ? 2000 : 1900);

      if (numSecuSexe !== sexe) {
        valid = false;
        alert("Le sexe ne correspond pas au numéro de sécurité sociale.");
      }

      if (anneeSecuComplete !== parseInt(anneeNaissance, 10)) {
        valid = false;
        alert(
          "L'année de naissance ne correspond pas au numéro de sécurité sociale."
        );
      }

      if (numSecuMois !== moisNaissance) {
        valid = false;
        alert(
          "Le mois de naissance ne correspond pas au numéro de sécurité sociale."
        );
      }
    }

    // Mise à jour de l'état du bouton "Suivant"
    if (nextButton) {
      nextButton.disabled = !valid;
    }

    if (valid) {
      alert("Le numéro de sécurité sociale est valide.");
    }
  });
//script AJAX

// Stockez la liste initiale des villes dans une variable
var initialVilleOptions = document.getElementById("Ville").innerHTML;

function updateVille(event) {
  var cp = event.value;
  var villeElement = document.getElementById("Ville");

  if (cp !== "") {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_ville.php?cp=" + cp, true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        villeElement.innerHTML = xhr.responseText;
      }
    };
    xhr.send();
  } else {
    // Réinitialiser la liste des villes à son état initial
    villeElement.innerHTML = initialVilleOptions;
  }
}

function updateCp() {
  var ville = document.getElementById("Ville").value;
  if (ville) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_cp.php?ville=" + ville, true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        document.getElementById("Cp").value = xhr.responseText;
        //document.getElementById("Cp").innerHTML = xhr.responseText;
        //a tester//document.getElementById("Cp").value = xhr.responseText; // Utilise 'value' au lieu de 'innerHTML' }
      }
    };
    xhr.send();
  }
}

// Bloquer les heures passées si la date est aujourd'hui
function verifierDateEtHeure() {
  const dateInput = document.getElementById("date");
  const timeInput = document.getElementById("heure");
  const now = new Date();

  // Récupère la date actuelle en format YYYY-MM-DD
  const today = now.toISOString().split("T")[0];

  // Vérifie si la date sélectionnée est aujourd'hui
  if (dateInput.value === today) {
    // Si c'est aujourd'hui, bloque les heures passées
    const heures = String(now.getHours()).padStart(2, "0");
    const minutes = String(now.getMinutes()).padStart(2, "0");
    timeInput.min = `${heures}:${minutes}`;
  } else {
    // Si ce n'est pas aujourd'hui, débloque toutes les heures
    timeInput.min = "";
  }
}

// Mise à jour de la vérification lors de changements dans les champs date ou heure
const dateInput = document.getElementById("date");
const timeInput = document.getElementById("heure");

// Vérifie au chargement de la page
dateInput.addEventListener("change", verifierDateEtHeure);
timeInput.addEventListener("focus", verifierDateEtHeure);

// Définir la date minimale (par exemple : aujourd'hui)
const today = new Date().toISOString().split("T")[0];
dateInput.min = today;

// recuperation automatique
$(document).ready(function () {
  // Quand le champ "nom" change
  $("#nom").on("blur", function () {
    const nom = $(this).val(); // Récupérer la valeur saisie

    // Envoyer une requête AJAX
    $.ajax({
      url: "check_user.php", // Fichier PHP qui vérifie le nom
      type: "POST",
      data: { nom: nom },
      dataType: "json", // Retour attendu en JSON

      success: function (response) {
        console.log("Requête envoyée avec le nom :", nom); // Avant l'envoi de la requête
        console.log("Réponse reçue :", response); // Après réception de la réponse

        if (response.success) {
          // Remplir les champs avec les données retournées
          $("#prenom").val(response.prenom);
          $("#annee_naissance").val(response.annee_naissance);
          $("#num_secu_sociale").val(response.num_secu_sociale);
        } else {
          alert("Aucun utilisateur trouvé. Veuillez remplir les informations.");
          // Réinitialiser les champs si aucune donnée trouvée
          $("#prenom").val("");
          $("#annee_naissance").val("");
          $("#num_secu_sociale").val("");
        }
      },
      error: function () {
        alert("Erreur lors de la vérification.");
      },
    });
  });

  // Gestion de la soumission du formulaire
  $("#patientForm").on("submit", function (e) {
    e.preventDefault(); // Empêche le rechargement de la page
    // Envoyer les données à un autre script PHP pour l'insertion
    $.ajax({
      url: "insertion.php",
      type: "POST",
      data: $(this).serialize(), // Sérialiser les données du formulaire
      success: function (response) {
        alert("Données enregistrées avec succès.");
      },
      error: function () {
        alert("Erreur lors de l'enregistrement.");
      },
    });
  });
});
