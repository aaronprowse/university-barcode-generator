<?php
include_once('resources/php/db.php');

if(!$user->loggedIn())
{
    $user->redirect('index.php');
}
$code = $_GET['code'];
$name = $_GET['name'];

if ($name == null) {
    //Just incase name GET fails then a default is provided.
    $name = "Barcode";
}
if(isset($_GET['code'])){
    $product = new Product($dbProducts);
    $result = "<a href='#' onclick='window.print()'><img src='" . $product->cacheCheck($code) . "' alt='" . $name . "' /></a>";
}
?>

<html>

<head>
    <title><?php echo $name ?></title>

    <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="resources/css/print.css">
</head>

<body>
<?php
print $result;
?>
<div class="printHide" id="printContainer">
    <a href="#" onClick="window.history.back();" class="floatLeft">Go Back</a>
    <div onclick="window.print()" class="link">Print Barcode</div>
</div>
</body>
</html>
