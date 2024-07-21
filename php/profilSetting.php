<?php 
session_start();
include("fonctionsPHP.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

   $laNouvelleDescription = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
    $changementEffectue = 0;
    
    if(isset($_FILES['profilPicture'])){
        uploadMaPhoto('profilPicture' ,"profil");  
        $changementEffectue++;
    }
    
    if($laNouvelleDescription){
        changeDescriptionUser($laNouvelleDescription);
        $changementEffectue++;
    }
    
    if($changementEffectue > 0){
        echo '<center>Les changements ont été effectués.</center>';
    }
}

checkLogin();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le profil</title>
    <link rel="icon" type="image/x-icon" sizes="16x16" href="../Page HTML/image/coliscomp.ico">
    <link rel="stylesheet" href="../Page HTML/profilEdit.css">
</head>
<body>

    <div id="page">
        <a href="profil.php">Retour</a>
        <form method="post" action="" enctype="multipart/form-data">
    <label id="editPhoto" for="profilPicture">Modifier la photo de profil</label>
    <div><img id="photo" src="<?php echo isset($_POST['save']) ? 'images/' . $_FILES['profilPicture']['name'] : ''; ?>" alt=""></div>
    <input id="profilPicture" type="file" name="profilPicture">
    <label id="editBiography" for="description">Modifier la biographie</label>   
    <textarea name="description" id="description" placeholder="Biographie" rows="4" maxlength="200"></textarea>
    <button type="submit" name="save" id="saveBiography">Enregistrer</button>
</form>

<?php
if(isset($_POST['save'])) {
    // Répertoire où vous souhaitez enregistrer les images
    $target_dir = "images/";

    // Chemin complet de l'image téléchargée
    $target_file = $target_dir . basename($_FILES["profilPicture"]["name"]);

    // Vérifie si le fichier est une image réelle ou une fausse image
    $check = getimagesize($_FILES["profilPicture"]["tmp_name"]);
    if($check !== false) {
        // Enregistre l'image dans le répertoire spécifié
        move_uploaded_file($_FILES["profilPicture"]["tmp_name"], $target_file);
    } else {
        echo "Le fichier n'est pas une image.";
    }
}
?>

        
    </div>
</body>
</html>

