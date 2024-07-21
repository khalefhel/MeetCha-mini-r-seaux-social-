<?php 
session_start();

include("fonctionsPHP.php");


checkLogin();
/* Création d'une publication */
$boutonEnvoiMonPost = filter_input(INPUT_POST, "boutonEnvoiMonPost");
$titrePublication = filter_input(INPUT_POST, "titrePublication");
$textePublication = filter_input(INPUT_POST, "textePublication");

if(isset($boutonEnvoiMonPost)){
    $monCheminImage = uploadMaPhoto("imagePublication", "post");
    if($monCheminImage != "Erreur, votre photo n'a pas été upload."){
        if($titrePublication && $textePublication){
            creerUnePublication($monCheminImage, $textePublication, $titrePublication); 
        }
        
    };
    
};


if(isset($_GET['research']) AND !empty($_GET['research'])){
    $bdd = new PDO('mysql:host=localhost; dbname=reseau-social;','root','root');
    $allmembers = $bdd->prepare('SELECT * FROM users ORDER BY id DESC');
    $search = htmlspecialchars($_GET['research']);
    $allmembers = $bdd->query('SELECT * FROM users WHERE username LIKE "' .$search.'%" ORDER BY id DESC');
}

if(isset($_POST['Ajouter'])){
    require('../pdo/pdo.php');
    $idFriend  = filter_input(INPUT_POST,"idFriend");    
    
    // REQUETE 1 : Recuperer le username de l'ami grâce à $idFriend

    $userfriend = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $userfriend->execute([
        ":id" => $idFriend 
    ]);
    $result = $userfriend->fetch();
    // REQUETE 2 : Verifier si l'ami n'est pas déjà dans la friendlist de l'utilisateur

     $verification = $pdo->prepare('SELECT * FROM friendlist WHERE friend_id = :friend_id AND user_id = :user_id');
     $verification->execute([
         ":friend_id" => $idFriend,
         ":user_id" => $_SESSION["id"] 
     ]);
     $resultat = $verification->rowCount();
     
    // Si $resultat == 0 alors l'ami n'est pas dans la friendlist de l'utilisateur
    if($resultat == 0){

      // REQUETE 3 : Ajout dans la friendlist 
      $ajouteAmi = $pdo->prepare('INSERT INTO friendlist (friend_id,friend_username,user_id) VALUES (:friend_id, :friend_username, :user_id)');
      $ajouteAmi->execute([
          ":friend_id" => $idFriend,
          ":friend_username" => $result["username"],
          ":user_id" => $_SESSION["id"]
      ]); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" sizes="16x16" href="../Page HTML/image/logo1.png">
    <title>Page de profil <?= $_SESSION["username"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../Page HTML/style.css" />
   
</head>

<body>
<div>
    <?php
    include("navbar.php");
    ?> 
</div>

<div id="page">
<div id="banner">
    <?php
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['username'])) {
        // Récupérer le nom d'utilisateur de la session
        $username = $_SESSION["username"];
        
        // Afficher le nom d'utilisateur
        echo "<h2>" . afficherMonUsername($username) . "</h2>";

        // Récupérer l'ID de l'utilisateur à partir du nom d'utilisateur
        $idUtilisateur = fromTableProfil($username);

        // Afficher l'image de profil
        echo afficherMonImageDeProfil($idUtilisateur);

        // Afficher la biographie
        echo "<p>" . afficherMaBiographie($idUtilisateur) . "</p>";
    } else {
        // Si l'utilisateur n'est pas connecté, afficher un message approprié
        echo "<p>Connectez-vous pour afficher votre profil.</p>";
    }
    ?>
</div>




    <div class="flex">
        <div id="personalInformations">
           
               <h3>Gérer votre compte:</h3>
           

           
            <a href="profilSetting.php"><img src="../Page HTML/image/profile.png" alt="Profil"> Editer mon profil</a>
            <a href="personnalSetting.php"><img src="../Page HTML/image/infos.png" alt="Infos"> Editer vos infos persos</a>
            
            <?php
            $maListeAmi = afficherMaListeAmi();
            echo "<table><tr><th>Votre liste d'ami :</th></tr>";
            if(isset($maListeAmi)){
                foreach($maListeAmi as $valueInMaListeAmi){
                    echo '<tr><td><form method="GET" action="deleteFriend.php?id='.$valueInMaListeAmi['friend_id'].'">'.
                    '<button name="friend_id" type="submit" value="'.$valueInMaListeAmi['friend_id'].'">X</button> '.
                    '<a href="friendDashboard.php?id='.$valueInMaListeAmi['friend_id'].'">'.$valueInMaListeAmi['friend_username'].'</a></form>'.'</td></tr>';
                }
            }
            echo "</table>";
            ?>
        </div>
    </div>
</div>
<div class="coteAcote">
  <div class="margin">
    <div id="publication_container">
      <form action="" method="post" enctype="multipart/form-data">
        <div id="publication"> 
          <h2>Créer une publication :</h2>

          <input id="text" placeholder="Titre" type="text" name="titrePublication">

          <input type="text" placeholder="Contenu..." id="text" name="textePublication">
          
          <div id="button">
            <input class="button button1" name="imagePublication" type="file">
          </div>
          <button name="boutonEnvoiMonPost" type="submit" class="button button2">Envoyer</button>
        </div>
      </form>
    </div>
  </div>

  <div class="content_all">
    <?php afficherMesPublications(""); ?>  
  </div>
</div>

</body>
</html>


    

    

 