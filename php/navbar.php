<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_navbar.css">
    <title>NavBar</title>
</head>
<body>
<nav>
    <ul class="nav_accueil">
        <li class="nav_icon"><a href="home.php"><img src="../Page HTML/image/home.png" alt="Accueil"></a></li>
        <li class="nav_icon"><a href="chat.php"><img src="../Page HTML/image/message.png" alt="Messages"></a></li>
        <li class="nav_icon"><a href="evenement.php"><img src="../Page HTML/image/event_icon.png" alt="Événements"></a></li>
        <li class="nav_icon"><a href="profil.php"><img src="../Page HTML/image/moncompte.png" alt="Mon Compte"></a></li>
    </ul>
    <br>
    <form method="GET" > <!-- Ajout de l'attribut action pour définir la page de traitement -->
        <input type="search" name="research" placeholder="Rechercher un membre">
        <input type="submit" value="Recherche">
    </form>
    <br>
    <?php
    // Vérifie si la variable $allmembers est définie et non vide
    if(isset($allmembers) && !empty($allmembers)){
        // Appelle la fonction rechercherAmi si $allmembers est définie
        rechercherAmi($allmembers);
    }
    
    // Définit la fonction rechercherAmi
    function rechercherAmi($allmembers){
        // Vérifie si la requête a retourné des résultats
        if($allmembers->rowCount() > 0){
            // Parcours les résultats
            foreach($allmembers as $valueInAllMembers){
                // Vérifie si l'utilisateur est différent de l'utilisateur connecté
                if($valueInAllMembers["id"] != $_SESSION["id"]){
                    // Requête SQL pour vérifier si l'utilisateur est déjà un ami
                    require('../pdo/pdo.php');
                    $maRequete = $pdo->prepare("SELECT * FROM friendlist WHERE user_id=:user_id AND friend_id=:friend_id");
                    $maRequete->execute([
                        ":user_id" => $_SESSION["id"],
                        ":friend_id" => $valueInAllMembers["id"]
                    ]);
                    $reponse = $maRequete->rowCount();
                    
                    // Affiche le lien vers le tableau de bord de l'ami avec un bouton "Ajouter" si l'utilisateur n'est pas déjà un ami
                    echo '<a href="friendDashboard.php?id='.$valueInAllMembers['id'].'">'.$valueInAllMembers['username'].'</a>';
                    echo '<form method="POST" action="profil.php">';
                    echo '<input type="hidden" name="idFriend" value="'. $valueInAllMembers['id'] . '" />';
                    if($reponse > 0){
                        echo '<input type="submit" name="Ajouter" value="Ajouter">';
                    }
                    echo '</form>';
                }
            }
        }
    }
    ?>
    <a href="deconnexion.php" class="logout-button">Déconnexion</a>
</nav>
</body>
</html>
