<?php
require_once "validation.php";
session_destroy();
?>
<!-- Auteur : Thanh Nam Nguyen -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="text-center">
    <header>
        <img src="img/logo.svg" alt="logo">
        <h1>Bienvenue</h1>
    </header>
    <main>
        <form action="part1.php" method="post">
            <input class="rounded-pill btn-lg btn-light border border-dark" type="submit" value="Commander mon café">
        </form>
    </main>
</body>

</html>