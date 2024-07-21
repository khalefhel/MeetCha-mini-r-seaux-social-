<?php
session_start();
include("fonctionsPHP.php");
checkLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - <?= $_SESSION["username"] ?></title>
    <!-- Inclure Bootstrap -->
    <link rel="stylesheet" href="../Page HTML/style_Home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div>
    <?php
    include("navbar.php");
    ?> 
</div>
  <div class="sec">  
      <h1>Bienvenue <?= $_SESSION["username"] ?></h1>
      <div class="content_all">
          <?php afficherPublicationsAmis($_SESSION['id']);
           ?>
      </div></div>
  
    <!-- Mettez ici votre code HTML pour afficher les publications -->
    <!-- Inclure Bootstrap JS pour les fonctionnalités JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>