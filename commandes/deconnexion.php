<?php
// Démarrer la session
session_start();

// Désactiver le cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Redirection vers la page de connexion
header('Location: ../index.php');
exit();
?>