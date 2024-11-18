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
} catch (PDOException $e) {
    echo "Database connectie gefaald: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['groepNaam'])) {
    $groepNaam = $_POST['groepNaam'];

    $query = "DELETE FROM inschrijvingen WHERE groepNaam = :groepNaam";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':groepNaam', $groepNaam, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: pinboard.php"); // Terug naar het dashboard
        exit();
    } else {
        echo "Verwijderen mislukt";
    }
} else {
    header("Location: opdrachtgever.php");
    exit();
}
