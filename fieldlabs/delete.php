<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$dsn = "mysql:host=localhost;dbname=fieldlabs";
$username = "bit_academy";
$password = "bit_academy";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connectie gefaald: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['opdrachtSleutel'])) {
    $opdrachtSleutel = $_POST['opdrachtSleutel'];

    // Haal de opdrachtNaam op voor de gegeven opdrachtSleutel
    $opdrachtQuery = "SELECT opdrachtNaam FROM opdrachten WHERE opdrachtSleutel = :opdrachtSleutel";
    $stmtOpdracht = $pdo->prepare($opdrachtQuery);
    $stmtOpdracht->bindParam(':opdrachtSleutel', $opdrachtSleutel, PDO::PARAM_INT);
    $stmtOpdracht->execute();
    $opdracht = $stmtOpdracht->fetch(PDO::FETCH_OBJ);

    if ($opdracht) {
        $opdrachtNaam = $opdracht->opdrachtNaam;

        // Start een transactie
        $pdo->beginTransaction();

        try {
            // Verwijder de inschrijvingen voor deze opdracht
            $deleteInschrijvingenQuery = "DELETE FROM inschrijvingen WHERE opdrachtNaam = :opdrachtNaam";
            $stmtInschrijvingen = $pdo->prepare($deleteInschrijvingenQuery);
            $stmtInschrijvingen->bindParam(':opdrachtNaam', $opdrachtNaam, PDO::PARAM_STR);
            $stmtInschrijvingen->execute();

            // Verwijder de opdracht zelf
            $deleteOpdrachtQuery = "DELETE FROM opdrachten WHERE opdrachtSleutel = :opdrachtSleutel";
            $stmtOpdracht = $pdo->prepare($deleteOpdrachtQuery);
            $stmtOpdracht->bindParam(':opdrachtSleutel', $opdrachtSleutel, PDO::PARAM_INT);
            $stmtOpdracht->execute();

            // Commit de transactie
            $pdo->commit();

            header("Location: pinboard.php");
            exit();
        } catch (Exception $e) {
            // Rol de transactie terug bij een fout
            $pdo->rollBack();
            echo "Verwijderen mislukt: " . $e->getMessage();
        }
    } else {
        echo "Opdracht niet gevonden.";
    }
} else {
    header("Location: pinboard.php");
    exit();
}
?>
