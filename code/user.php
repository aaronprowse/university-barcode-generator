<?php
include_once('userAdmin.php');
include_once('userGuest.php');


class user {

    protected $db;

    function __construct($dbUsers)
    {
        $this->db = $dbUsers;
    }

    public function checkLevel() {
        if ($_SESSION['userLevel'] == 'admin'){
            return true;
        } else {
            return false;
        }
    }

    public function debugConsole($data) {
        //handy function for debugging
        var_dump($data);
        echo "<br />";
    }

    public function login($uName, $uPassword)
    {
        try
        {
            $stmt = $this->db->prepare("SELECT * FROM staff WHERE username='" . $uName . "'");
            $stmt->execute(array('username'=>$uName));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if($userRow > 0)
            {
                if(md5($uPassword) == $userRow['password'])
                {
                    $_SESSION['userSession'] = $userRow['userId'];
                    $_SESSION['username'] = $userRow['username'];
                    $_SESSION['userLevel'] = $userRow['userLevel'];
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }


    public function loggedIn()
    {
        if(isset($_SESSION['userSession']))
        {
            return true;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_start();
        session_destroy();
        unset($_SESSION['userSession']);
        return true;
    }
}
?>