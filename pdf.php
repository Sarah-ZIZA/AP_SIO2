<?php
// Connexion à la BDD
$bddname = 'AP_SIO2';
$hostname = 'localhost';
$username = 'root';
$password = 'sio2024';
$db = mysqli_connect($hostname, $username, $password, $bddname);

// Vérifier la connexion
if (!$db) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Appel de la librairie FPDF
require("fpdf/fpdf.php");

// Création de la classe PDF
class PDF extends FPDF
{
    // Header
    function Header()
    {
        // Logo
        $this->Image('assets/img/logo.png', 8, 2, 50); // (x=8, y=2, largeur=50)

        // Ligne verticale
        $x = 8 + 50 + 2; // Position de l'extrémité droite de l'image + espacement
        $y1 = 2; // Point de départ vertical (même que l'image)
        $y2 = 45; // Point de fin vertical

        $this->Line($x, $y1, $x, $y2);

        // Définir une police pour le texte
        $this->SetFont('Times', 'BI', 12); // Police Arial, gras, taille 12

        // Ajout de texte
        $t = 'LPFS clinique';
        $this->Text(62, 20, $t); // Position x=8, y=43 pour afficher le texte
        $t1 = utf8_decode('70 Rue des Champs Elysées');
        $this->Text(x: 62, y: 25, txt: $t1);
        $t2 = utf8_decode('lpfs.clinique@lpsf.com');
        $this->Text(x: 62, y: 31, txt: $t2);
        // Saut de ligne
        $this->Ln(20);
    }




    // Footer
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Adresse
        $this->Cell(196, 5, utf8_decode('LPFS_CLINIQUE - lpfs.clinique@lpfs.com'), 0, 0, 'C');
    }
}

// Création du document PDF
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Times', 'I', 11);
$pdf->SetTextColor(0);
$pdf->SetFont('Times', 'BI', 20);
$pdf->Text(40, 75, utf8_decode('CONFIRMATION DE RENDEZ-VOUS'));

$pdf->SetFont('Times', 'I', 12);
$pdf->Text(20, 85, utf8_decode('Ce document est à présenter sous forme imprimé ou élétronique lors du rendez-vous'));
$pdf->SetFont('Times', 'BI', 12);
$pdf->SetXY(20, 90);
$pdf->MultiCell(0, 5, utf8_decode("Veuillez vous présenter à l'heure précise du rendez-vous avec une pièce d'identité et votre carte de sécurité sociale dont le nom et le/les prénom(s) sont identiques à ceux-ci dessous."));


// Ajout du texte avant la requête SQL
$pdf->SetFont('Times', 'I', 12);

// Récupération du dernier patient enregistré
$req = "SELECT patient.nom, patient.prénom,patient.num_sécu,hospitalisation.date_hos,hospitalisation.heure,professionnels.Nom,services.service FROM patient,hospitalisation,professionnels,services WHERE patient.id_patient=hospitalisation.id_patient AND hospitalisation.Adresse_mail=professionnels.Adresse_mail AND services.id_service=professionnels.id_service
ORDER BY patient.id_patient DESC LIMIT 1";
$rep = mysqli_query($db, $req);

// Vérifier si la requête a réussi
if (!$rep) {
    die("Erreur SQL : " . mysqli_error($db)); // Affiche l'erreur SQL
}

// Vérification des résultats
if ($row = mysqli_fetch_assoc($rep)) {
    $pdf->Text(25, 115, utf8_decode('Date du RDV : ') . utf8_decode($row['date_hos']));
    $pdf->Text(25, 125, utf8_decode(' Heure du RDV : ') . utf8_decode($row['heure']));
    $pdf->Text(25, 135, utf8_decode('Nom : ') . utf8_decode($row['nom']));
    $pdf->Text(25, 145, utf8_decode('Prénom : ') . utf8_decode($row['prénom']));
    $pdf->Text(25, 155, utf8_decode('Numéro de sécurité sociale : ') . utf8_decode($row['num_sécu']));
    $pdf->Text(25, 165, utf8_decode('Médecin : ') . utf8_decode($row['Nom']));
    $pdf->Text(25, 175, utf8_decode('Service: ') . utf8_decode($row['service']));
} else {
    $pdf->Text(25, 43, 'Aucun patient trouvé.');
}
$pdf->SetFont('Times', 'I', 12);
$pdf->SetXY(20, 190);
$pdf->MultiCell(0, 5, utf8_decode("Si vous souhaitez modifier ou annuler ce rendez-vous, veuillez effectuer la démarche d'annulation de rendez-vous auprès de la secrétaire."));
$pdf->SetFont('Times', 'BI', 12);
$pdf->SetXY(20, 200);
$pdf->MultiCell(0, 5, utf8_decode("Attention : Il n'y a aucune garantie que d'autres créneaux soient encore disponibles."));
$pdf->Ln(20);
$pdf->Image('assets/img/cachet.png', 129, 215, 50);

// Affichage du PDF
$pdf->Output();


