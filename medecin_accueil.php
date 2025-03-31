<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id="favicon" rel="shortcut icon" href="../assets/img/logo.png" type="image/x-png" />
    <title>LPFSClinique</title>
    <link rel="stylesheet" href="stylesMedecin.css" />
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
        <i class='bx bxs-left-arrow-square' onclick="document.getElementById('decoForm').submit();"></i>

        <form id="decoForm" action="../commandes/deconnexion.php" method="post" style="display: none;"></form>

        <nav>
            <div class="logo">
                <img src="../assets/img/logo.png" alt="logo">
            </div>

                <!-- <li class="has-submenu">
                    <a href="#">Services <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="admin_service.php?modal=true">Inscrire un service</a></li>

                        <li><a href="admin_service.php" data-target="list-service">Liste des services</a></li>
                    </ul>
                </li> -->
                <!-- <li class="has-submenu">
                    <a href="#">Personnels <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="../admin_form/formulaires_personnels.php" data-target="add-personnel">Inscrire un
                                personnel</a>
                        </li>
                        <li><a href="admin_pro.php" data-target="list-personnel">Liste du personnel</a>
                        </li>
                    </ul>
                </li> -->
                <!-- <li class="has-submenu">
                    <a href="#">Chambres <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="admin_chambre.php?modal=true" data-target="add-hospital">Ajouter une Chambre</a>
                        </li>
                        <li><a href="admin_chambre.php" data-target="list-hospital">Liste des Chambres</a></li>
                    </ul>
                </li> -->

            </ul>
        </nav>
    </header>
  <form method="GET" action="">
    <label for="mois">Filtrer par mois :</label>
    <select name="mois" id="mois">
        <option value="">Choisir un mois</option>
        <option value="1" <?php if (isset($_GET['mois']) && $_GET['mois'] == '1') echo 'selected'; ?>>Janvier</option>
        <option value="2" <?php if (isset($_GET['mois']) && $_GET['mois'] == '2') echo 'selected'; ?>>Février</option>
        <option value="3" <?php if (isset($_GET['mois']) && $_GET['mois'] == '3') echo 'selected'; ?>>Mars</option>
        <option value="4" <?php if (isset($_GET['mois']) && $_GET['mois'] == '4') echo 'selected'; ?>>Avril</option>
        <option value="5" <?php if (isset($_GET['mois']) && $_GET['mois'] == '5') echo 'selected'; ?>>Mai</option>
        <option value="6" <?php if (isset($_GET['mois']) && $_GET['mois'] == '6') echo 'selected'; ?>>Juin</option>
        <option value="7" <?php if (isset($_GET['mois']) && $_GET['mois'] == '7') echo 'selected'; ?>>Juillet</option>
        <option value="8" <?php if (isset($_GET['mois']) && $_GET['mois'] == '8') echo 'selected'; ?>>Août</option>
        <option value="9" <?php if (isset($_GET['mois']) && $_GET['mois'] == '9') echo 'selected'; ?>>Septembre</option>
        <option value="10" <?php if (isset($_GET['mois']) && $_GET['mois'] == '10') echo 'selected'; ?>>Octobre</option>
        <option value="11" <?php if (isset($_GET['mois']) && $_GET['mois'] == '11') echo 'selected'; ?>>Novembre</option>
        <option value="12" <?php if (isset($_GET['mois']) && $_GET['mois'] == '12') echo 'selected'; ?>>Décembre</option>
    </select>
    <label for="annee">Filtrer par année :</label>
    <select name="annee" id="annee">
        <option value="">Choisir une année</option>
        <?php
        // Remplacer l'année actuelle par les années disponibles dans la base de données
        $current_year = date("Y");
        for ($i = 0; $i < 5; $i++) {
            $year = $current_year - $i; // Remplacez par les années de votre choix
            echo "<option value='$year' " . (isset($_GET['annee']) && $_GET['annee'] == $year ? 'selected' : '') . ">$year</option>";
        }
        ?>
    </select>
    <button type="submit">Filtrer</button>
  </form>
  <h2>Liste des Rendez-vous</h2>
  <?php
        $serveur = "localhost";
        $utilisateur = "root";
        $motDePasse = "sio2024";
        $nomBDD = "AP_SIO2";

        try {
          $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
          $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $table5 = "hospitalisation";
          $table1 = "professionnels";
          $table2 = "services";
          $mois = isset($_GET['mois']) ? $_GET['mois'] : '';
          $annee = isset($_GET['annee']) ? $_GET['annee'] : '';
          if ($mois && strlen($mois) == 1) {
            $mois = '0' . $mois; // Ajouter un zéro devant les mois à un chiffre
          }
          // Récupérer le terme de recherche (si présent)
          $recherche = isset($_GET['recherche_page5']) ? $_GET['recherche_page5'] : '';

          // Récupérer les données de la table
          // Si une recherche est soumise, préparer la requête filtrée
          if ($recherche) {
            $requete1 = $connexion->prepare("SELECT pré_ad, date_hos, heure, Adresse_mail_utilisateur FROM $table5 WHERE id_patient LIKE ? ");
            $requete1->execute(['%' . $recherche . '%']);
            if ($requete1) {
                $requete1 == false;
                echo "<p>Aucun résultat trouvé.</p>";
            }
        } else {
            // Construire la requête en fonction de l'année et du mois sélectionné
            if ($annee && $mois) {
                // Si une année et un mois sont sélectionnés, filtrer par les deux
                $requete1 = $connexion->prepare("SELECT DISTINCT patient.nom, patient.prénom, hospitalisation.pré_ad, hospitalisation.date_hos, hospitalisation.heure, hospitalisation.chambre_num
                FROM hospitalisation, patient
                WHERE patient.id_patient = hospitalisation.id_patient
                AND hospitalisation.Adresse_mail LIKE :admin_email
                AND YEAR(hospitalisation.date_hos) = :annee
                AND MONTH(hospitalisation.date_hos) = :mois");
                $requete1->execute([':admin_email' => "%$admin_email%", ':mois' => $mois, ':annee' => $annee]);
            } elseif ($annee) {
                // Si seulement l'année est sélectionnée, filtrer uniquement par année
                $requete1 = $connexion->prepare("SELECT DISTINCT patient.nom, patient.prénom, hospitalisation.pré_ad, hospitalisation.date_hos, hospitalisation.heure, hospitalisation.chambre_num
                FROM hospitalisation, patient
                WHERE patient.id_patient = hospitalisation.id_patient
                AND hospitalisation.Adresse_mail LIKE :admin_email
                AND YEAR(hospitalisation.date_hos) = :annee");
                $requete1->execute([':admin_email' => "%$admin_email%", ':annee' => $annee]);
            } elseif ($mois) {
                // Si seulement le mois est sélectionné, filtrer uniquement par mois
                $requete1 = $connexion->prepare("SELECT DISTINCT patient.nom, patient.prénom, hospitalisation.pré_ad, hospitalisation.date_hos, hospitalisation.heure, hospitalisation.chambre_num
                FROM hospitalisation, patient
                WHERE patient.id_patient = hospitalisation.id_patient
                AND hospitalisation.Adresse_mail LIKE :admin_email
                AND MONTH(hospitalisation.date_hos) = :mois");
                $requete1->execute([':admin_email' => "%$admin_email%", ':mois' => $mois]);
            } else {
                // Si aucun mois ou année n'est sélectionné, récupérer tous les rendez-vous
                $requete1 = $connexion->prepare("SELECT DISTINCT patient.nom, patient.prénom, hospitalisation.pré_ad, hospitalisation.date_hos, hospitalisation.heure, hospitalisation.chambre_num
                FROM hospitalisation, patient
                WHERE patient.id_patient = hospitalisation.id_patient
                AND hospitalisation.Adresse_mail LIKE :admin_email");
                $requete1->execute([':admin_email' => "%$admin_email%"]);
            }
        }
          $resultats1 = $requete1->fetchAll(PDO::FETCH_ASSOC);

          echo "<div class='table-container'>";
          echo "<table border ='2'>";

          // Vérification si la table est vide
          if (!empty($resultats1)) {

            // Affichage des en-têtes de colonnes
            echo "<tr>";
            foreach ($resultats1[0] as $colonne => $valeur) {
              echo "<th>$colonne</th>";
            }
            echo "</tr>";

            // Affichage des lignes
            foreach ($resultats1 as $ligne) {
              echo "<tr>";
              foreach ($ligne as $valeur) {
                echo "<td>" . htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8') . "</td>";
              }
              echo "</tr>";
            }
          } else {

            // Si la table est vide, récupérer les colonnes pour afficher les en-têtes uniquement
            $requeteColonnes = $connexion->query("DESCRIBE $table5");
            $colonnes = $requeteColonnes->fetchAll(PDO::FETCH_COLUMN);
            echo "<tr>";
            foreach ($colonnes as $colonne) {
              echo "<th>$colonne</th>";
            }
            echo "</tr>";

            // Ajouter un message pour indiquer qu'aucune donnée n'est disponible
            echo "<tr><td colspan='" . count($colonnes) . "'>Aucune donnée disponible</td></tr>";
          }

          echo "</table>";
          echo "</div>";
        } catch (PDOException $e) {
          echo "Erreur de connexion : " . $e->getMessage();
        }
        ?>
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
</body>
</html>
