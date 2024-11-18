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

    $query = "DELETE FROM opdrachten WHERE opdrachtSleutel = :opdrachtSleutel";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':opdrachtSleutel', $opdrachtSleutel, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: pinboard.php");
        exit();
    } else {
        echo "Verwijderen mislukt.";
    }
} else {
    header("Location: pinboard.php");
    exit();
}
?>