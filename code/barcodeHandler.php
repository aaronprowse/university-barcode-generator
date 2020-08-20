<?php
include_once('products.php');

if(isset($_POST['barCode'])){
    $barCode = $_POST['barCode'];
    $name = $_POST['name'];

    $product = new Product($dbProducts);
    $result = "<a href='printFriendly.php?code=" . $barCode . "&name=" . $name . "'><img src='" . $product->cacheCheck($barCode) . "' alt='" . $name . "' /></a>";
    print $result;
}
?>