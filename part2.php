<?php
require "validation.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    enregisterPart2();
    part1OuCommande();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étape 2</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script defer src="js/scripts.js"></script>
</head>

<body class="container-fluid pt-3">

    <header>
        <img src="img/logo.svg" alt="logo">
        <h2 class="mt-3 mb-3">Étape 2 - Choix du breuvage</h2>
    </header>

    <main>

        <form action="" method="post">

            <p class="bold">Grain</p>

            <fieldset class="bg-white pt-3 pb-3 mb-3">
                <div class="container">
                    <div class="row justify-content-center">
                        <?php ecrireTypeDeGrain() ?>
                    </div>
                </div>
            </fieldset>

            <p class="bold">Options</p>

            <?php maquette(); ?>

            <div class="d-flex justify-content-between gap-20px">
                <input class="rounded-pill form-control btn-light border border-dark" name="retour" type="submit" value="Retour">
                <input class="rounded-pill form-control btn-light border border-dark" name="confirmer" type="submit" value="Confirmer ma commande">
            </div>
        </form>
    </main>
</body>

</html>