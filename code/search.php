<?php

include_once('products.php');

class Search extends Product
{

//    protected $db;

//    public function setDB() {
//        $db = $this->getDB();
//    }

    function __construct()
    {
        $dbSearch = new PDO('sqlite2:products.db');
        $dbSearch->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $dbSearch;
    }

    public function getSearch()
    {
        if (strlen($_POST['search'])) {
            return $search = $_POST['search'];
        } else {
            echo "Please type in the box to search for a product using the name or barcode number.";
        }
    }

    public function getPage()
    {
        if (isset($_POST['searchPage'])) {
            $page = $_POST['searchPage'];
        } else {
            $page = 1;
        }
        return $startFrom = ($page - 1) * $this->perPage;
    }

    public function loadAllProductsPDO($input)
    {
        if ($input == 'search') {
            $query = "SELECT * FROM products WHERE name LIKE '%" . $this->getSearch() . "%' OR code LIKE '%" . $this->getSearch() . "%' ORDER BY name LIMIT " . $this->getPage() . ", " . $this->perPage;
        } else if ($input == 'pagination') {
            $query = "SELECT * FROM products WHERE name LIKE '%" . $this->getSearch() . "%' OR code LIKE '%" . $this->getSearch() . "%'";
        } else {
            $query = "SELECT * FROM products WHERE name LIKE '%" . $this->getSearch() . "%' OR code LIKE '%" . $this->getSearch() . "%' ORDER BY name";
        }
        $searchQuery = $this->db->prepare($query);
        $searchQuery->execute();
        $searchResult = $searchQuery->fetchAll();
        return $searchResult;
    }

    public function outputSearch()
    {
        echo "<h1>Search Results</h1>";
        $totalPages = $this->countPagination();
        $totalRecords = count($this->loadAllProductsPDO('pagination'));

        $searchOutput = "'" . $this->getSearch() . "'";

        if ($totalPages > 0) {
            echo '<a href="#" onclick="searchProduct(' . $searchOutput . ', 1)">First Page</a> ';

            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="#" onclick="searchProduct(' . $searchOutput . ', ' . $i . ')">' . $i . '</a> ';
            };
            // Going to last page
            echo '<a href="#" onclick="searchProduct(' . $searchOutput . ', ' . $totalPages . ')"> Last Page</a><br />';
        }

        if ($totalRecords > 0) {
            echo $totalRecords . " result(s) found";
            $this->printTableHeader();

            foreach ($this->loadAllProductsPDO('search') as $index => $row) {
                $index += 1;
                echo "<div class='divRow'>";
                echo "<div class='divCol'>" . $row{'name'} . "</div>";
                echo "<div class='divCol'>" . $row{'code'} . "</div>";
                echo "<div class='divCol'><a href='printFriendly.php?code=" . $row{'code'} . "&name=" . $row{'name'} . "'><img src='" . $this->cacheCheck($row{'code'}) . "' alt='" . $row{'name'} . "' /></a></div>";
                echo "</div>";
            }

            echo "</div>";
        } else {
            echo "No search results was found for " . $this->getSearch() . ", Please try another search";
        }
    }
}
?>