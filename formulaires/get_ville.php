<?php
require 'connexion.php';

if (isset($_GET['cp'])) {
    $cp = $_GET['cp'];
    $sql = "SELECT DISTINCT nom_commune FROM communes WHERE code_postal = :cp ";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['cp' => $cp]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        echo "<option value='" . htmlspecialchars($row['nom_commune']) . "'>" . htmlspecialchars($row['nom_commune']) . "</option>";
    }
}
?>