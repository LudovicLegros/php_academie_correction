<?php
include_once('environnement.php');

if (!isset($_SESSION['userName'])) {
    header('Location:index.php');
}

if (isset($_POST['name']) && isset($_POST['description'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $caracsChckBox = $_POST['caracs']; //ARRAY DES CHOIX DE CHECKBOX
    var_dump($caracsChckBox);


    if (isset($_FILES['image'])) {
        // NOM DU FICHIER IMAGE
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name']; // NOM TEMPORAIRE DU FICHIER IMAGE
        $infoImage = pathinfo($image); //TABLEAU QUI DECORTIQUE LE NOM DE FICHIER
        $extImage = $infoImage['extension']; //EXTENSION 
        $imageName = $infoImage['filename']; //NOM DU FICHIER SANS L'EXTENSION
        //GENERATION D'UN NOM DE FICHIER UNIQUE
        $uniqueName = $imageName . time() . rand(1, 1000) . "." . $extImage;

        move_uploaded_file($imageTmp, 'assets/image/creatures/' . $uniqueName);
    }

    $request = $bdd->prepare('INSERT INTO creature(nom,description,image,users_id)
                              VALUES(?,?,?,?)');

    $request->execute(array($name, $description, $uniqueName, $_SESSION['userId']));

    $last_insert_id = $bdd->lastInsertId();

    $requestCaracs = $bdd->prepare('INSERT INTO creature_caracteristique(creature_id,caracteristique_id)
    VALUES(?,?)');

    foreach ($caracsChckBox as $caracs) {
        $requestCaracs->execute(array($last_insert_id, $caracs));
    }
    // header('Location: bestiaire.php?success=1');
    // foreach($caracs as $caracsChckBox)
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
        <h1>Création de la créature</h1>

        <!--Formulaire de Création-->
        <form action="creature_creation.php" method="POST" enctype="multipart/form-data">
            <label for="name">Le nom de la créature:</label>
            <input type="text" id="name" name="name">

            <label for="image">Ajouter une image:</label>
            <input type="file" id="image" name="image">

            <label for="description">La description de la créature:</label>
            <textarea name="description" id="description" cols=" 30" rows="10"></textarea>

            <!-- AJOUT CHECKBOX -->
            <label>La caractéristique:</label>
            <label for="vol">Vol</label>
            <input type='checkbox' name='caracs[]' value='1' id='vol'>
            <label for="court">Court</label>
            <input type='checkbox' name='caracs[]' value='2' id='court'>
            <label for="nage">Nage</label>
            <input type='checkbox' name='caracs[]' value='3' id='nage'>
            <button>Ajouter</button>
        </form>
    </main>
</body>

</html>