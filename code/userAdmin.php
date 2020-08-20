<?php

class admin extends user {

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


    public function register($uName, $uPassword, $uLevel) {

        try
        {
            $md5Password = md5($uPassword);

            if($uLevel == 'on') {
                $uLevel = 'admin';
            } else {
                $uLevel = 'guest';
            }
            $uName = strtolower($uName);

            //Count total records for id
            $count = 'SELECT * FROM staff';
            $countQuery = $this->db->prepare($count);
            $countQuery->execute();
            $id = count($countQuery->fetchAll()) + 1;
            $stmt = "INSERT INTO staff(userId, username, password, userLevel) VALUES(" . $id . ", '" . $uName . "', '" . $md5Password . "', '" . $uLevel ."')";
            $stmtQuery = $this->db->prepare($stmt);
            $stmtQuery->execute();


            return $stmt;
        } catch(PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

    }

    public function welcomeMessage() {
        $message = "Welcome Admin " . unserialize($this->name) . ", to print a barcode just click it or click admin at the top to add a new user.";
        print $message;
    }


}