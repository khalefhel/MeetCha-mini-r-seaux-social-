<?php
session_start();
require('../pdo/pdo.php');

// Vérification de la session utilisateur
if(!isset($_SESSION['id'])){
    echo "Vous n'êtes pas connecté."; 
    exit; // Arrêter l'exécution du script si l'utilisateur n'est pas connecté
} else {
    $userID = $_SESSION['id']; // Définir $userID ici
}
// Vérifier si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les variables POST sont définies et non vides
    if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['date_time']) &&
       !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['date_time'])) {
        
        // Récupérer l'ID de l'utilisateur à partir de la session
        $user_id = $_SESSION['id'];

        // Récupérer les données du formulaire
        $title = $_POST['title'];
        $description = $_POST['description'];
        $date_time = $_POST['date_time'];

        // Préparer la requête d'insertion
        $sql = "INSERT INTO events (user_id, title, description, date_time) VALUES (:user_id, :title, :description, :date_time)";
        $stmt = $pdo->prepare($sql);

        // Liaison des valeurs et exécution de la requête
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date_time', $date_time);

        if ($stmt->execute()) {
            echo '<div id="participation-alert" class="alert alert-success centered-alert alert-dismissible fade show" role="alert">Événement ajouté avec succès. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } else {
            echo '<div id="participation-alert" class="alert alert-warning centered-alert alert-dismissible fade show" role="alert">Une erreur est survenue lors de lajout de lévénement.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    } else {
        echo '<div id="participation-alert" class="alert alert-warning centered-alert alert-dismissible fade show" role="alert">Veuillez remplir tous les champs du formulaire.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        echo "Veuillez remplir tous les champs du formulaire.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - <?= $_SESSION["username"] ?></title>
    <link rel="stylesheet" href="../Page HTML/evenement.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div>
    <?php
    include("navbar.php");
    ?> 
</div>
<div class="container" style ="margin:5px;">
    <div class="row">
        <!-- Colonne pour le formulaire -->
        <div class="col-md-4" style="border: 2px Dotted orange; border-radius: 10px; margin:10px; padding:10px;background-color:  #f2f2f2;">
            <div class="container mt-5">
                <form action="evenement.php" method="POST">
                    <div class="mb-3">
                        <h5>Ajouter un nouvel événement </h5>
                        <label for="title" class="form-label">Titre de l'événement:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_time" class="form-label">Date et heure:</label>
                        <input type="datetime-local" class="form-control" id="date_time" name="date_time" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
        <!-- Colonne pour afficher les événements -->
        <div class="col-md-7" style="border: 2px Groove orange; border-radius: 10px; margin:10px;background-color: #eee6d0;">
            <div class="container">
                <?php 
                include("fonctionsPHP.php");
                
                if(isset($_POST['participate_event'])) {
                    // Récupérer l'ID de l'événement à partir du formulaire
                    $event_id = $_POST['event_id'];
                    
                    // Récupérer l'ID de l'utilisateur à partir de la session
                    $user_id = $_SESSION['id'];
                    
                    // Vérifier si l'utilisateur a déjà participé à cet événement
                    $sql_check_participation = "SELECT COUNT(*) FROM participants WHERE event_id = :event_id AND user_id = :user_id";
                    $stmt_check_participation = $pdo->prepare($sql_check_participation);
                    $stmt_check_participation->bindParam(':event_id', $event_id);
                    $stmt_check_participation->bindParam(':user_id', $user_id);
                    $stmt_check_participation->execute();
                    $count = $stmt_check_participation->fetchColumn();
                    
                    // Si l'utilisateur a déjà participé à l'événement, afficher un message d'erreur
                    if($count == 0) {
                        // Enregistrer la participation dans la table
                        participerEvenement($event_id, $user_id);
                        echo '<div id="participation-alert" class="alert alert-success centered-alert alert-dismissible fade show" role="alert">Vous avez participé à cet événement. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    } else {                       
                       echo '<div id="participation-alert" class="alert alert-warning centered-alert alert-dismissible fade show" role="alert">Vous avez déjà participé à cet événement. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    } 
                }
                echo "<h4>Vos évenements</h4>";
                afficherEvenementsUtilisateurConnecte();
                echo "<h4>Les évenements de vos amis</h4>";
                afficherEvenementsAmis($userID);                
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    // Fermer l'alerte quand le bouton "x" est cliqué
    var closeButtons = document.querySelectorAll('.btn-close');
    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var alert = this.closest('.alert');
            alert.remove();
        });
    });
</script>
</body>
</html>
