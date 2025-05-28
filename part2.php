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

                        <!-- Arabica -->
                        <div class="col-12 col-md-4 d-flex flex-column align-items-center mb-4">
                            <img class="imageGrain mb-2" src="img/arabica.webp" alt="arabica">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="grain" id="arabica" value="Arabica" <?php grainSelectione($_SESSION['breuvage'], "Arabica") ?>>
                                <label class="form-check-label" for="arabica">Arabica</label>
                            </div>
                        </div>

                        <!-- Robusta -->
                        <div class="col-12 col-md-4 d-flex flex-column align-items-center mb-4">
                            <img class="imageGrain mb-2" src="img/robusta.webp" alt="robusta">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="grain" id="robusta" value="Robusta" <?php grainSelectione($_SESSION['breuvage'], "Robusta") ?>>
                                <label class="form-check-label" for="robusta">Robusta</label>
                            </div>
                        </div>

                        <!-- Kopi Luwak -->
                        <div class="col-12 col-md-4 d-flex flex-column align-items-center mb-4">
                            <img class="imageGrain mb-2" src="img/kopi-luwak.webp" alt="kopi-luwak">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="grain" id="kopiLuwak" value="Kopi Luwak" <?php grainSelectione($_SESSION['breuvage'], "Kopi Luwak") ?>>
                                <label class="form-check-label" for="kopiLuwak">Kopi Luwak</label>
                            </div>
                        </div>

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