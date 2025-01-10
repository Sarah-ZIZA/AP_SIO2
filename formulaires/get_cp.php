<?php
require 'connexion.php';

if (isset($_GET['ville'])) {
    $ville = $_GET['ville'];
    $sql = "SELECT DISTINCT code_postal FROM communes WHERE nom_commune = :ville";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['ville' => $ville]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($rows as $row) {
        echo htmlspecialchars($row['code_postal']); // Renvoie uniquement le code postal
    }
}
?>