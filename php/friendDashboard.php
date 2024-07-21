<?php 
session_start();

$idAmi = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$idDuVisiteur = $_SESSION["id"];
include("fonctionsPHP.php");
require("../pdo/pdo.php");;

$maRequete = $pdo->prepare("SELECT * FROM profil WHERE user_id = :id");
$maRequete->execute([
    ":id" => $idAmi
]);
$pageProfilDeMonAmi = $maRequete->fetch(PDO::FETCH_ASSOC);

$maRequete = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$maRequete->execute([
    ":id" => $idAmi
]);
$infoDeMonAmi = $maRequete->fetch(PDO::FETCH_ASSOC);

$maRequete = $pdo->prepare("SELECT * FROM post WHERE user_id = :id");
$maRequete->execute([
    ":id" => $idAmi
]);
$postDeMonAmi = $maRequete->fetchAll(PDO::FETCH_ASSOC);

commenterUnePublication($idDuVisiteur);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de <?= $infoDeMonAmi["username"]; ?></title>
    <link rel="stylesheet" href="../PAGE HTML/style.css">
</head>
<body>
<div>
    <?php include("navbar.php"); ?> 
</div>

<div id="page">
    <div id="banner">
        <?php afficherMonImageDeProfil($infoDeMonAmi["id"]); ?>
        <div class="fleex">
            <div id="name"><?php afficherMonUsername($infoDeMonAmi["username"]); ?></div>
            <div id="biography"><?php afficherMaBiographie($infoDeMonAmi["id"]); ?></div>
        </div>
    </div>

    <div class="flex">
        <div id="personnalInformation">
            <br> 
            <button type="button"><a href="profil.php">Retour</a></button>
            <br>
        </div>
    
        <div class="content_all">
            <?php afficherMesPublications($infoDeMonAmi["id"]); ?>            
        </div>
    </div>
</div>
</body>
</html>


    

 