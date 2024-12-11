<?php
include_once('environnement.php');

if (!isset($_SESSION['userName'])) {
    header('Location:index.php');
}
//REQUETE POUR LA RECUPERATION DES TYPES DE MAGIES POUR LE CHAMP SELECT/OPTION
$request = $bdd->query('SELECT *
                        FROM ecole');


if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['ecole'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $ecole = htmlspecialchars($_POST['ecole']);

    if (isset($_FILES['image'])) {
        // NOM DU FICHIER IMAGE
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name']; // NOM TEMPORAIRE DU FICHIER IMAGE
        $infoImage = pathinfo($image); //TABLEAU QUI DECORTIQUE LE NOM DE FICHIER
        $extImage = $infoImage['extension']; //EXTENSION 
        $imageName = $infoImage['filename']; //NOM DU FICHIER SANS L'EXTENSION
        //GENERATION D'UN NOM DE FICHIER UNIQUE
        $uniqueName = $imageName . time() . rand(1, 1000) . "." . $extImage;

        move_uploaded_file($imageTmp, 'assets/image/sorts/' . $uniqueName);
    }

    $request = $bdd->prepare('INSERT INTO magie(label,description,image,ecole_id)
                              VALUES(?,?,?,?)');

    $request->execute(array($name, $description, $uniqueName, $ecole));
    header('Location: magie.php?success=1');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/image/livre-de-sortileges.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Création de créature</title>
</head>

<body>
    <?php include_once('nav.php'); ?>
    <main>
        <h1>Création d'un sort magique'</h1>

        <!--Formulaire de Création-->
        <form action="magie_creation.php" method="POST" enctype="multipart/form-data">
            <label for="name">Le nom du sort:</label>
            <input type="text" id="name" name="name">

            <label for="image">Ajouter une image:</label>
            <input type="file" id="image" name="image">

            <label for="description">La description du sort:</label>
            <textarea name="description" id="description" cols=" 30" rows="10"></textarea>

            <label for="ecole">Selectionner son école de magie:</label>
            <select name="ecole" id="ecole">
                <?php while ($ecole = $request->fetch()) : ?>
                    <option value="<?= $ecole['id'] ?>"><?= $ecole['type'] ?></option>
                <?php endwhile ?>
            </select>
            <button>Ajouter</button>
        </form>
    </main>
</body>

</html>