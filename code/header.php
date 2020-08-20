<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>iBar - Barcode Generator</title>

    <link rel="icon" type="image/x-icon" href="resources/images/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="resources/css/style.css">

    <script src="resources/js/interface.js"></script>

</head>

<body>
<div id="outsideContainer">
    <div id="headerContainer">
        <div id="logoContainer">
            <a href="<?php ($user->loggedIn() ? print 'dashboard.php' : print 'index.php'); ?>"><img src="resources/images/ibarLogo.png" alt="iBar - Logo"/></a>
        </div>
        <div id="navigationContainer">
            <?php
            if (!$user->loggedIn())
            {
                echo "<p><a href='index.php'>Login</a></p>";

            } elseif($admin) {
                echo "<p><a href='dashboard.php'>Home</a> | ";
                echo "<a href='admin.php'>Admin</a> | ";
                echo "<a href='logout.php'>Logout</a></p>";
            } else {
                echo "<p><a href='dashboard.php'>Home</a> | ";
                echo "<a href='logout.php'>Logout</a></p>";
            }
            ?>
        </div>
        <?php
            if ($user->loggedIn())
        {?>
        <div id="searchContainer">
            <input type="text" placeholder="Product Name or Barcode" name="search" id="search" required/>
            <input type="submit" value="Go" class="btn"
                   onclick="searchProduct(document.getElementById('search').value, 1)"/>
                </div>
        <?php }; ?>
    </div>