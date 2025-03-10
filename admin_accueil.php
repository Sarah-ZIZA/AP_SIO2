<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>LPFS</title>
    <link rel="stylesheet" href="stylesAdmin.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,300&display=swap" rel="stylesheet" />

</head>

<body>
    <?php
    if (isset($_SESSION['login'])) {
        ?>
        <div class="container">
            <div class="gauche">
                <div class="logos">
                    <img src="assets/img/logo.png" height="400px" />
                </div>
            </div>
            <div class="droite">
                <form class="btndeco" action="formulaires/deconnexion.php" style="position:relative;float:right;">
                    <button class="full-rounded">
                        <span>Deconnexion</span>
                        <div class="border full-rounded"></div>
                    </button>
                </form>
                <div class="heading">Accueil Admin</div>
                <a href="formulaires/formulaires_personnels.php"><img class="accueil" src="assets/img/inscription.png"></a>
                <h2>Inscriptions</h2>
                <a href="admin.php"><img class="accueil" src="assets/img/professionnel.png"></a>
                <h2>Données</h2>
            </div>
        </div>
        <?php
    }
    ?>
</body>

</html>