<?php
require "validation.php";

$client = "client";
$breuvage = "breuvage";
$format = "format";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$client]) && estValide($_POST[$client])) {
    setcookie($client, $_POST[$client], time() + (30 * 24 * 60 * 60), "/", "", true, true);
    enregisterPart1($_POST[$breuvage], $_POST[$format]);
    pageBreuvage($_POST[$breuvage]);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étape 1</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="container-fluid pt-3">
    <header>
        <img src="img/logo.svg" alt="logo">
        <h2 class="bold mt-3 mb-3">Étape 1 - Choix du breuvage</h2>
    </header>
    <main>
        <?php erreurNomClient(); ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="client">Nom</label>
                <input class="form-control" type="text" id="client" name="client" placeholder="Nom complet"
                    value="<?php
                            if (isset($_COOKIE[$client])) echo $_COOKIE[$client];
                            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$client]) && !estValide($_POST[$client])) echo "";
                            ?>">
            </div>

            <div class="form-group">
                <label for="breuvage" class="form-label">Breuvage</label>
                <select class="form-control text-dark border-0 selectColor" id="breuvage" name="breuvage">
                    <?php ecrireOptionsDeBreuvage() ?>
                </select>
            </div>

            <div class="form-group">
                <label for="format" class="form-label">Format</label>
                <input type="range" class="custom-range" min="1" max="5" id="format" name="format"
                    value="<?php if (isset($_SESSION['formatEnNombre'])) echo $_SESSION['formatEnNombre']; ?>">
                <div class="d-flex justify-content-between">
                    <?php ecrireFormat() ?>
                </div>
            </div>

            <input class="rounded-pill form-control btn-light border border-dark" type="submit" value="Commander mon café">
        </form>
    </main>
</body>

</html>