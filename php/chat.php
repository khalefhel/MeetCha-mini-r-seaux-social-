<?php 
session_start();

include("fonctionsPHP.php");
checkLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../Page HTML/list_message.css">
</head>
<body>
    <div id="page">
        <!-- Votre contenu existant -->
        <a href="home.php">Retour</a>
        <!-- Affichage de la liste des amis -->
        <div id="liste_amis">
            <h1>Votre liste d'amis </h1>
            <?php
                $maListeAmi = afficherMaListeAmi();
                if(!empty($maListeAmi)) {
                    echo "<table>";
                    foreach($maListeAmi as $valueInMaListeAmi) {
                        echo '<tr><td>'.
                             '<form method="GET" action="messages.php">'.
                             '<input type="hidden" name="friend_id" value="'.$valueInMaListeAmi['friend_id'].'">'.
                             '<button type="submit" name="submit">Chat avec '.$valueInMaListeAmi['friend_username'].'</button>'.
                             '</form></td></tr>';
                    }
                    echo "</table>";
                } else {
                    echo "<p>Vous n'avez pas encore d'amis.</p>";
                }
            ?>
        </div>
        
    </div>
</body>
</html>
