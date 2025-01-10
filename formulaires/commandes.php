<?php
if (isset($_POST['submit'])) {
    try {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO('mysql:host=localhost;dbname=AP_SIO2', 'root', 'sio2024', $pdo_options);

        function insertH()
        {
            $req1 = "INSERT INTO Hospitalisation (id_hos, pré_ad, date_hos, heure, id_patient, Adresse_mail, id_chambre) values('','', :date, :heure,'','','')";

        }
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

?>