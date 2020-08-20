//holds information on if a search has been conducted
var search = false;
var activeElement = "allProducts";

//Toggle Regions on the page to open when the user has clicked that area.
function toggleShow(id) {
    var displayCSS = document.getElementById(id).style.display;

    //Checks if the element is open or not.
    if (displayCSS == "none") {
        collapseActive(id);
        document.getElementById(id).style.display = "block";
        activeElement = id;
    } else if (id == "selectProduct" && displayCSS.length == 0) {
        collapseActive(id);
        document.getElementById(id).style.display = "block";
        activeElement = id;
    }  else {
        document.getElementById(id).style.display = "none";
    }

    //removes search results if another action is called.
    if (search = true) {
        document.getElementById('searchResults').innerHTML = "";
        search = false;
    }


}

//Collapses any active elements
function collapseActive(id) {
    if(activeElement != null) {
        if (activeElement != id) {
            document.getElementById(activeElement).style.display = "none";
        }
    }

}

function getProduct(code, name) {
    if (code!= "null") {
        xmlHttp= new XMLHttpRequest();
        if (xmlHttp==null) {
            alert ("Browser does not support HTTP Request");
            return;
        }
        var url="barcodeHandler.php";
        xmlHttp.onreadystatechange=stateChangedSelected;
        xmlHttp.open("POST",url,true);
        xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xmlHttp.send("barCode=" + code + "&name=" + name);
    }
}

function stateChangedSelected() {
    if (xmlHttp.readyState==4) {
        document.getElementById('selectProductResult').innerHTML=xmlHttp.response;
        search = true;
    }
}

// AJAX to load search results on page.
var xmlHttp;

function searchProduct(code, pageNumber) {
    collapseActive("searchProducts");
    xmlHttp= new XMLHttpRequest();
    if (xmlHttp==null) {
        alert ("Browser does not support HTTP Request");
        return;
    }
    var url="searchHandler.php";
    xmlHttp.onreadystatechange=stateChangedSearch;
    xmlHttp.open("POST",url,true);
    xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlHttp.send("search=" + code + "&searchPage=" + pageNumber);
}

function stateChangedSearch() {
    if (xmlHttp.readyState==4) {
        document.getElementById('searchResults').innerHTML=xmlHttp.response;
        search = true;
    }
}