<?php
// ajax_data.php

error_reporting(E_ALL);
ini_set('display_errors', 1); // Afficher les erreurs PHP

header('Content-Type: application/json');

$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "sio2024";
$nomBDD = "AP_SIO2";

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['ajax'])) {
        if ($_GET['ajax'] == 'patients') {
            // Requête pour le Bar Chart (Nombre de patients par mois)
            $requete = $connexion->prepare("SELECT MONTH(hospitalisation.date_hos) AS mois, 
                                                    DATE_FORMAT(hospitalisation.date_hos, '%b') AS mois_nom, 
                                                    COUNT(*) AS total 
                                             FROM patient 
                                             INNER JOIN hospitalisation ON hospitalisation.id_patient = patient.id_patient 
                                             GROUP BY mois 
                                             ORDER BY mois");
            $requete->execute();

            $data = ['labels' => [], 'patients' => []];

            while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {
                $data['labels'][] = $row['mois_nom'];
                $data['patients'][] = (int) $row['total'];
            }

            echo json_encode($data);
            exit;
        } elseif ($_GET['ajax'] == 'hospitalisations') {
            // Requête pour le Doughnut Chart (Hospitalisations par type)
            $sql = "SELECT MONTH(date_hos) AS mois, 
                           DATE_FORMAT(date_hos, '%b') AS mois_nom,
                           pré_ad, 
                           COUNT(*) AS total 
                    FROM hospitalisation 
                    WHERE pré_ad IN ('Hospitalisation', 'Ambulatoire chururgie') 
                    GROUP BY mois, mois_nom, pré_ad
                    ORDER BY mois";

            $stmt = $connexion->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $labels = [];
            $chirurgie = [];
            $nuit = [];

            // Initialiser les mois avec 0
            for ($i = 1; $i <= 12; $i++) {
                $labels[$i] = date("M", mktime(0, 0, 0, $i, 1));
                $chirurgie[$i] = 0;
                $nuit[$i] = 0;
            }

            // Remplir avec les vraies données
            foreach ($data as $row) {
                $mois = (int) $row['mois'];
                if ($row['pré_ad'] == 'Ambulatoire chururgie') {
                    $chirurgie[$mois] = (int) $row['total'];
                } elseif ($row['pré_ad'] == 'Hospitalisation') {
                    $nuit[$mois] = (int) $row['total'];
                }
            }

            $response = [
                "labels" => array_values($labels),
                "chirurgie" => array_values($chirurgie),
                "nuit" => array_values($nuit),
            ];

            echo json_encode($response);
            exit;
        }
    }

    // Si aucun paramètre AJAX valide n'est fourni
    echo json_encode(['error' => 'Requête invalide']);
    exit;
} catch (PDOException $e) {
    echo json_encode(['error' => "Erreur : " . $e->getMessage()]);
    exit;
}
?>