<nav class="navbar navbar-expand-sm bg-warning" style="margin-bottom: 2%;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="img/buurman-logo.jpg" alt="Logo" style="width:50px; border-radius: 6rem;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="text-light nav-link btn btn-danger" href="shop.php">Winkel</a>
                </li>
                <li class="nav-item">
                    <a class="text-light nav-link btn btn-danger" href="contact.php">Contact</a>
                </li>
                <!-- als er geen sessie email bestaat dan heb je registreer en inlog in de navbar -->
                <?php
                if (!isset($_SESSION['email'])) {

                    echo '
                <li class="nav-item">
                    <a class="text-light nav-link btn btn-danger" href="registreer.php">Registreer</a>
                </li>
                <li class="nav-item">
                    <a class="text-light nav-link btn btn-danger" href="login.php">Login</a>
                </li>';
                }
                ?>
                <!-- als er wel een sessie email is dan heb je een uitlog knop in de navbar -->
                <?php
                if (isset($_SESSION['email'])) {
                    //uitlog
                    echo '
                    <form method="post">
                        <button class=" text-light nav-link btn btn-danger" type="submit" name="Uitlog">Uitlog</button>
                    </form>
                    ';
                    // al heb je op uitlog gedrukt dan vernietigt hij de sessie email
                    if (isset($_POST["Uitlog"])) {
                        session_destroy();
                        header("Refresh:0");
                    }
                }
                ?>
                <?php
                if (isset($_SESSION['email'])) {
                    $conn = dbConnect();
                    $statement = $conn->prepare('SELECT gebruikersNaam FROM gebruikers WHERE email = :email');
                    $statement->execute(array(':email' => $_SESSION['email']));
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    $naam = $result['gebruikersNaam'];
                    echo '<li class="nav-item">
                            <span class="text-light nav-link">Welkom, ' . $naam . '</span>
                          </li>';
                }
                ?>
                
            </ul>
            <!-- zoekbalk met naam zoekterm -->
            <form class="d-flex" method="post" action="shop.php">
                <input class="form-control me-2" type="search" placeholder="Zoeken naar producten..." aria-label="Zoeken" name="zoekterm">
                <button class="btn btn-danger" type="submit">Zoeken</button>
            </form>
        </div>
        <a class="kruiwagen" href="kruiwagen.php">
            <img src="img/kruiwagen.png" alt="Logo" style="width:50px;"></a>
    </div>
</nav>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>