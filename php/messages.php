<?php 
session_start();
require('../pdo/pdo.php');

// Vérification de la session utilisateur
if(!isset($_SESSION['id'])){
    echo "Vous n'êtes pas connecté."; 
    exit; // Arrêter l'exécution du script si l'utilisateur n'est pas connecté
}

// Récupération de l'identifiant de l'ami à partir de la requête GET
if(isset($_GET['friend_id'])) {
    $friend_id = $_GET['friend_id'];

    // Vérification si le formulaire est soumis pour l'envoi du message
    if(isset($_POST['send']) && isset($_POST['message'])) {
        // Récupération du message envoyé
        $message = $_POST['message'];

        try {
            // Insertion du message dans la base de données en utilisant PDO
            $stmt = $pdo->prepare("INSERT INTO messages (created_at, send, who_send, who_receive) VALUES (NOW(), :message, :who_send, :who_receive)");
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':who_send', $_SESSION['id']);
            $stmt->bindParam(':who_receive', $friend_id);
            $stmt->execute();
            echo "Message envoyé avec succès!";
        } catch(PDOException $e) {
            echo "Erreur lors de l'envoi du message: " . $e->getMessage();
        }
    }

    try {
        // Récupération des messages entre l'utilisateur et l'ami sélectionné
        $stmt = $pdo->prepare("SELECT * FROM messages WHERE (who_send = :user_id AND who_receive = :friend_id) OR (who_send = :friend_id AND who_receive = :user_id) ORDER BY created_at ASC");
        $stmt->bindParam(':user_id', $_SESSION['id']);
        $stmt->bindParam(':friend_id', $friend_id);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Erreur lors de la récupération des messages: " . $e->getMessage();
    }
} else {
    echo "Veuillez sélectionner un ami pour commencer la conversation.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat privé</title>
  
    <!-- Lien vers la feuille de style -->
    <link rel="stylesheet" href="../Page HTML/chatenligne.css">
</head>
<body>

<?php if(isset($_SESSION['id'])) : ?>
    <div id="page" class="container border">
        <a href="chat.php">Retour</a>
        <br>
        <h1>Chat privé</h1>
        <div class="messages_box">
            <!-- Affichage des messages existants -->
            <?php if(isset($messages) && !empty($messages)) : ?>
                <ul>
                    <?php foreach($messages as $message) : ?>
                        <!-- Utilisation d'une expression ternaire pour déterminer le style -->
                        <li class="<?php echo ($_SESSION['id'] == $message['who_send']) ? 'sent' : 'received'; ?>"><?php echo $message['send']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Formulaire pour envoyer un nouveau message -->
        <form class="send_message" method="POST">
            <textarea name="message" cols="30" rows="2" placeholder="Votre message"></textarea><br>
            <input type="submit" value="Envoyer" name="send">
        </form>
    </div>
<?php else : ?>
    <p>Veuillez vous connecter pour accéder au chat privé.</p>
<?php endif; ?>
</body>
</html>

