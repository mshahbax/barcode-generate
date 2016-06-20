<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "Barcode39.php"; 

$barcodesPath = 'images/barcodes/';

$bc = new Barcode39("123-ABC"); 

// set text size 
$bc->barcode_text_size = 5; 

// set barcode bar thickness (thick bars) 
$bc->barcode_bar_thick = 4; 

// set barcode bar thickness (thin bars) 
$bc->barcode_bar_thin = 2; 

// save barcode GIF file 
$bc->draw($barcodesPath."barcode.gif");


echo '<img src="' . $barcodesPath."barcode.gif" . '">';



$dest = imagecreatefromgif($barcodesPath."barcode.gif");
$src = imagecreatefromjpeg('ticket_template.jpg');

imagealphablending($dest, false);
imagesavealpha($dest, true);

imagecopymerge($dest, $src, 10, 9, 0, 0, 181, 180, 100); //have to play with these numbers for it to work for you, etc.

header('Content-Type: image/png');
imagepng($dest);

//imagedestroy($dest);
//imagedestroy($src);