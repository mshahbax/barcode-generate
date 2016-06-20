<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
$randomNumberArr = array();
for ($i = 0; $i < 12; $i++) {
    $randomNumberArr[] = rand(0, 9);
}
$randomNumber = join('', $randomNumberArr);

$barcodesPath = 'images/barcodes/';
if (!file_exists($barcodesPath)) {
    mkdir($barcodesPath, 0755, true);
}
$base64_string = base64_encode($generator->getBarcode($randomNumber, $generator::TYPE_CODE_128));
$filePath = $barcodesPath . md5(time() . uniqid()) . ".png";
save_base64_to_jpeg($base64_string, $filePath);

function save_base64_to_jpeg($base64_string, $output_file) {
    $decoded = base64_decode($base64_string);
    file_put_contents($output_file, $decoded);
}

echo '<img src="' . $filePath . '">';
//$ticketTemplate = 'images/ticket_template.jpg';
//
//$png = imagecreatefrompng($filePath);
//$jpeg = imagecreatefromjpeg($ticketTemplate);
//
//list($width, $height) = getimagesize($ticketTemplate);
//list($newwidth, $newheight) = getimagesize($filePath);
//$out = imagecreatetruecolor($newwidth, $newheight);
//imagecopyresampled($out, $jpeg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//imagecopyresampled($out, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);
//imagejpeg($out, 'out.jpg', 100);


$top_file = $filePath;
$bottom_file = 'ticket_template.jpg';

merge($bottom_file, $top_file, 'merged.jpg');

function merge($filename_x, $filename_y, $filename_result) {

    // Get dimensions for specified images

    list($width_x, $height_x) = getimagesize($filename_x);
    list($width_y, $height_y) = getimagesize($filename_y);

    // Create new image with desired dimensions

    $image = imagecreatetruecolor($width_x + $width_y, $height_x);

    // Load images and then copy to destination image

    echo $image_x = imagecreatefromjpeg($filename_x);
    echo $image_y = imagecreatefrompng($filename_y);
    exit;

    imagecopy($image, $image_x, 0, 0, 0, 0, $width_x, $height_x);
    imagecopy($image, $image_y, $width_x, 0, 0, 0, $width_y, $height_y);

    // Save the resulting image to disk (as JPEG)

    imagejpeg($image, $filename_result);

    // Clean up

    imagedestroy($image);
    imagedestroy($image_x);
    imagedestroy($image_y);
}