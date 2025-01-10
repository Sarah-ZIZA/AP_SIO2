<?php
include 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';

    // Vérification dans la base de données
    $query = $pdo->prepare("SELECT nom, prenom, date_naissance, numero_securite FROM patients WHERE nom = ?");
    $query->execute([$nom]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Retourner les données en JSON
        echo json_encode([
            'success' => true,
            'prenom' => $user['prenom'],
            'date_naissance' => $user['date_naissance'],
            'numero_securite' => $user['numero_securite']
        ]);
    } else {
        // Aucun utilisateur trouvé
        echo json_encode(['success' => false]);
    }
}
?>