<?php
session_start();

$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
$dbname = "fieldlabs";
$message = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "send_code" && isset($_POST['email'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $sql = "SELECT * FROM opdrachtgevers WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $token = getToken();
            $expirationDate = date("Y-m-d H:i:s", strtotime("+5 minutes"));

            $sql = "UPDATE opdrachtgevers SET token='$token', expirationdate='$expirationDate' WHERE email='$email'";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['email'] = $email;
                $message = "Code is naar uw email gestuurd.";
                // Here you would send the token via email
            } else {
                $message = "Error updating record: " . $conn->error;
            }
        } else {
            $message = "Email niet gevonden.";
        }
    } elseif ($action == "verify_code" && isset($_POST['code'])) {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $code = $conn->real_escape_string($_POST['code']);
            $sql = "SELECT * FROM opdrachtgevers WHERE email='$email' AND token='$code' AND expirationdate > NOW()";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                header("Location: pinboard.php");
                exit();
            } else {
                $message = "Ongeldige of verlopen code.";
            }
        } else {
            $message = "Er is geen email gevonden om te verifiëren.";
        }
    }
}

$conn->close();

function getToken()
{
    $characters = '0123456789';
    $maxLength = strlen($characters);
    $token = '';
    for ($i = 0; $i < 6; $i++) {
        $token .= $characters[rand(0, $maxLength - 1)];
    }
    return $token;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fieldlabs || Verifieer</title>
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/verify.css">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4>Email Verificatie</h4>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($message)) : ?>
                                <div class="alert alert-info">
                                    <?php echo $message; ?>
                                </div>
                            <?php endif; ?>
                            <form action="verify.php" method="POST">
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Vul hier uw email in">
                                </div>
                                <button type="submit" name="action" value="send_code" class="btn btn-primary btn-block">Stuur code</button>
                                <div class="form-group mt-4">
                                    <label for="code">Verificatie Code</label>
                                    <input type="text" class="form-control" name="code" id="code" placeholder="Vul hier de code in">
                                </div>
                                <button type="submit" name="action" value="verify_code" class="btn btn-primary btn-block">Verifiëer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button onclick="window.location.href='index.php'" type="button" class="btn btn-primary btn-gradient btn-bottom">Terug</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>