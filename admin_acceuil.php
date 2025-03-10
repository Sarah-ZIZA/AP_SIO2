<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id="favicon" rel="shortcut icon" href="./assets/img/logo.png" type="image/x-png" />
    <title>LPFSClinique</title>
    <link rel="stylesheet" href="../stylesAdmin.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,300&display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Graphique à Barres avec Chart.js</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <?php
    // Démarrer la session (si ce n'est pas déjà fait)
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Vérifier si l'email de l'administrateur est dans la session
    if (!isset($_SESSION['admin_email'])) {
        header("Location:../404/404.html"); // Rediriger vers la page 404
        exit(); // Assure-toi que le script s'arrête après la redirection
    }


    // Récupérer l'email de l'administrateur
    $admin_email = htmlspecialchars($_SESSION['admin_email'], ENT_QUOTES, 'UTF-8');

    // Extraire la partie avant '@' de l'email
    $admin_name = htmlspecialchars(explode('@', $admin_email)[0], ENT_QUOTES, 'UTF-8');
    ?>

    <header>

        <div class="border_top"></div>
        <i class='bx bxs-left-arrow-square' onclick="document.getElementById('decoForm').submit();"></i>

        <form id="decoForm" action="../formulaires/deconnexion.php" method="post" style="display: none;"></form>

        <nav>
            <div class="logo">
                <img src="../assets/img/logo.png" alt="logo">
            </div>
            <ul class="menu">
                <li class="has-submenue">
                    <a href="admin_acceuil.php" class="menu-link">Accueil <span class="toggle-icon"></span></a>
                </li>

                <li class="has-submenu">
                    <a href="#">Services <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="admin_service.php?modal=true">Inscrire un service</a></li>

                        <li><a href="admin_service.php" data-target="list-service">Liste des services</a></li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#">Patients <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="../formulaires/formulaires_patients.php" data-target="add-patient">Inscrire un
                                patient</a></li>
                        <li><a href="admin_patient.php" data-target="list-patient">Liste des patients</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">Patient_couverture <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">

                        <li><a href="admin_couvert.php" data-target="list-hospital">Liste des couverture_scl</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">Personnels <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="../formulaires/formulaires_personnels.php" data-target="add-personnel">Inscrire un
                                personnel</a>
                        </li>
                        <li><a href="admin_pro.php" data-target="list-personnel">Liste du personnel</a>
                        </li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#">Hospitalisation <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">

                        <li><a href="admin_hos.php" data-target="list-hospital">Liste des hospitalisations</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">Chambres <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="admin_chambre.php?modal=true" data-target="add-hospital">Ajouter une Chambre</a>
                        </li>
                        <li><a href="admin_chambre.php" data-target="list-hospital">Liste des Chambres</a></li>
                    </ul>
                </li>

            </ul>

            <div class="boutons_droite">
                <div class="boutons_id">
                    <button id="btn-user" class="btn-user" data-nom="<?php echo $admin_name; ?>"
                        onclick="toggleNomUtilisateur()">
                        <svg class="user-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M12,12.5c-3.04,0-5.5,1.73-5.5,3.5s2.46,3.5,5.5,3.5,5.5-1.73,5.5-3.5-2.46-3.5-5.5-3.5Zm0-.5c1.66,0,3-1.34,3-3s-1.34-3-3-3-3,1.34-3,3,1.34,3,3,3Z">
                            </path>
                        </svg>
                        <span class="btn-text">Utilisateur</span>
                    </button>
                </div>

            </div>
        </nav>
    </header>
    <main>

        <div class="graph1" style="width: 800px; height: 400px;">
            <canvas id="myBarChart"></canvas>
        </div>
        <div class="graph2" style="width: 600px; height: 400px;">
            <canvas id="myDoughnutChart"></canvas>
        </div>


    </main>
    <script src="app.js"></script>
    <script src="../scripts_admin.js"></script>
</body>
<footer></footer>

<!-- Script pour alterner le texte au clic -->
<script>
    function toggleNomUtilisateur() {
        // Récupérer le bouton, le texte et le nom utilisateur
        const bouton = document.getElementById('btn-user');
        const texte = bouton.querySelector('.btn-text');
        const nomUtilisateur = bouton.getAttribute('data-nom');

        // Vérifier le texte actuel et basculer
        if (texte.textContent === "Utilisateur") {
            texte.textContent = nomUtilisateur; // Afficher le nom
        } else {
            texte.textContent = "Utilisateur"; // Revenir au texte par défaut
        }
    }
</script>

<script>
    //script des liste deroulante
    document.addEventListener("DOMContentLoaded", function () {
        const menuItems = document.querySelectorAll(".has-submenu > a");

        menuItems.forEach(item => {
            item.addEventListener("click", function (event) {
                event.preventDefault(); // Empêcher le lien de naviguer ailleurs

                const parentLi = this.parentElement;

                // Vérifier si ce menu est déjà ouvert
                const isOpen = parentLi.classList.contains("open");

                // Fermer tous les autres menus
                document.querySelectorAll(".has-submenu").forEach(menu => {
                    menu.classList.remove("open");
                });

                // Ouvrir ou fermer le menu actuel
                if (!isOpen) {
                    parentLi.classList.add("open");
                }
            });
        });

        // Fermer le menu si on clique ailleurs
        document.addEventListener("click", function (event) {
            if (!event.target.closest(".menu")) {
                document.querySelectorAll(".has-submenu").forEach(menu => {
                    menu.classList.remove("open");
                });
            }
        });
    });

</script>


</script>
</body>


</html>