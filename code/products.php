<?php

include_once('search.php');

class Product {

    protected $db;
    protected $perPage = 3;

    function __construct($dbProducts)
    {
        $this->db = $dbProducts;
    }

    public function getDB() {
        return $this->db;
    }

    public function getPerPage() {
        return $this->perPage;
    }

    public function debugConsole($data) {
        //handy function for debugging
        var_dump($data);
        echo "<br />";
    }

    public function printTableHeader() {
        echo "<div class='divTable'>";
        echo "<div class='divRow'>";
        echo "<div class='divCol divTh'>Name</div>";
        echo "<div class='divCol divTh'>Code Number</div>";
        echo "<div class='divCol divTh'>Barcode</div>";
        echo "</div>";
    }

    public function selectProductsOutput() {
        foreach ($this->loadAllProductsPDO('select') as $row) {
            echo "<option value='" . $row{'code'} . "'>" . $row{'name'} . "</option>";
        }
    }

    public function paginationStart() {
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page=1;
        }
        $startFrom = ($page-1) * $this->perPage;

        return $startFrom;
    }

    public function countPagination() {
        $totalRecords = count($this->loadAllProductsPDO('pagination'));
        //divide amount of records per page
        $totalPages = ceil($totalRecords / $this->perPage);
        return $totalPages;
    }

    public function loadAllProductsPDO($input) {
        if ($input == 'all') {
            $products = 'SELECT name, code FROM products ORDER BY name LIMIT ' . $this->paginationStart() . ', ' . $this->perPage;
        } else {
            $products = 'SELECT name, code FROM products ORDER BY name';
        }
        $queryProducts = $this->db->prepare($products);
        $queryProducts->execute();
        $productsResult = $queryProducts->fetchAll();
        return $productsResult;
    }

    public function cacheCheck($code) {
        $fileName = "cache/" . $code . ".png";

        if(file_exists($fileName)){
            return $output = $fileName;
        } else {
            return $output = "GenerateBarcode.php?selectBarcode=" . $code;
        }
    }

    public function outputAllProducts() {
        $totalPages = $this->countPagination();

        //Going to first page
        echo "<a href='dashboard.php?page=1'>" . 'First Page'  . "</a> ";

        for ($i=1; $i<= $totalPages; $i++) {
            echo "<a href='dashboard.php?page=" . $i . "'>" . $i . "</a> ";
        };
        // Going to last page
        echo "<a href='dashboard.php?page=" . $totalPages . "'>" . 'Last Page' . "</a>";

        $this->printTableHeader();

        foreach ($this->loadAllProductsPDO('all') as $row) {

            echo "<div class='divRow'>";
            echo "<div class='divCol'>" . $row{'name'} . "</div>";
            echo "<div class='divCol'>" . $row{'code'} . "</div>";
            echo "<div class='divCol'><a href='printFriendly.php?code=" . $row{'code' } . "&name=" . $row{'name'} . "'><img src='" . $this->cacheCheck($row{'code'}) . "' alt='" . $row{'name'} . "' /></a></div>";
            echo "</div>";
        }
            echo "</div>";
    }
}
?>