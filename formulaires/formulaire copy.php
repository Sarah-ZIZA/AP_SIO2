<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>LPFSClinique<img src="assets/img/logo.png"></title>
    <link rel="stylesheet" href="styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,300&display=swap" rel="stylesheet" />
</head>

<body id="page-top">


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
                    <p>COUVERTURE<br>SOCIALE</p>
                </div>
                <div class="line"></div>
                <div class="etape" id="etape4">
                    <div class="cercle">4</div>
                    <p>DOCUMENTS</p>
                </div>
            </div>

        </header>

        <br>
        <br>
        <?php
        // Connexion à la base de données
        $host = 'localhost';
        $dbname = 'AP_SIO2';
        $username = 'root';
        $password = 'sio2024';

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
        ?>
        <!-- <form action="insertion.php" method="POST"> -->
        <div class="page" id="page1">
            <h2>INFORMATION CONCERNANT L'HOSPITALISATION</h2>
            <div>
                <label for="Pré-ad"> Pré-admission pour:<span>*</span></label><br>
                <select name="pre_ad" required>
                    <option value="">Choix</option>
                    <option value="Ambulatoire chururgie">Ambulatoire chururgie</option>
                    <option value="Hospitalisation">Hospitalisation(au moins une nuit)</option>
                </select>
            </div>
            <div>
                <label for="date">Date d'hospitalisation<span>*</span></label><br>
                <input type="date" name="date" required><br>
                <label for="heure">Heure de l'intervention<span>*</span></label><br>
                <input type="time" name="heure" required>
            </div>
            <div>
                <label for="Nom_m">Nom du médecin:<span>*</span></label><br>
                <select name="medecin" id="Nom_m" required>
                    <option value="">Choisissez un médecin</option> <!-- Option par défaut -->
                    <?php
                    // Récupération des médecins depuis la base de données
                    $sql = "SELECT Adresse_mail, Nom FROM Professionnels";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($row['Adresse_mail']) . "'>" . htmlspecialchars($row['Nom']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="Chambre">Chambre particulière?<span>*</span></label><br>
                <select name="Chambre" id="Chambre" required>
                    <option value="">Choix</option>
                    <option value="Privative">Privative</option>
                    <option value="Normale">Normale</option>
                </select>
            </div>
            <button id="top" class="next" type="button">Suivant</button>
        </div>
        <div class="page" id="page2">
            <h2>INFORMATIONS CONCERNANT LE PATIENT</h2>
            <div>
                <label for="Civ">Civ<span>*</span></label><br>
                <select name="Sexe" type="text" required>
                    <option value="">Choix</option>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select><br>
                <label for="nom_N">Nom de naissance <span>*</span></label>
                <input type="text" name="Nom_naissance" required>
                <label for="nom_d'épouse">Nom d'épouse</label>
                <input type="text" name="Nom_d'épouse">
            </div>
            <div>
                <label for="prénom">Prénom <span>*</span></label>
                <input type="text" name="prénom" required>
                <label for="Date_N">Date de naissance<span>*</span></label>
                <input type="date" name="date_N" required>
            </div>
            <div>
                <label for="adresse">Adresse<span>*</span></label>
                <input type="text" name="adresse" required>
            </div>
            <div>
                <label for="Cp">CP<span>*</span></label>
                <input type="tex" name="Cp" required>
                <label for="ville">Ville<span>*</span></label>
                <input type="text" required>
            </div>
            <div>
                <label for="email">Email<span>*</span></label>
                <input type="email" required>
                <label for="tel">Téléphone<span>*</span></label>
                <input type="text" name="phone" minlength="10" maxlength="10" pattern="[0-9]*" required>
            </div>
            <div>
                <h2>COORDONNEES PERSONNE A PREVENIR</h2>
                <div>
                    <label for="nom">Nom</label>
                    <input type="text" name="Nom">
                    <label for="prénom">Prénom</label>
                    <input type="text" name="Prénom">

                </div>
                <div>
                    <label for="tel" name="tel">Téléphone</label>
                    <input type="text" name="phone" minlength="10" maxlength="10" pattern="[0-9]*">
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse">
                </div>
            </div>
            <div>
                <h2>COORDONNEES PERSONNE DE CONFIANCE</h2>
                <div>
                    <label for="nom">Nom</label>
                    <input type="text" name="Nom">
                    <label for="prénom">Prénom</label>
                    <input type="text" name="Prénom">

                </div>
                <div>
                    <label for="tel" name="tel2">Téléphone</label>
                    <input type="text" name="phone" minlength="10" maxlength="10" pattern="[0-9]*">
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse2">
                </div>
            </div>

            <button id="top2" class="prev" type="button">Précédent</button>
            <button id="top3" class="next" type="button">Suivant</button>
        </div>
        <div class="page" id="page3">
            <h2>INFORMATION CONCERNANT LA COUVERTURE SOCIALE</h2>
            <div>
                <label for="org">Organisme de sécurité sociale/Nom de la caisse d'assurance maladie
                    <span>*</span></label>
                <input type="text" name="organisation" placeholder="Ex:CPAM du tarn et Garronne,CPAM du lot,RSI,MSA..."
                    required>
            </div>
            <div>
                <label for="Num_Sociale">Numéro de sécurité sociale
                    <span>*</span></label>
                <input type="text" name="Sécurité_sociale" required>
            </div>

            <div>
                <label for="Assuré">Le patient est-il l'assuré?<span>*</span></label><br>
                <select name="assurance_statut" id="" required>
                    <option value="">Choix</option>
                    <option value="OUI">OUI</option>
                    <option value="NON">NON</option>
                </select>
            </div>
            <div>
                <label for="ADL">Le patient est-il en ADL?<span>*</span></label><br>
                <select name="ADL_statut" id="" required>
                    <option value="">Choix</option>
                    <option value="OUI">OUI</option>
                    <option value="NON">NON</option>
                </select>
            </div>
            <div>
                <label for="Nom_mutuelle">Nom de la mutuelle ou de l'assurrance<span>*</span></label>
                <input type="text" name="Nom_mutuelle" required>
            </div>
            <div><label for="Num_ADR">Numéro d'adhérent<span>*</span></label>
                <input type="text" name="Nom_ADR" required>
            </div>

            <button id="top3" class="prev" type="button">Précédent</button>
            <button id="top3" class="next" type="button">Suivant</button>
        </div>
        <div class="page" id="page4">
            <h2 placeholder="(Formats jpg,png ou pdf)">PIECES A JOINDRES</h2>
            <div>
                <label for="carte">Carte d'indentité(recto/verso):</label><br>
                <input type="file" name="carte_d'indentité" required><br>
                <label for="carte_v">Carte vitale:</label><br>
                <input type="file" name="carte_vitale" required>
            </div>
            <div>
                <label for="carte_m">Carte de mutuelle:</label><br>
                <input type="file" name="carte de mutuelle"><br>
                <label for="livre_F">Livret de famille(pour enfants mineurs):</label><br>
                <input type="file" name="Livre_famille">
            </div>

            <button id="top4" class="prev" type="button">Précédent</button>
            <button class="submit" name="submit" type="submit">Valider</button>
        </div>
        </form>
        <script src="scripts.js"></script>

    </section>
</body>

</html>