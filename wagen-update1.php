<?php
session_start();

// Connect de database
function dbConnect()
{
    $servername = "localhost";
    $database = "buur";
    $dsn = "mysql:host=$servername;dbname=$database";
    $username = "bit_academy";
    $password = "bit_academy";

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

// Voeg product toe aan een array wanneer deze wordt doorgestuurd
if (isset($_POST["type"]) && $_POST["type"] == 'add' && $_POST["product_aantal"] > 0) {
    $nieuw_product = array();
    foreach ($_POST as $key => $value) {
        // Voeg alle gegevens toe aan het product array
        $nieuw_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
    }
    // verwijder alle onnodige gegevens
    unset($nieuw_product['type']);
    unset($nieuw_product['url_terug']);

    // Haal alle details van het product op
    $conn = dbConnect();
    $statement = $conn->prepare("SELECT productNaam AS product_naam, productValue AS product_prijs FROM producten WHERE productCode=? LIMIT 1");
    $statement->execute(array($nieuw_product['product_code']));
    $product = $statement->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        // Fetch product naam en prijs en voeg het aan een nieuwe variabele toe
        $nieuw_product["product_naam"] = $product["product_naam"];
        $nieuw_product["product_prijs"] = $product["product_prijs"];
        
        if (isset($_SESSION["producten"])) {
            // check of het product al in de winkelwagen staat, zo ja vervang het dan
            if (isset($_SESSION["producten"][$nieuw_product['product_code']])) {
                unset($_SESSION["producten"][$nieuw_product['product_code']]);
            }
        }
        $_SESSION["producten"][$nieuw_product['product_code']] = $nieuw_product; 
    }
}

// Update of verwijderd items 
if (isset($_POST["product_aantal"]) || isset($_POST["verwijder_code"])) {
    if (isset($_POST["product_aantal"]) && is_array($_POST["product_aantal"])) {
        foreach ($_POST["product_aantal"] as $key => $value) {
            if (is_numeric($value)) {
                $_SESSION["producten"][$key]["product_aantal"] = $value;
            }
        }
    }
    // verwijderd het product uit de session
    if (isset($_POST["verwijder_code"]) && is_array($_POST["verwijder_code"])) {
        foreach ($_POST["verwijder_code"] as $key) {
            unset($_SESSION["producten"][$key]);
        }
    }
}

// stuur de gebruiker naar de juiste pagina terug
$url_terug = (isset($_POST["url_terug"])) ? urldecode($_POST["url_terug"]) : '';
header('Location:' . $url_terug);
?>
