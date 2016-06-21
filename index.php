<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "Barcode39.php"; 

$ticketTemplate = 'ticket_template.jpg';
$timeStamp = time();
$barcodesBasePath = 'images/barcodes/';
$ticketBasePath = 'images/tickets/';


if (!file_exists($barcodesBasePath)) {
    mkdir($barcodesBasePath, 0755, true);
}
if (!file_exists($ticketBasePath)) {
    mkdir($ticketBasePath, 0755, true);
}
$newBarcodeImg = $barcodesBasePath.$timeStamp."-barcode.gif";
$newTicket = $ticketBasePath.$timeStamp. '-ticket.jpg';
///Start: Generating Random Numbers
$randomNumberArr = array();
for ($i = 0; $i < 8; $i++) {
    $randomNumberArr[] = rand(0, 9);
}
$randomNumber = join('', $randomNumberArr);
///End: Generating Random Numbers
$bc = new Barcode39($randomNumber); 
// set text size 
$bc->barcode_text_size = 5; 
// set barcode bar thickness (thick bars) 
$bc->barcode_bar_thick = 4; 
// set barcode bar thickness (thin bars) 
$bc->barcode_bar_thin = 2; 
// save barcode GIF file 
$bc->draw($newBarcodeImg);





merge($ticketTemplate, $newBarcodeImg, $newTicket);

function merge($filename_x, $filename_y, $filename_result) {

 // Get dimensions for specified images

 list($width_x, $height_x) = getimagesize($filename_x);
 list($width_y, $height_y) = getimagesize($filename_y);

 // Create new image with desired dimensions

 $image = imagecreatetruecolor($width_x, $height_x);

 // Load images and then copy to destination image

 $image_x = imagecreatefromjpeg($filename_x);
 $image_y = imagecreatefromgif($filename_y);

 imagecopy($image, $image_x, 0, 0, 0, 0, $width_x, $height_x);
 imagecopy($image, $image_y, ($width_x/2-150), ($height_x - ($height_y+30)), 0, 0, $width_y, $height_y);

 // Save the resulting image to disk (as JPEG)

 imagejpeg($image, $filename_result);

 // Clean up

 imagedestroy($image);
 imagedestroy($image_x);
 imagedestroy($image_y);

}
?>
<html>
    
    <body>
        <div style="width: 100%">
            <div style="float: left;">
                <img style="max-width: 800px" src="<?php echo $newTicket;?>" alt="" >
            </div>
            <div style="float: right;">
                <img src="<?php echo $newBarcodeImg;?>" alt="" >
            </div>
        </div>
    </body>
</html>