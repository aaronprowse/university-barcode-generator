<?php
include_once('resources/php/db.php');

if(!$user->loggedIn())
{
    $user->redirect('index.php');
}

$userId = $_SESSION['userSession'];
$stmt = $dbUsers->prepare("SELECT * FROM staff WHERE userId=:userId");
$stmt->execute(array(":userId"=>$userId));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

include_once('header.php');
?>
    <div id="bodyContainer">

        <div id="adminPanel">
            <a href="#" onClick="toggleShow('selectProduct')"><img src="resources/images/selectaproduct.png"
                                                                   alt="iBar - Select A Product"></a>
            <a href="#" onClick="toggleShow('allProducts')"><img src="resources/images/showallproducts.png"
                                                                 alt="iBar - Show all products"></a>
        </div>

        <p><em><?php ($_SESSION['userLevel'] == 'admin' ? $admin->welcomeMessage() : $guest->welcomeMessage()); ?></em></p>

        <div id="searchResults">
            <!--            Search results displayed here-->
        </div>

        <div id="selectProduct">
            <h1>Select a Product</h1>

            <form name="selectBarcodeForm" method="post">
                <select name="selectBarcode" id="selectBarcode" onchange="getProduct(this.options[this.selectedIndex].value, this.options[this.selectedIndex].text);">

                    <option value="null" selected="selected">Please Select A Value</option>
                    <?php

                    $product->selectProductsOutput();

                    ?>
                </select>
            </form>
            <div id="selectProductResult">
                <!--                Displays the result of the barcode the user is trying to collect-->
            </div>
        </div>

        <div id="allProducts">
            <h1>All Products</h1>
            <!-- Loads in all products -->
            <?php
            $product->outputAllProducts(); ?>
        </div>
    </div>
<?php
include_once('footer.php');
?>
