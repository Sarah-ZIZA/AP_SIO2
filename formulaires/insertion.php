<?php
// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclusion de la connexion à la base de données
require 'connexion.php';

// Vérification si un administrateur est connecté
if (!isset($_SESSION['admin_email'])) {
    die("<p style='color:red;'>Erreur : Aucun administrateur connecté.</p>");
}
$admin_email = $_SESSION['admin_email']; // Récupération de l'email de l'administrateur

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    try {
        // Récupération des données envoyées depuis le formulaire
        $pre_ad = $_POST['pre_ad'] ?? null;
        $date_hos = $_POST['date'] ?? null;
        $heure = $_POST['heure'] ?? null;
        $chambre = $_POST['Chambre'] ?? null;
        $adresse_mail_medecin = $_POST['medecin'] ?? null;

        // Données du patient
        $civ = $_POST['Sexe'] ?? null;
        $nom_naissance = $_POST['Nom_naissance'] ?? null;
        $nom_epouse = $_POST['Nom_épouse'] ?? null;
        $prenom = $_POST['prénom'] ?? null;
        $date_naissance = $_POST['date_N'] ?? null;
        $adresse_patient = $_POST['adresse'] ?? null;
        $cp = $_POST['Cp'] ?? null;
        $ville = $_POST['ville'] ?? null;
        $email = $_POST['email'] ?? null;
        $tel_patient = $_POST['phone'] ?? null;
        $carte_identité = $_POST['carte_indentité'] ?? null;
        $carte_vitale = $_POST['carte_vitale'] ?? null;
        $carte_mutuelle = $_POST['carte_mutuelle'] ?? null;
        $Livre_famille = $_POST['Livre_famille'] ?? null;

        // Données de la personne à prévenir et de confiance
        $nom_contact = $_POST['Nom_contact'] ?? null;
        $prenom_contact = $_POST['Prénom_contact'] ?? null;
        $tel_contact = $_POST['phone_contact'] ?? null;
        $adresse_contact = $_POST['adresse_contact'] ?? null;

        $nom_confiance = $_POST['Nom_confiance'] ?? null;
        $prenom_confiance = $_POST['Prénom_confiance'] ?? null;
        $tel_confiance = $_POST['phone_confiance'] ?? null;
        $adresse_confiance = $_POST['adresse_confiance'] ?? null;

        // Données de la couverture sociale
        $nom_organisation = $_POST['organisation'] ?? null;
        $num_securite_sociale = $_POST['Sécurité_sociale'] ?? null;
        $statut_assurance = $_POST['assurance_statut'] ?? null;
        $statut_ADL = $_POST['ADL_statut'] ?? null;
        $nom_mutuelle = $_POST['Nom_mutuelle'] ?? null;
        $Nom_Adhérant = $_POST['Nom_ADR'] ?? null;

        // Vérification du numéro de sécurité sociale
        if (!preg_match('/^[12]/', $num_securite_sociale)) {
            die("<h2>Numéro de sécurité sociale incorrect</h2>");
        }

        // Insertion dans les différentes tables
        $conn->beginTransaction(); // Début de transaction

        // Insertion dans la table `personne_contact`
        $sql_contact = "INSERT INTO personne_contact (nom, prenom, tel, adresse) VALUES (?, ?, ?, ?)";
        $stmt_contact = $conn->prepare($sql_contact);
        $stmt_contact->execute([$nom_contact, $prenom_contact, $tel_contact, $adresse_contact]);
        $id_contact = $conn->lastInsertId();

        // Insertion dans la table `personne_confiance`
        $sql_confiance = "INSERT INTO personne_confiance (nom, prenom, tel, adresse) VALUES (?, ?, ?, ?)";
        $stmt_confiance = $conn->prepare($sql_confiance);
        $stmt_confiance->execute([$nom_confiance, $prenom_confiance, $tel_confiance, $adresse_confiance]);
        $id_confiance = $conn->lastInsertId();

        // Insertion dans la table `couverture`
        $sql_couverture = "INSERT INTO couverture (org_sécu, num_sécu, ass_statut, ALD_statut, nom_Mutuelle, nom_adhérent)
                           VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_couverture = $conn->prepare($sql_couverture);
        $stmt_couverture->execute([$nom_organisation, $num_securite_sociale, $statut_assurance, $statut_ADL, $nom_mutuelle, $Nom_Adhérant]);

        // Insertion dans la table `chambre`
        $sql_chambre = "INSERT INTO chambres(type) VALUES(?)";
        $stmt_chambre = $conn->prepare($sql_chambre);
        $stmt_chambre->execute([$chambre]);
        $id_chambre = $conn->lastInsertId();

        // Insertion dans la table `patient`
        $sql_patient = "INSERT INTO patient (civilité, nom, prénom, nom_épouse, date_naissance, adresse_patient, CP, ville, email, tel_patient, carte_vitale, carte_identité, carte_mutuelle, livretF, id_personne1, id_personne2, num_sécu)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_patient = $conn->prepare($sql_patient);
        $stmt_patient->execute([$civ, $nom_naissance, $prenom, $nom_epouse, $date_naissance, $adresse_patient, $cp, $ville, $email, $tel_patient, $carte_vitale, $carte_identité, $carte_mutuelle, $Livre_famille, $id_contact, $id_confiance, $num_securite_sociale]);
        $id_patient = $conn->lastInsertId();

        // Insertion dans la table `hospitalisation`
        $sql_hosp = "INSERT INTO hospitalisation (pré_ad, date_hos, heure, id_patient, Adresse_mail, Adresse_mail_utilisateur, id_chambre)
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_hosp = $conn->prepare($sql_hosp);
        $stmt_hosp->execute([$pre_ad, $date_hos, $heure, $id_patient, $adresse_mail_medecin, $admin_email, $id_chambre]);

        $conn->commit(); // Validation de la transaction

        echo "<script>
            alert('Insertion réussie');
            window.location.href = 'formulaire.php';
        </script>";
    } catch (PDOException $e) {
        $conn->rollBack(); // Annuler la transaction en cas d'erreur
        die("Erreur : " . $e->getMessage());
    }
}
?>