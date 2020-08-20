<?php

require_once 'search.php';

if(isset( $_POST['search'] )) {
    $search = new search($dbProducts);
    $result = $search->outputSearch();
}

return $result;