<?php
require "validation.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Commande confirmé</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body class="container-fluid pt-3">

  <header>
    <img src="img/logo.svg" alt="logo">
    <h1 class="bold">Commande effectué</h1>
  </header>

  <main>
    <p class="bold mb-0">Nom:</p>
    <p>
      <?php echo $_COOKIE['client'] ?>
    </p>

    <div>
      <div class="row">
        <div class="col">
          <p class="bold mb-0">Breuvage:</p>
        </div>
        <div class="col">
          <p class="bold mb-0">Format:</p>
        </div>
        <div class="col">
          <p class="bold mb-0">Grain:</p>
        </div>
      </div>
    </div>

    <div>
      <div class="row">
        <div class="col">
          <p class="mb-0">
            <?php echo $_SESSION['breuvage'] ?>
          </p>
        </div>
        <div class="col">
          <p class="mb-0">
            <?php echo $_SESSION['format'] ?>
          </p>
        </div>
        <div class="col">
          <p class="mb-0">
            <?php echo $_SESSION['grain'] ?>
          </p>
        </div>
      </div>
    </div>

    <p class="bold mt-3 mb-0">Option:</p>

    <ul>
      <?php maquetteConfirm() ?>
    </ul>

    <form action="accueil.php" method="post">
      <input class="rounded-pill form-control btn-light border border-dark" type="submit" value="Commander mon café">
    </form>
    <main>
</body>

</html>