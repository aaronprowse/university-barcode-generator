<?php
require_once('resources/php/db.php');
require_once('user.php');

if($user->logout()) {
    $user->redirect('index.php');
}
?>