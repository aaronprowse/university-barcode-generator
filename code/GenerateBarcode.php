<?php
//Get variables from the db
$barCode = $_GET['selectBarcode'];
$explode = str_split($barCode);

$leftPattern = array(
    0 => "0001101",
    1 => "0011001",
    2 => "0010011",
    3 => "0111101",
    4 => "0100011",
    5 => "0110001",
    6 => "0101111",
    7 => "0111011",
    8 => "0110111",
    9 => "0001011",
);

$rightPattern = array(
    0 => "1110010",
    1 => "1100110",
    2 => "1101100",
    3 => "1000010",
    4 => "1011100",
    5 => "1001110",
    6 => "1010000",
    7 => "1000100",
    8 => "1001000",
    9 => "1110100",
);

define("maxHeight", 200);
define("scaleMultiplier", 3);

$im = ImageCreate(350, maxHeight + 20);
$white = ImageColorAllocate($im, 0xFF, 0xff, 0xff);
$black = ImageColorAllocate($im, 0x00, 0x00, 0x00);

//Product Classification
$productClass = $leftPattern[$explode[0]];
$barcodeDrawer = str_split($productClass);

$x = 0;
$y = 0;
$pos = 20;
$guardCounter = 1;

while ($x <= strlen($barCode)) {
    if ($x <= 5) {
        $y = $leftPattern[$barCode[$x]];
    } else {
        $y = $rightPattern[$barCode[$x]];
    }

    // Calculates the output height against the max height
    $outputHeight = $x == 0 || $x == 11 ? maxHeight + 10 : maxHeight - 5;

    //Left & Middle Guard Bars
    if ($x == 0 || $x == 6) {
        while ($guardCounter <= 5) {
            if ($guardCounter & 1) {
                ImageFilledRectangle($im, $pos, 0, $pos + scaleMultiplier, maxHeight + 10, $white);
            } else {
                ImageFilledRectangle($im, $pos, 0, $pos + scaleMultiplier, maxHeight + 10, $black);
            }
            $guardCounter++;
            $pos += scaleMultiplier;
        }
        $guardCounter = 1;
    }

    //Number Printer
    $font = 'resources/fonts/arial.ttf';

    $pos += 1;
    if ($x == 0) {
        imagettftext($im, 18, 0, 0, maxHeight + 15, $black, $font, $barCode[$x]);
    } elseif($x == 11) {
        imagettftext($im, 18, 0, $pos + 40, maxHeight + 15, $black, $font, $barCode[$x]);
    } else {
        imagettftext($im, 23, 0, $pos, maxHeight + 20, $black, $font, $barCode[$x]);
    }


    //Barcode Printer
    $y = str_split($y);
    foreach ($y as $z) {
        if ($z == "1") {
            ImageFilledRectangle($im, $pos, 0, $pos + scaleMultiplier, $outputHeight, $black);
        } else if ($z == "0") {
            ImageFilledRectangle($im, $pos, 0, $pos + scaleMultiplier, $outputHeight, $white);
        }
        $pos+= scaleMultiplier;
    }
    $x++;


    //Right Guard Bar
    if ($x == 12) {
        while ($guardCounter <= 5) {
            if ($guardCounter & 1) {
                ImageFilledRectangle($im, $pos, 0, $pos + scaleMultiplier, maxHeight + 10, $white);
            } else {
                ImageFilledRectangle($im, $pos, 0, $pos + scaleMultiplier, maxHeight + 10, $black);
            }
            $guardCounter++;
            $pos+= scaleMultiplier;
        }
        $guardCounter = 1;
    }


}

//check if image exists
$fileName = "cache/" . $barCode . ".png";

if (!file_exists($fileName)) {
    //Save image for cache
    header('Content-Type: image/png');
    ImagePNG($im, $fileName);
    //produce out to the screen
    ImagePNG($im);
}

?>