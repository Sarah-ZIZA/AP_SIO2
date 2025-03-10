<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPFSClinique<img src="assets/img/logo.png"></title>
    <link rel="stylesheet" href="Style.css" />
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
        <i class='bx bxs-left-arrow-square' onclick="document.getElementById('decoForm').submit();"></i>

        <form id="decoForm" action="deconnexion.php" method="post" style="display: none;"></form>

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
                        <li><a href="formulaires_patients.php" data-target="add-patient">Inscrire un patient</a></li>
                        <li><a href="../admin/admin_patient.php" data-target="list-patient">Liste des patients</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">Patient_couverture <span class="toggle-icon">▼</span></a>
                    <ul class="submenu">

                        <li><a href="../admin/admin_couvert.php" data-target="list-hospital">Liste des
                                couverture_scl</a></li>
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
                        <li><a href="#" data-target="add-hospital">Ajouter une Chambre</a></li>
                        <li><a href="#" data-target="list-hospital">Liste des Chambres</a></li>
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
    <section id="main">
        <img src="../assets/img/logo.png" height="200px" />
        <h1 align="Center" class="Titre">FORMULAIRE DE PRE-INSCRIPTION</h1>
        <header>
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

        </header>

        <br>
        <br>

        <?php
        // Connexion à la base de données
        require 'connexion.php';

        ?>
        <form id="patientForm" action="insertion.php" method="POST">
            <input type="hidden" name="form_origin" value="formulaires_patients.php">
            <div class="page" id="page1">
                <h2>INFORMATION CONCERNANT L'HOSPITALISATION</h2>
                <section class="forms">
                    <div>


                        <label for="Pré-ad"> Pré-admission pour:<span>*</span></label><br>
                        <select class="input" name="pre_ad" required>
                            <option value="">Choix</option>
                            <option value="Ambulatoire chururgie">Chirurgie Ambulatoire</option>
                            <option value="Hospitalisation">Hospitalisation(au moins une nuit)</option>
                        </select>
                    </div>
                    <div>
                        <label for="date">Date d'hospitalisation<span>*</span></label><br>
                        <input class="input" id="date" type="date" name="date" min="<?php echo date('Y-m-d'); ?>"
                            max="<?php echo date('Y-m-d', strtotime('+2 year')); ?>" required><br>

                    </div>
                    <div> <label for="heure">Heure de l'intervention<span>*</span></label><br>
                        <input class="input" type="time" id="heure" name="heure" required>
                    </div>
                    <div>
                        <label for="Nom_m">Nom du médecin:<span>*</span></label><br>
                        <select class="input" name="medecin" id="Nom_m" required>
                            <option value="">Choisissez un médecin</option> <!-- Option par défaut -->
                            <?php
                            // Récupération des médecins depuis la base de données
                            $sql = "SELECT Nom, Adresse_mail FROM professionnels WHERE id_poste=3";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                // Sécurisation et affichage des options
                                echo "<option value='" . htmlspecialchars($row['Adresse_mail']) . "'>" . htmlspecialchars($row['Nom']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="Chambre">Chambre particulière?<span>*</span></label><br>
                        <select class="input" name="Chambre" required>
                            <option value="">Choix</option>
                            <?php
                            // Récupération des chambres et de leur statut
                            $sql_chambres = "SELECT chambres.num_chambre, type.Type_chambre
                         FROM chambres
                         INNER JOIN type ON chambres.type = type.Type_chambre";
                            $result = $conn->query($sql_chambres);

                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $num_chambre = $row['num_chambre'];
                                $type_chambre = $row['Type_chambre'];

                                // Vérifier combien de fois cette chambre a été réservée
                                $sql_count = "SELECT COUNT(*) FROM hospitalisation WHERE chambre_num = ? AND type_chambre = ?";
                                $stmt_count = $conn->prepare($sql_count);
                                $stmt_count->execute([$num_chambre, $type_chambre]);
                                $count = $stmt_count->fetchColumn();

                                // Condition pour désactiver l'option si le nombre de réservations est atteint
                                $disabled = false;
                                if (($type_chambre === 'Simple' && $count >= 1) || ($type_chambre === 'Double' && $count >= 2)) {
                                    $disabled = true;
                                }

                                $disabled_attr = $disabled ? 'disabled' : ''; // Désactiver l'option si nécessaire
                                echo "<option value='" . htmlspecialchars($num_chambre . '|' . $type_chambre) . "' $disabled_attr>" . htmlspecialchars($num_chambre . ' - ' . $type_chambre) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button class="next" type="button">Suivant</button>
                </section>
            </div>
            <div class="page" id="page2">
                <h2>INFORMATIONS CONCERNANT LE PATIENT</h2>
                <section class="forms">
                    <div>
                        <label for="Civ">Civ<span>*</span></label><br>
                        <select class="input" id="sexe" name="Sexe" type="text" required>
                            <option value="">Choix</option>
                            <option value="1">Homme</option>
                            <option value="2">Femme</option>
                        </select>
                    </div>
                    <div>
                        <label for="nom_N">Nom de naissance <span>*</span></label><br>
                        <input class="input" type="text" name="Nom_naissance" minlength="2" maxlength="25" id="nom"
                            pattern="[A-Z\s]+" required>
                    </div>
                    <div>
                        <label for="nom_d'épouse">Nom d'épouse</label><br>
                        <input class="input" type="text" name="Nom_épouse" minlength="2" pattern="[A-Za-z]+">
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
                        <label for="adresse">Adresse<span>*</span></label><br>
                        <input class="input" type="text" name="adresse" minlength="15" maxlength="38" required>
                    </div>
                    <div>
                        <label for="Cp">CP<span>*</span></label><br>

                        <input class="input" type="text" name="Cp" id="Cp" minlength="5" maxlength="5" pattern="[0-9]*"
                            onfocusout="updateVille(this)" required>
                        <!-- <select id="Cp" class="input" name="Cp" required onchange="updateVille()">
                        <option value="">Sélectionnez un code postal</option>
                        <!?php
                        $sql = "SELECT DISTINCT code_postal FROM communes ";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($row['code_postal']) . "'>" . htmlspecialchars($row['code_postal']) . "</option>";
                        }
                        ?>
                    </select> -->
                    </div>
                    <div>

                        <label for="Ville">Ville<span>*</span></label><br>
                        <select id="Ville" class="input" name="ville" required onchange="updateCp(this)">
                            <option value="">Sélectionnez une ville</option>
                            <--?php $sql="SELECT DISTINCT  nom_commune FROM communes order by id LIMIT 200 " ;
                                $result=$conn->query($sql);
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "
                                </ /option value='" . htmlspecialchars($row[' nom_commune']) . "'>" .
                                    htmlspecialchars($row['nom_commune']) . "</option>" ; } ?>
                        </select>
                    </div>


                    <div>
                        <label for="email">Email<span>*</span></label><br>
                        <input class="input" name="email" type="email" required>
                    </div>
                    <div>
                        <label for="tel">Téléphone<span>*</span></label><br>
                        <input class="input" type="tel" name="phone" minlength="10" maxlength="10"
                            pattern="^0[1-9][0-9]{8}$" title="Numéro de téléphone français valide (format : 01XXXXXXXX)"
                            required>
                        <!-- ^0[1-9] : Le numéro commence toujours par un zéro, suivi d'un chiffre entre 1 et 9.
                    [0-9]{8} : ces deux premiers chiffres, il y a exactement 8 autres chiffres, tous compris entre
                    0 et 9.
                    $ : Fin de la chaîne. -->
                    </div>
                    <button class="prev" type="button">Précédent</button>
                    <button class="next" type="button">Suivant</button>
                </section>
            </div>
            <div class="page" id="page3">

                <div>

                    <h2>COORDONNEES PERSONNE A PREVENIR</h2>
                    <section class="forms">
                        <div>
                            <label for="nom">Nom</label><br>
                            <input class="input" type="text" name="Nom_contact" pattern="[A-Z\s]+" required>
                        </div>
                        <div>
                            <label for="prénom">Prénom</label><br>
                            <input class="input" type="text" name="Prénom_contact" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+"
                                required>

                        </div>
                        <div>
                            <label for="tel">Téléphone</label><br>
                            <input class="input" type="text" name="phone_contact" minlength="10" maxlength="10"
                                pattern="^0[1-9][0-9]{8}$"
                                title="Numéro de téléphone français valide (format : 01XXXXXXXX)" required>
                        </div>
                        <div>
                            <label for="adresse">Adresse</label><br>
                            <input class="input" type="text" name="adresse_contact" minlength="15" maxlength="38"
                                required>
                        </div>
                    </section>
                </div>
                <div>
                    <h2>COORDONNEES PERSONNE DE CONFIANCE</h2>
                    <section class="forms">
                        <div>
                            <label for="nom">Nom</label><br>
                            <input class="input" type="text" name="Nom_confiance" pattern="[A-Z\s]+" required>
                        </div>
                        <div>
                            <label for="prénom">Prénom</label><br>
                            <input class="input" type="text" name="Prénom_confiance" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+"
                                required>

                        </div>
                        <div>
                            <label for="tel">Téléphone</label><br>
                            <input class="input" type="text" name="phone_confiance" minlength="10" maxlength="10"
                                pattern="^0[1-9][0-9]{8}$"
                                title="Numéro de téléphone français valide (format : 01XXXXXXXX)" required>
                        </div>
                        <div>
                            <label for="adresse">Adresse</label><br>
                            <input class="input" type="text" name="adresse_confiance" minlength="15" maxlength="38"
                                required>
                        </div>
                    </section>
                    <button class="prev" type="button">Précédent</button>
                    <button class="next" type="button">Suivant</button>
                </div>


            </div>

            <div class="page" id="page4">
                <h2>INFORMATION CONCERNANT LA COUVERTURE SOCIALE</h2>
                <section class="forms">
                    <div>
                        <label for="org">Organisme SS/Nom CAM
                            <span>*</span></label><br>
                        <input class="input" type="text" name="organisation"
                            placeholder="Ex:CPAM du tarn et Garronne,CPAM du lot,RSI,MSA..." required>
                    </div>
                    <div>
                        <label for="Num_Sociale">Numéro de sécurité sociale
                            <span>*</span></label><br>
                        <input class="input" id="num_secu_sociale" type="text" name="Sécurité_sociale" minlength="15"
                            maxlength="15" title="Numéro de sécurité sociale français valide"
                            pattern="^[12][0-9]{2}[0-1][0-9](2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}[0-9]{2}$" required>

                    </div>

                    <div>
                        <label for="Assuré">Le patient est-il l'assuré?<span>*</span></label><br>
                        <select class="input" name="assurance_statut" id="" required>
                            <option value="">Choix</option>
                            <option value="OUI">OUI</option>
                            <option value="NON">NON</option>
                        </select>
                    </div>
                    <div>
                        <label for="ADL">Le patient est-il en ADL?<span>*</span></label><br>
                        <select class="input" name="ADL_statut" id="" required>
                            <option value="">Choix</option>
                            <option value="OUI">OUI</option>
                            <option value="NON">NON</option>
                        </select>
                    </div>
                    <div>
                        <label for="Nom_mutuelle">Nom de la mutuelle ou de l'assurrance<span>*</span></label><br>
                        <input class="input" type="text" name="Nom_mutuelle" pattern="[A-Za-z\s0-9]+" required>
                    </div>
                    <div><label for="Num_ADR">Numéro d'adhérent<span>*</span></label><br>
                        <input class="input" type="text" name="Nom_ADR" minlength="8" maxlength="10"
                            pattern="[A-Za-z\s0-9]+" required>
                    </div>

                    <button class="prev" type="button">Précédent</button>
                    <button class="next" type="button">Suivant</button>
                </section>
            </div>
            <div class="page" id="page5">
                <h2 placeholder="(Formats jpg,png ou pdf)">PIECES A JOINDRES</h2>
                <section class="forms">
                    <div>
                        <label for="carte">Carte d'indentité(recto/verso):</label><br>
                        <input class="input" type="file" name="carte_indentité"><br>
                    </div>
                    <div>
                        <label for="carte_v">Carte vitale:</label><br>
                        <input class="input" type="file" name="carte_vitale">
                    </div>
                    <div>
                        <label for="carte_m">Carte de mutuelle:</label><br>
                        <input class="input" type="file" name="carte_mutuelle"><br>


                    </div>
                    <div>
                        <label for="livre_F">Livret de famille(pour enfants mineurs):</label><br>
                        <input class="input" type="file" name="Livre_famille">
                    </div>
                    <div>
                        <label for="autres_documents">Autres documents :</label><br>
                        <input class="input" type="file" name="autres_documents">
                    </div>

                    <button class="prev" type="button">Précédent</button>
                    <button class="submit" name="submit" type="submit">Valider</button>
                </section>
            </div>

            <input type="hidden" name="admin_email"
                value="<?php echo htmlspecialchars($admin_email, ENT_QUOTES, 'UTF-8'); ?>">
        </form>


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