<?php

class guest extends user {

    public $id;
    public $name;
    public $level;

    function __construct($dbUsers)
    {
        $this->db = $dbUsers;
        $this->id = $_SESSION['userSession'];
        $this->name = serialize($_SESSION['username']);
        $this->level = $_SESSION['userLevel'];
    }

//class implemented ready for expansion of the software if a guest needs to be able to do stuff a admin cannot do.
public function welcomeMessage() {
    $message = "Welcome " . unserialize($this->name) . ", to print a barcode just click it!";
    print $message;
}


}