<?php
session_start();

// Fonction pour générer le CAPTCHA
function generateCaptcha()
{
    $code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ@}{&$*:/?!%#"), 0, 6);
    $_SESSION['captcha'] = $code;
    return $code;
}

// Création de l'image CAPTCHA
$captcha_code = generateCaptcha();
$font = __DIR__ . '/assets/fonts/Monoton/Monoton-Regular.ttf'; // Assurez-vous que vous avez un fichier de police .ttf à cet endroit
// Créer une image de 200x50 avec fond transparent
$image = imagecreatetruecolor(200, 50);

// Activer la transparence
imagealphablending($image, false);
imagesavealpha($image, true);

// Couleur de fond transparente
$transparent_color = imagecolorallocatealpha($image, 0, 0, 0, 127);
// Couleur du texte (noir)
$text_color = imagecolorallocate($image, 0, 0, 0);
imagefill($image, 0, 0, $transparent_color);
imagettftext($image, 20, 0, 30, 35, $text_color, $font, $captcha_code);


// Ajouter du texte CAPTCHA
//if (file_exists($font)) {
//imagettftext($image, 20, 0, 30, 35, $text_color, $font, $captcha_code);
//} else {
// Si la police n'est pas disponible, utilisez un texte basique
//imagestring($image, 5, 50, 15, $captcha_code, $text_color);
//}

// Affichage de l'image CAPTCHA
header('Content-type: image/png');
imagepng($image);

// Libérer la mémoire
imagedestroy($image);

?>