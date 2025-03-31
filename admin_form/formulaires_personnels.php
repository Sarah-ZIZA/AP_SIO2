<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id="favicon" rel="shortcut icon" href="../assets/img/logo.png" type="image/x-png" />
    <title>LPFSClinique</title>
    <link rel="stylesheet" href="../assets/style_form/Style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,300&display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body id="page-top">
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

    // Afficher l'email pour vérification (optionnel, à retirer en production)
    // echo '<p>Administrateur connecté : ' . $admin_email . '</p>';
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
            <ul class="menu">
                <li class="has-submenue">
                    <a href="../admin/admin_acceuil.php">Accueil <span class="toggle-icon"></a>
                </li>

                <li class="has-submenu">
                    <a href="#">Services <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="../admin/admin_service.php?modal=true">Inscrire un service</a></li>

                        <li><a href="../admin/admin_service.php" data-target="list-service">Liste des services</a></li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#">Patients <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="formulaires_patients.php" data-target="add-patient">Inscrire un
                                patient</a>
                        </li>
                        <li><a href="../admin/admin_patient.php" data-target="list-patient">Liste des patients</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">Patient_couverture <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">

                        <li><a href="../admin/admin_couvert.php" data-target="list-hospital">Liste descouverture_scl</a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">Personnels <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="formulaires_personnels.php" data-target="add-personnel">Inscrire un
                                personnel</a>
                        </li>
                        <li><a href="../admin/admin_pro.php" data-target="list-personnel">Liste du personnel</a>
                        </li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="#">Hospitalisation <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">

                        <li><a href="../admin/admin_hos.php" data-target="list-hospital">Liste des hospitalisations</a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">Chambres <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">
                        <li><a href="../admin/admin_chambre.php?modal=true" data-target="add-hospital">Ajouter une
                                Chambre</a>
                        </li>
                        <li><a href="../admin/admin_chambre.php" data-target="list-hospital">Liste des Chambres</a></li>
                    </ul>
                </li>
            </ul>


        </nav>
    </header>


    <section id="main">
        <img src="../assets/img/logo.png" height="200px" />
        <h1 align="Center" class="Titre">FORMULAIRE D'INSCRIPTION DU PERSONNELS</h1>
        <!-- <header>
            <div class="etape-container">
                <div class="etape active" id="etape1">
                    <div class="cercle">1</div>
                    <p>HOSPITALISATION</p>
                </div>

                <div class="line"></div>
                <div class="etape" id="etape2">
                    <div class="cercle">2</div>
                    <p>PATIENT</p>
                </div>
                <div class="line"></div>
                <div class="etape" id="etape3">
                    <div class="cercle">3</div>
                    <p>CONCTACT_URG</p>
                </div>
                <div class="line"></div>
                <div class="etape" id="etape4">
                    <div class="cercle">4</div>
                    <p>COUVERTURE_SCL</p>
                </div>
                <div class="line"></div>
                <div class="etape" id="etape5">
                    <div class="cercle">5</div>
                    <p>DOCUMENTS</p>
                </div>
            </div>

        </header> -->

        <br>
        <br>

        <?php
        // Connexion à la base de données
        require '../commandes/connexion.php';

        ?>
        <form action="" method="POST">

            <h2>INFORMATIONS REQUIES </h2>
            <section class="forms">

                <div>
                    <label for="nom_N">Nom<span>*</span></label><br>
                    <input class="input" type="text" name="Nom" minlength="2" maxlength="25" id="nom" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+"
                        required>
                </div>

                <div>
                    <label for="prénom">Prénom <span>*</span></label><br>
                    <input class="input" type="text" name="prénom" minlength="2" maxlength="25" id="prenom"
                        pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+" required>
                </div>
                <div>
                    <label for="Date_N">Date de naissance<span>*</span></label><br>
                    <input class="input" id="annee_naissance" type="date" name="date_N" min="1904-01-01"
                        max="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div>
                    <label for="email">Email<span>*</span></label><br>
                    <input class="input" name="email" type="email" value="@lpfs.com" required>
                </div>
                <div>
                    <label for="Mdp">Mot de passe<span>*</span></label><br>
                    <input placeholder="Mdp" class="input" name="Mdp" type="text" id="mdp" readonly />
                </div>
                <div>
                    <label for="poste">Id_Poste<span>*</span></label><br>
                    <select class="input" name="id_poste" id="poste" required>
                        <option value="">Choisissez un poste</option> <!-- Option par défaut -->
                        <?php
                        // Récupération des médecins depuis la base de données
                        $sql = "SELECT *  FROM poste ";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            // Sécurisation et affichage des options
                            echo "<option value='" . htmlspecialchars($row['id_poste']) . "'>" . htmlspecialchars($row['role']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>

                    <label for="services">Id_service<span>*</span></label><br>
                    <select class="input" name="id_service" id="service" required>
                        <option value="">Choisissez un Service</option> <!-- Option par défaut -->
                        <?php
                        // Récupération des médecins depuis la base de données
                        $sql = "SELECT *  FROM services ";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            // Sécurisation et affichage des options
                            echo "<option value='" . htmlspecialchars($row['id_service']) . "'>" . htmlspecialchars($row['service']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <!--<div>
                <label for="email">Email<span>*</span></label><br>
                <input class="input" name="email" type="email" required>
            </div>
             <div>
                <label for="tel">Téléphone<span>*</span></label><br>
                <input class="input" type="tel" name="phone" minlength="10" maxlength="10" pattern="^0[1-9][0-9]{8}$"
                    title="Numéro de téléphone français valide (format : 01XXXXXXXX)" required>
                ^0[1-9] : Le numéro commence toujours par un zéro, suivi d'un chiffre entre 1 et 9.
                    [0-9]{8} : ces deux premiers chiffres, il y a exactement 8 autres chiffres, tous compris entre
                    0 et 9.
                    $ : Fin de la chaîne. 
            </div> -->

                <button class="submit" name="submit" type="submit">Valider</button>
                </div>
            </section>
            <input type="hidden" name="admin_email"
                value="<?php echo htmlspecialchars($admin_email, ENT_QUOTES, 'UTF-8'); ?>">
        </form>

        <?php
        // Démarrer la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Inclusion de la connexion à la base de données
        require '../commandes/connexion.php';

        // Vérification si un administrateur est connecté
        if (!isset($_SESSION['admin_email'])) {
            die("<p style='color:red;'>Erreur : Aucun administrateur connecté.</p>");
        }
        $admin_email = $_SESSION['admin_email']; // Récupération de l'email de l'administrateur
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                // Démarrer une transaction
                $conn->beginTransaction(); // Commence une nouvelle transaction
        
                // Récupération des données envoyées depuis le formulaire
                $nom = $_POST['Nom'] ?? null;
                $prenom = $_POST['prénom'] ?? null;
                $date_naissance = $_POST['date_N'] ?? null;
                $email = $_POST['email'] ?? null;
                $Mot_de_passe = $_POST['Mdp'] ?? null;
                $poste = $_POST['id_poste'] ?? null;
                $service = $_POST['id_service'] ?? null;

                // Insertion dans la table `professionnels`
                $sql_hosp = "INSERT INTO professionnels (Nom, Prénom, Date_Naissance, Adresse_mail, Mdp, id_poste, id_service, Adresse_mail_utilisateur)
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_hosp = $conn->prepare($sql_hosp);
                $stmt_hosp->execute([$nom, $prenom, $date_naissance, $email, $Mot_de_passe, $poste, $service, $admin_email]);

                // Commit de la transaction
                $conn->commit(); // Validation de la transaction
        
                echo "<script>
                        alert('Insertion réussie');
                        window.location.href = 'formulaires_personnels.php';
                      </script>";
            } catch (PDOException $e) {
                // Annuler la transaction en cas d'erreur
                $conn->rollBack();
                die("Erreur : " . $e->getMessage());
            }
        }

        ?>


        <script src="scripts.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </section>
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
        var uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var lowercase = 'abcdefghijklmnopqrstuvwxyz';
        var numbers = '0123456789';
        var spécialcase = '@}]|[{#~µ%/.?*!:;,ù^$¨€&';

        var pass = '';

        // Générer une lettre majuscule
        pass += uppercase.charAt(Math.floor(Math.random() * uppercase.length));

        // Générer une lettre minuscule
        pass += lowercase.charAt(Math.floor(Math.random() * lowercase.length));

        // Générer un chiffre
        pass += numbers.charAt(Math.floor(Math.random() * numbers.length));
        // Générer les caractère spéciaux
        pass += spécialcase.charAt(Math.floor(Math.random() * spécialcase.length));

        // Remplir le reste du mot de passe avec des caractères aléatoires
        for (var i = 3; i < 10; i++) {
            var allCharacters = uppercase + lowercase + numbers + spécialcase;
            pass += allCharacters.charAt(Math.floor(Math.random() * allCharacters.length));
        }

        // Mélanger les caractères du mot de passe
        pass = pass.split('').sort(function () { return 0.5 - Math.random() }).join('');

        // Afficher le mot de passe généré dans l'input correspondant
        document.getElementById('mdp').value = pass;
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