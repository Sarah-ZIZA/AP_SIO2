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
  <link rel="stylesheet" href="stylesAdmin.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,300&display=swap" rel="stylesheet" />
</head>

<body>
  <?php
  // Démarrer la session (si ce n'est pas déjà fait)
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  // Vérifier si l'email de l'administrateur est dans la session
  if (!isset($_SESSION['admin_email'])) {
    header("Location:404/404.html"); // Rediriger vers la page 404
    exit(); // Assure-toi que le script s'arrête après la redirection
  }


  // Récupérer l'email de l'administrateur
  $admin_email = htmlspecialchars($_SESSION['admin_email'], ENT_QUOTES, 'UTF-8');

  // Extraire la partie avant '@' de l'email
  $admin_name = htmlspecialchars(explode('@', $admin_email)[0], ENT_QUOTES, 'UTF-8');
  ?>

  <header>

    <i class='bx bxs-left-arrow-square' onclick="document.getElementById('decoForm').submit();"></i>

    <form id="decoForm" action="deconnexion.php" method="post" style="display: none;"></form>

    <nav>
      <div class="logo">
        <img src="assets/img/logo.png" alt="logo">
      </div>
      <ul class="menu">
        <li class="has-submenu">
          <a href="#">Accueil <span class="toggle-icon"></a>

        </li>

        <li class="has-submenu">
          <a href="#">Services <span class="toggle-icon">▼</span></a>
          <ul class="submenu">
            <li><a href="#" data-target="add-service">Inscrire un service</a></li>
            <li><a href="#" data-target="list-service">Liste des services</a></li>
          </ul>
        </li>

        <li class="has-submenu">
          <a href="#">Patients <span class="toggle-icon">▼</span></a>
          <ul class="submenu">
            <li><a href="formulaires/formulaires_patients.php" data-target="add-patient">Inscrire un patient</a></li>
            <li><a href="admin/admin_patient.php" data-target="list-patient">Liste des patients</a></li>
          </ul>
        </li>

        <li class="has-submenu">
          <a href="#">Personnels <span class="toggle-icon">▼</span></a>
          <ul class="submenu">
            <li><a href="formulaires/formulaires_personnels.php" data-target="add-personnel">Inscrire un
                personnel</a>
            </li>
            <li><a href="../admin.php#page2" data-target="list-personnel">Liste du personnel</a>
            </li>
          </ul>
        </li>

        <li class="has-submenu">
          <a href="#">Hospitalisation <span class="toggle-icon">▼</span></a>
          <ul class="submenu">

            <li><a href="admin/admin_hos.php" data-target="list-hospital">Liste des hospitalisations</a></li>
          </ul>
        </li>
        <li class="has-submenu">
          <a href="#">Chambres <span class="toggle-icon">▼</span></a>
          <ul class="submenu">
            <li><a href="#" data-target="add-hospital">Ajouter une Chambre</a></li>
            <li><a href="#" data-target="list-hospital">Liste des Chambres</a></li>
          </ul>
        </li>
      </ul>

      <div class="boutons_droite">
        <div class="boutons_id">
          <button id="btn-user" class="btn-user" data-nom="<?php echo $admin_name; ?>" onclick="toggleNomUtilisateur()">
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
    <section class="page active" id="page1">
      <div class="global">
        <?php
        $serveur = "localhost";
        $utilisateur = "root";
        $motDePasse = "sio2024";
        $nomBDD = "AP_SIO2";

        try {
          $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
          $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $table1 = "professionnels";

          $requete1 = $connexion->prepare("SELECT * FROM $table1");
          $requete1->execute();
          $resultats1 = $requete1->fetchAll(PDO::FETCH_ASSOC);


          echo "<h2>Liste des Professionnels</h2>";
          echo "<div class='table-container'>";
          echo "<table border ='2'>";
          echo "<tr>";
          foreach ($resultats1[0] as $colonne => $valeur) {
            echo "<th>$colonne</th>";
          }
          echo "</tr>";

          foreach ($resultats1 as $ligne) {
            echo "<tr>";
            foreach ($ligne as $valeur) {
              echo "<td>$valeur</td>";
            }
            echo "</tr>";
          }
          echo "</table>";
          echo "</div>";
        } catch (PDOexception $e) {
          echo "Erreur de connexion : " . $e->getMessage();
        }
        ?>
      </div>
    </section>
    <section class="page" id="page2">
      <div class="global">
        <?php
        $serveur = "localhost";
        $utilisateur = "root";
        $motDePasse = "sio2024";
        $nomBDD = "AP_SIO2";

        try {
          $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
          $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $table1 = "services";

          // Vérifier si une suppression ou une modification a été soumise
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['supprimer']) && !empty($_POST['selection'])) {
              // Suppression des services sélectionnés
              $ids = $_POST['selection'];
              $placeholders = implode(',', array_fill(0, count($ids), '?'));
              $requeteSuppression = $connexion->prepare("DELETE FROM $table1 WHERE id_service IN ($placeholders)");
              $requeteSuppression->execute($ids);
            } elseif (isset($_POST['modifier']) && !empty($_POST['modifications'])) {
              foreach ($_POST['modifications'] as $id => $valeurService) {
                // Si la valeur est un tableau, ignorer pour éviter les erreurs
                if (is_array($valeurService)) {
                  continue;
                }

                $requeteModification = $connexion->prepare("UPDATE $table1 SET service = ? WHERE id_service = ?");
                $requeteModification->execute([$valeurService, $id]);
              }
            }

          }

          // Récupérer les données mises à jour
          $requete1 = $connexion->prepare("SELECT * FROM $table1");
          $requete1->execute();
          $resultats1 = $requete1->fetchAll(PDO::FETCH_ASSOC);

          // Afficher le tableau des services
        
          echo "<h2>Services</h2>";
          echo "<div class='table-container'>";
          echo "<form method='post' action='admin.php'>"; // Un seul formulaire global
          echo "<table border='2'>";
          echo "<tr>";
          echo "<th>Sélection</th>";
          foreach ($resultats1[0] as $colonne => $valeur) {
            echo "<th>$colonne</th>";
          }
          echo "</tr>";

          foreach ($resultats1 as $ligne) {
            $idService = $ligne['id_service'];
            echo "<tr>";
            echo "<td><input type='checkbox' name='selection[]' value='" . htmlspecialchars($idService, ENT_QUOTES, 'UTF-8') . "'></td>";
            echo "<td>" . htmlspecialchars($idService, ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td><input type='text' name='modifications[" . htmlspecialchars($idService, ENT_QUOTES, 'UTF-8') . "]' value='" . htmlspecialchars($ligne['service'], ENT_QUOTES, 'UTF-8') . "'></td>";
            echo "</tr>";
          }

          echo "</table>";
          echo "</div>";
          echo "<div class='boutons_modif'>";
          echo "<button class='btn' type='submit' name='supprimer'>Supprimer</button>";
          echo "<button class='btn' type='submit' name='modifier'>Modifier</button>";
          echo "</div>";
          echo "</form>";
        } catch (PDOException $e) {
          echo "Erreur de connexion : " . $e->getMessage();
        }
        ?>
      </div>
    </section>
    <section class="page" id="page3">

      <div class="global">
        <?php
        $serveur = "localhost";
        $utilisateur = "root";
        $motDePasse = "sio2024";
        $nomBDD = "AP_SIO2";

        try {
          $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
          $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $table1 = "patient";

          // Vérifier si une suppression ou une modification a été soumise
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['supprimer']) && !empty($_POST['selection'])) {
              // Suppression des services sélectionnés
              $ids = $_POST['selection'];
              $placeholders = implode(',', array_fill(0, count($ids), '?'));
              $requeteSuppression = $connexion->prepare("DELETE FROM $table1 WHERE id_patient IN ($placeholders)");
              $requeteSuppression->execute($ids);
            } elseif (isset($_POST['modifier']) && !empty($_POST['modifications'])) {
              foreach ($_POST['modifications'] as $id => $colonnes) {
                if (!is_array($colonnes)) {
                  continue; // Ignorer si ce n'est pas un tableau
                }

                foreach ($colonnes as $colonne => $valeur) {
                  $requeteModification = $connexion->prepare("UPDATE $table1 SET $colonne = ? WHERE id_patient = ?");
                  $requeteModification->execute([$valeur, $id]);
                }
              }
            }


          }

          // Récupérer les données mises à jour
          $requete1 = $connexion->prepare("SELECT * FROM $table1");
          $requete1->execute();
          $resultats1 = $requete1->fetchAll(PDO::FETCH_ASSOC);

          // Afficher le tableau des services
        

          echo "<h2>Patients</h2>";
          echo "<div class='table-container'>";
          echo "<form method='post' action='admin.php'>"; // Un seul formulaire global
          echo "<table border='2'>";
          echo "<tr>";
          echo "<th>Sélection</th>";

          if (!empty($resultats1)) {
            // Affichage des en-têtes de colonne
            foreach ($resultats1[0] as $colonne => $valeur) {
              echo "<th>$colonne</th>";
            }
            echo "</tr>";

            // Affichage des lignes si la table contient des données
            foreach ($resultats1 as $ligne) {
              $idpatient = $ligne['id_patient']; // Correctement extraire la clé id_patient
              echo "<tr>";
              echo "<td><input type='checkbox' name='selection[]' value='" . htmlspecialchars($idpatient, ENT_QUOTES, 'UTF-8') . "'></td>";
              foreach ($ligne as $colonne => $valeur) {
                if ($colonne === 'id_patient') {
                  // La clé primaire ne doit pas être modifiable
                  echo "<td>" . htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8') . "</td>";
                } else {
                  // Générer un champ de saisie pour toutes les autres colonnes
                  echo "<td><input type='text' name='modifications[" . htmlspecialchars($idpatient, ENT_QUOTES, 'UTF-8') . "][" . htmlspecialchars($colonne, ENT_QUOTES, 'UTF-8') . "]' value='" . htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8') . "'></td>";
                }
              }
              echo "</tr>";
            }
          } else {
            // Si la table est vide, afficher les en-têtes par défaut
            $requeteColonnes = $connexion->query("DESCRIBE $table1");
            $colonnes = $requeteColonnes->fetchAll(PDO::FETCH_COLUMN);
            foreach ($colonnes as $colonne) {
              echo "<th>$colonne</th>";
            }
            echo "</tr>";
            echo "<tr><td colspan='" . (count($colonnes) + 1) . "'>Aucune donnée disponible</td></tr>";
          }

          echo "</table>";
          echo "</div>";
          echo "<div class='boutons_modif'>";
          echo "<button class='btn' type='submit' name='supprimer'>Supprimer</button>";
          echo "<button class='btn' type='submit' name='modifier'>Modifier</button>";
          echo "</div>";
          echo "</form>";


        } catch (PDOException $e) {
          echo "Erreur de connexion : " . $e->getMessage();
        }
        ?>
      </div>
    </section>
    <section class="page" id="page4">
      <form method="get" action="admin.php#page4" onsubmit="scrollToPage4()">
        <input type="text" name="recherche_page4" style="width: 50%; height:41px; border:none;border-radius:10px;"
          placeholder="Rechercher par nom ou prénom"
          value="<?php echo isset($_GET['recherche_page4']) ? htmlspecialchars($_GET['recherche_page4'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <button class="btn" type="submit">Rechercher</button>
      </form>

      <div class="global">
        <?php
        try {
          $serveur = "localhost";
          $utilisateur = "root";
          $motDePasse = "sio2024";
          $nomBDD = "AP_SIO2";

          $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
          $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $table1 = "professionnels";
          // Récupérer le terme de recherche (si présent)
          $recherche = isset($_GET['recherche_page4']) ? $_GET['recherche_page4'] : '';

          // Gestion des actions (supprimer ou modifier)
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['supprimer']) && !empty($_POST['selection'])) {
              $ids = $_POST['selection'];
              $placeholders = implode(',', array_fill(0, count($ids), '?'));
              $requeteSuppression = $connexion->prepare("DELETE FROM $table1 WHERE Adresse_mail IN ($placeholders)");
              $requeteSuppression->execute($ids);
            }

            if (isset($_POST['modifier']) && !empty($_POST['modifications'])) {
              foreach ($_POST['modifications'] as $ancienneAdresse => $colonnes) {
                $nouvelleAdresse = $colonnes['Adresse_mail'] ?? null;
                unset($colonnes['Adresse_mail']); // On traite Adresse_mail séparément
        
                foreach ($colonnes as $colonne => $valeur) {
                  $requeteModification = $connexion->prepare("UPDATE $table1 SET $colonne = ? WHERE Adresse_mail = ?");
                  $requeteModification->execute([$valeur, $ancienneAdresse]);
                }

                if ($nouvelleAdresse && $nouvelleAdresse !== $ancienneAdresse) {
                  $requeteValidation = $connexion->prepare("SELECT COUNT(*) FROM $table1 WHERE Adresse_mail = ?");
                  $requeteValidation->execute([$nouvelleAdresse]);
                  if ($requeteValidation->fetchColumn() > 0) {
                    echo "Erreur : L'adresse email '$nouvelleAdresse' est déjà utilisée.";
                    continue;
                  }

                  $requeteModification = $connexion->prepare("UPDATE $table1 SET Adresse_mail = ? WHERE Adresse_mail = ?");
                  $requeteModification->execute([$nouvelleAdresse, $ancienneAdresse]);
                }
              }
            }
          }

          // Si une recherche est soumise, préparer la requête filtrée
          if ($recherche) {
            $requete1 = $connexion->prepare("SELECT * FROM $table1 WHERE Nom LIKE ? OR Prénom LIKE ?");
            $requete1->execute(['%' . $recherche . '%', '%' . $recherche . '%']);
          } else {
            // Si pas de recherche, récupérer toutes les données
            $requete1 = $connexion->prepare("SELECT * FROM $table1");
            $requete1->execute();
          }

          // Récupérer les résultats
          $resultats1 = $requete1->fetchAll(PDO::FETCH_ASSOC);

          if (empty($resultats1)) {
            echo "Erreur : Aucune donnée récupérée.";
          } else {
            echo "<h2>Professionnels</h2>";
            echo "<div class='table-container'>";
            echo "<form method='post' action='admin.php'>";
            echo "<table border='2'>";
            echo "<tr><th>Sélection</th>";

            // En-têtes de colonnes
            foreach ($resultats1[0] as $colonne => $valeur) {
              echo "<th>$colonne</th>";
            }
            echo "</tr>";

            // Lignes de la table
            foreach ($resultats1 as $ligne) {
              $ancienneAdresseMail = $ligne['Adresse_mail'] ?? null;

              if (!$ancienneAdresseMail) {
                echo "<tr><td colspan='" . (count($ligne) + 1) . "'>Erreur : Clé 'Adresse_mail' manquante.</td></tr>";
                continue;
              }

              echo "<tr>";
              if ($ligne['id_poste'] !== '1') { // Non administrateur
                echo "<td><input type='checkbox' name='selection[]' value='" . htmlspecialchars($ancienneAdresseMail, ENT_QUOTES) . "'></td>";
                foreach ($ligne as $colonne => $valeur) {
                  if ($colonne === 'Mdp') {
                    echo "<td>
                     <div class='password-wrapper'>
                        <span class='password-display' style='display: none;'>" . htmlspecialchars($valeur, ENT_QUOTES) . "</span>
                        <span class='password-hidden'>••••••••</span>
                        <span class='toggle-password' onclick='togglePassword(this)'>🙈</span>
                      </div>
                </td>";
                  } else {
                    echo "<td><input type='text' name='modifications[" . htmlspecialchars($ancienneAdresseMail, ENT_QUOTES) . "][" . htmlspecialchars($colonne, ENT_QUOTES) . "]' value='" . htmlspecialchars($valeur, ENT_QUOTES) . "'></td>";
                  }
                }
              } else { // Administrateur
                echo "<td></td>";
                foreach ($ligne as $colonne => $valeur) {
                  if ($colonne === 'Mdp') {
                    echo "<td>
                      <div class='password-wrapper'>
                        <span class='password-display' style='display: none;'>" . htmlspecialchars($valeur, ENT_QUOTES) . "</span>
                        <span class='password-hidden'>••••••••</span>
                        <span class='toggle-password' onclick='togglePassword(this)'>🙈</span>
                      </div>
                    </td>
                    ";
                  } else {
                    echo "<td>" . htmlspecialchars($valeur, ENT_QUOTES) . "</td>";
                  }
                }
              }
              echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
            echo "<div class='boutons_modif'>";
            echo "<button class='btn' type='submit' name='supprimer'>Supprimer</button>";
            echo "<button class='btn' type='submit' name='modifier'>Modifier</button>";
            echo "</div>";
            echo "</form>";

          }
        } catch (PDOException $e) {
          echo "Erreur de connexion : " . $e->getMessage();
        }
        ?>
      </div>
    </section>

    <section class="page" id="page5">
      <form method="get" action="admin.php#page5" onsubmit="scrollToPage5()">
        <input class="recherche" type="text" name="recherche_page5"
          style="width: 50%; height:41px; border:none;border-radius:10px;" placeholder="Rechercher id_patient"
          value="<?php echo isset($_GET['recherche_page5']) ? htmlspecialchars($_GET['recherche_page5'], ENT_QUOTES, 'UTF-8') : ''; ?>">
        <button class="btn" type="submit">Rechercher</button>
      </form>
      <div class="global">
        <?php
        $serveur = "localhost";
        $utilisateur = "root";
        $motDePasse = "sio2024";
        $nomBDD = "AP_SIO2";

        try {
          $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD", $utilisateur, $motDePasse);
          $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $table5 = "Hospitalisation";
          // Récupérer le terme de recherche (si présent)
          $recherche = isset($_GET['recherche_page5']) ? $_GET['recherche_page5'] : '';

          // Récupérer les données de la table
          // Si une recherche est soumise, préparer la requête filtrée
          if ($recherche) {
            $requete1 = $connexion->prepare("SELECT * FROM $table5 WHERE id_patient LIKE ? ");
            $requete1->execute(['%' . $recherche . '%']);
            if ($requete1) {
              $requete1 == false;
              echo "<p>Aucun résultat trouvé.</p>";
            }
            ;
          } else {
            // Si pas de recherche, récupérer toutes les données
            $requete1 = $connexion->prepare("SELECT * FROM $table5");
            $requete1->execute();
          }
          $resultats1 = $requete1->fetchAll(PDO::FETCH_ASSOC);

          echo "<h2>Liste des Hospitalisations</h2>";
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
      </div>
    </section>



  </main>

  <footer></footer>
  <script src="scripts_admin.js"></script>
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
    function togglePassword(element) {
      const wrapper = element.closest('.password-wrapper');
      const hidden = wrapper.querySelector('.password-hidden');
      const display = wrapper.querySelector('.password-display');

      if (hidden.style.display === 'none') {
        hidden.style.display = 'inline';
        display.style.display = 'none';
        element.textContent = "🙈"; // Icône pour afficher
      } else {
        hidden.style.display = 'none';
        display.style.display = 'inline';
        element.textContent = "👁️"; // Icône pour cacher
      }
    }
  </script>

  <script>
    // Fonction pour faire défiler la page vers la section #page4 après la recherche
    function scrollToPage4() {
      setTimeout(function () {
        document.getElementById('page4').scrollIntoView({ behavior: 'smooth' });
      }, 0); // Ajout d'un léger délai pour s'assurer que la page a bien été rechargée
    }
    function scrollToPage5() {
      setTimeout(function () {
        document.getElementById('page5').scrollIntoView({ behavior: 'smooth' });
      }, 0); // Ajout d'un léger délai pour s'assurer que la page a bien été rechargée
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
</body>


</html>