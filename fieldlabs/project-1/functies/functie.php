<?php
function connectie()
{
    //mysql gegevens
    $servername = "localhost";
    $database = "fieldlabs";
    $dsn = "mysql:host=$servername;dbname=$database";
    $gebruikername = "bit_academy";
    $wachtwoord = "bit_academy";
    //database aanmaken met pdo functie
    $conn = new PDO($dsn, $gebruikername, $wachtwoord);
    //geeft de connectie terug
    return $conn;
}

function opdrachtmaken($conn)
{
    if (isset($_POST['submit'])) {
        $opdrachtNaam = $_POST['opdrachtNaam'];
        $opdrachtBeschrijving = $_POST['opdrachtBeschrijving'];
        $naam = $_POST['naam'];
        $telefoon = $_POST['telefoon'];
        $email = $_SESSION['email'];

        // Validate input
        if (empty($opdrachtNaam) || empty($opdrachtBeschrijving) || empty($naam) || empty($telefoon)) {
            echo "All fields are required.";
            return;
        }

        // Try-catch block for database operation
        try {
            // Check if the assignment already exists
            $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM `opdrachten` WHERE `opdrachtNaam` = :opdrachtNaam AND `opdrachtBeschrijving` = :opdrachtBeschrijving AND `email` = :email");
            $stmtCheck->bindParam(':opdrachtNaam', $opdrachtNaam);
            $stmtCheck->bindParam(':opdrachtBeschrijving', $opdrachtBeschrijving);
            $stmtCheck->bindParam(':email', $email);
            $stmtCheck->execute();

            $count = $stmtCheck->fetchColumn();

            if ($count > 0) {
                echo "<p style='color: white;'>Deze opdracht bestaat al.</p>";
                return;
            }

            // Insert the new assignment
            $stmtUpdate = $conn->prepare("INSERT INTO `opdrachten` (`opdrachtNaam`, `opdrachtBeschrijving`, `naam`, `telefoon`, `email`) 
                                          VALUES (:opdrachtNaam, :opdrachtBeschrijving, :naam, :telefoon, :email)");

            $stmtUpdate->bindParam(':opdrachtNaam', $opdrachtNaam);
            $stmtUpdate->bindParam(':opdrachtBeschrijving', $opdrachtBeschrijving);
            $stmtUpdate->bindParam(':naam', $naam);
            $stmtUpdate->bindParam(':telefoon', $telefoon);
            $stmtUpdate->bindParam(':email', $email);

            $stmtUpdate->execute();
            echo "<p style='color: white;'>Opdracht succesvol toegevoegd!<p>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}


function inschrijvingen($conn)
{
    if (isset($_POST['submit'])) {
        $groepNaam = $_POST['groepNaam'];
        $eigenNaam = $_POST['eigenNaam'];
        $leden = $_POST['leden'];
        $opdrachtNaam = $_POST['opdrachtNaam']; // voeg deze regel toe

        if (empty($groepNaam) || empty($eigenNaam) || empty($leden) || empty($opdrachtNaam)) {
            echo "All fields are required.";
            return;
        }

        try {
            // // Controleer of er al een groep is ingeschreven voor de opdracht
            // $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM `inschrijvingen` WHERE `opdrachtNaam` = :opdrachtNaam");
            // $stmtCheck->bindParam(':opdrachtNaam', $opdrachtNaam);
            // $stmtCheck->execute();

            // $count = $stmtCheck->fetchColumn();

            // if ($count > 0) {
            //     echo "<script>alert('Er is al een groep ingeschreven voor deze opdracht.');</script>";
            //     return;
            // }

            // Controleer of dezelfde groep al is ingeschreven voor deze opdracht
            $stmtCheckGroup = $conn->prepare("SELECT COUNT(*) FROM `inschrijvingen` WHERE `groepNaam` = :groepNaam AND `opdrachtNaam` = :opdrachtNaam");
            $stmtCheckGroup->bindParam(':groepNaam', $groepNaam);
            $stmtCheckGroup->bindParam(':opdrachtNaam', $opdrachtNaam);
            $stmtCheckGroup->execute();

            $countGroup = $stmtCheckGroup->fetchColumn();

            if ($countGroup > 0) {
                echo "Deze groep is al ingeschreven voor deze opdracht.";
                return;
            }

            $stmtUpdate = $conn->prepare("INSERT INTO `inschrijvingen` (`groepNaam`, `eigenNaam`, `leden`, `opdrachtNaam`) 
                        VALUES (:groepNaam, :eigenNaam, :leden, :opdrachtNaam)");
            $stmtUpdate->bindParam(':groepNaam', $groepNaam);
            $stmtUpdate->bindParam(':eigenNaam', $eigenNaam);
            $stmtUpdate->bindParam(':leden', $leden);
            $stmtUpdate->bindParam(':opdrachtNaam', $opdrachtNaam); // voeg deze regel toe

            $stmtUpdate->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}


