<?php
header('Content-Type: image/png');
session_start();
$captcha = "";
$totalCharacteres = rand(5, 8); // Longitud máxima del captcha
$possiblesLetras = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$captchaFont = "mesquite.ttf";
$captchaFontSize = rand(30, 40); // Tamaño de la fuente
$caracter = 0;
while ($caracter < $totalCharacteres) {
    $captcha .= substr($possiblesLetras, rand(0, strlen($possiblesLetras) - 1), 1);
    $caracter++;
}
$text_box = imagettfbbox($captchaFontSize, 0, $captchaFont, $captcha);
$ancho = abs($text_box[2] - $text_box[0]) + 10;
$alto = abs($text_box[5] - $text_box[1]);
if ($captchaFontSize > 35)
    $randomLineas = 10;
else
    $randomLineas = 14;
$imagen = imagecreatetruecolor($ancho, $alto + 20);
$colorBlanco = imagecolorallocate($imagen, 255, 255, 255);
$colorAzul = imagecolorallocate($imagen, 0, 0, 164);
$colorNegro = imagecolorallocate($imagen, 0, 0, 0);
// Dibujamos la imagen
imagefill($imagen, 0, 0, $colorAzul);
$backgroundColor = imagecolorallocate($imagen, 255, 255, 255);
for ($contadorLineas = 0; $contadorLineas < $randomLineas; $contadorLineas++) {
    imageline($imagen, rand(0, $ancho), rand(0, $alto), rand(0, $ancho), rand(0, $alto + 20), $colorBlanco);
}
imagettftext($imagen, $captchaFontSize, 0, 4, $alto, $colorBlanco, $captchaFont, $captcha);
imagepng($imagen);
imagedestroy($imagen);
$_SESSION['captchaGenerado'] = $captcha;
