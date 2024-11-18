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
if (isset($_SESSION["email"])) {
    $conn = dbConnect();
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

            if (isset($_SESSION["email"])) {
                // Voeg product toe aan de database voor ingelogde gebruikers
                $user_email = $_SESSION["email"];
                // Controleer eerst of het product al in de winkelwagen van de gebruiker zit
                $statement = $conn->prepare("SELECT * FROM kruiwagen WHERE productCode = ? AND email = (SELECT email FROM gebruikers WHERE email = ?)");
                $statement->execute(array($nieuw_product['product_code'], $user_email));
                $bestaand_product = $statement->fetch(PDO::FETCH_ASSOC);
                if ($bestaand_product) {
                    // Als het product al in de winkelwagen zit, verhoog dan het aantal
                    $nieuw_product['product_aantal'] = $bestaand_product['productAantal'] + $_POST["product_aantal"];
                    $statement = $conn->prepare("UPDATE kruiwagen SET productAantal = ? WHERE productCode = ? AND email = (SELECT email FROM gebruikers WHERE email = ?)");
                    $statement->execute(array($nieuw_product['product_aantal'], $nieuw_product['product_code'], $user_email));
                } else {
                    // Als het product nog niet in de winkelwagen zit, voeg het dan toe
                    $statement = $conn->prepare("INSERT INTO kruiwagen (productCode, productNaam, productAantal, productPrijs, email) VALUES (?, ?, ?, ?, (SELECT email FROM gebruikers WHERE email = ?))");
                    $statement->execute(array($nieuw_product['product_code'], $nieuw_product['product_naam'], $nieuw_product['product_aantal'], $nieuw_product['product_prijs'], $user_email));
                }
            }
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
                // Verwijder product uit de database
                $statement = $conn->prepare("DELETE FROM kruiwagen WHERE productCode = ? AND email = (SELECT email FROM gebruikers WHERE email = ?)");
                $statement->execute([$key, $_SESSION["email"]]);
                // Verwijder product uit de sessie
                unset($_SESSION["producten"][$key]);
            }
        }
    } elseif (isset($_POST["product_aantal"]) || isset($_POST["verminder_code"])) {
        if (isset($_POST["product_aantal"]) && is_array($_POST["product_aantal"])) {
            foreach ($_POST["product_aantal"] as $key => $value) {
                if (is_numeric($value)) {
                    $_SESSION["producten"][$key]["product_aantal"] = $value;
                }
            }
        }
        // Verwijder het product uit de sessie en verminder het aantal in de database
        if (isset($_POST["verminder_code"]) && is_array($_POST["verminder_code"])) {
            foreach ($_POST["verminder_code"] as $key) {
                // Voorbereid de SQL-query
                $statement = $conn->prepare("UPDATE kruiwagen SET productAantal = productAantal - 1 WHERE productCode = ? AND email = (SELECT email FROM gebruikers WHERE email = ?)");

                // Voer de SQL-query uit
                $statement->execute([$key, $_SESSION["email"]]);

                // Controleer of de query is uitgevoerd
                if ($statement->rowCount() > 0) {
                    // Verwijder product uit de sessie als de query succesvol is
                    unset($_SESSION["producten"][$key]);
                } else {
                    // Geef een foutmelding weer als de query niet is uitgevoerd
                    echo "Fout: Het product met code $key kon niet worden verminderd.";
                }
            }
        }
    }
} else {

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
                // check of het product al in de winkelwagen staat,
                if (isset($_SESSION["producten"][$nieuw_product['product_code']])) {
                    // Als het product al in de winkelwagen zit, verhoog het aantal met 1
                    $_SESSION["producten"][$nieuw_product['product_code']]["product_aantal"] += $nieuw_product["product_aantal"];
                } else {
                    // Als het product nog niet in de winkelwagen zit, voeg het dan toe
                    $_SESSION["producten"][$nieuw_product['product_code']] = $nieuw_product;
                }
            } else {
                // Als er nog geen producten in de sessie zijn, voeg dit product dan toe
                $_SESSION["producten"][$nieuw_product['product_code']] = $nieuw_product;
            }
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
        // verminderd het product met 1 als de knop wordt ingedrukt
    } elseif (isset($_POST["verminder_code"]) && is_array($_POST["verminder_code"])) {
        foreach ($_POST["verminder_code"] as $key) {
            $_SESSION["producten"][$key]["product_aantal"] -= 1;
        }
    }
}
// stuur de gebruiker naar de juiste pagina terug
$url_terug = (isset($_POST["url_terug"])) ? urldecode($_POST["url_terug"]) : 'shop.php';
header('Location:' . $url_terug);
