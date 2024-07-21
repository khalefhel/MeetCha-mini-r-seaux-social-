<?php
session_start();

// Vérifier si les données POST sont présentes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["commentaire"])) {
    // Inclure le fichier pdo.php pour établir la connexion à la base de données
    require("../pdo/pdo.php");

    // Récupérer les données du formulaire
    $post_id = $_POST["post_id"];
    $user_id = $_POST["user_id"];
    $text = $_POST["text"];

    // Préparer la requête d'insertion du commentaire
    $query = "INSERT INTO commentary (post_id, user_id, text) VALUES (:post_id, :user_id, :text)";
    $statement = $pdo->prepare($query);

    // Liaison des valeurs aux paramètres de la requête
    $statement->bindParam(":post_id", $post_id, PDO::PARAM_INT);
    $statement->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $statement->bindParam(":text", $text, PDO::PARAM_STR);

    // Exécuter la requête
    if ($statement->execute()) {
        // Rediriger vers la page précédente après l'ajout du commentaire
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit();
    } else {
        // En cas d'échec de l'exécution de la requête, afficher un message d'erreur
        echo "Erreur lors de l'ajout du commentaire.";
    }
} else {
    // Rediriger vers la page d'accueil si les données POST ne sont pas présentes
    header("Location: home.php");
    exit();
}
?>

