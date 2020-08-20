<?php
//For Creation of the Databases & Testing.
//$dbProducts=sqlite_open("products.db");
//$dbUsers = sqlite_open("staff.db");

//Staff Table Creation & Populate
//@sqlite_query($dbUsers,"DROP TABLE staff");
//@sqlite_query($dbUsers,"CREATE TABLE staff (userId int(11) NOT NULL PRIMARY KEY, username varchar(15) NOT NULL, password varchar(20) NOT NULL, userLevel varchar(5) NOT NULL, UNIQUE (username))",$sqliteerror);
//@sqlite_query($dbUsers, "INSERT INTO staff VALUES ('1','admin','246e6a92707628bfb8df2d392c4df7b9','admin')",$sqliteerror);
//@sqlite_query($dbUsers, "INSERT INTO staff VALUES ('2','demouser','75580656a394292460ebb4b036ebeaf1','guest')",$sqliteerror);

//Products Table Creation & Populate
//@sqlite_query($dbProducts,"DROP TABLE products");
//@sqlite_query($dbProducts,"CREATE TABLE products (name varchar(30),code varchar(12) PRIMARY KEY)",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Apples'," . checkSum('01234567890') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Oranges'," . checkSum('01234509876') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Lemons'," . checkSum('05432167890') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Bananas'," . checkSum('09456881235') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Lettuce'," . checkSum('07894563841') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Beetroot'," . checkSum('01123487645') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Carrots'," . checkSum('02234994875') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Controlled drug 1'," . checkSum('34859603004') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Box of Tissues'," . checkSum('04546938969') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Kitchen Rolls'," . checkSum('04446573995') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Toilet Rolls'," . checkSum('09866958348') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Disposable Napkins'," . checkSum('01263553425') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Tea Towels'," . checkSum('04628374758') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Washing-up Liquid'," . checkSum('06859939577') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Soap Powder'," . checkSum('08839577381') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Controlled drug 2'," . checkSum('30548999604') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Spring Water'," . checkSum('01177226637') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Champagne'," . checkSum('05969483958') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Still Water'," . checkSum('01928337773') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Orange Juice'," . checkSum('05843637378') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Tomato Juice'," . checkSum('09999948377') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Can of Beer'," . checkSum('03677748388') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Controlled drug 3'," . checkSum('36888493904') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Cheese'," . checkSum('03828475734') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Milk'," . checkSum('01727172717') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Yogurt'," . checkSum('02838264634') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Coffee'," . checkSum('07578486889') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Tea'," . checkSum('01525465634') . ")",$sqliteerror);
//sqlite_query($dbProducts, "INSERT INTO products VALUES ('Bread'," . checkSum('01111115253') . ")",$sqliteerror);

//Close Database
//$dbUsers = null;
//$dbProducts = null;

session_start();

include_once('user.php');
include_once('products.php');

try {
    $dbProducts = new PDO('sqlite2:products.db');
    $dbProducts->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbUsers = new PDO('sqlite2:staff.db');
    $dbUsers->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user = new user($dbUsers);
    $product = new product($dbProducts);

    if($user->checkLevel()) {
        $admin = new admin($dbUsers);
    } else {
        $guest = new guest($dbUsers);
    }

}  catch(PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

function checkSum($code)
{
    $barCode = $code;
    $explode = str_split($barCode);

    //check Sum
    $odd = 0;
    $even = 0;

    //1. Add together all the odd and even numbers
    for ($i = 0; $i < count($explode); $i++) {
        if ($i & 1) {
            //odd
            //echo "odd" . $explode[$i] . "<br />";
            $odd += $explode[$i];
        } else {
            //echo "even" . $explode[$i] . "<br />";
            $even += $explode[$i];
        }
    }

    //2. multiply by three
    $result = ($even * 3) + $odd;

    //3. Modulo 10 and subtract from 10
    $result = 10 - ($result % 10);

    if ($result == 10) {
        $result = 0;
    }
    return $barCode .= $result;
}

?>