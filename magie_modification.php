<?php
include_once('environnement.php');

//REQUETE SELECT POUR REMPLISSAGE AUTO
$articleId = $_GET['id'];

$requestType = $bdd->query('SELECT *
                        FROM ecole');

$rqSelect = $bdd->prepare('SELECT *
                             FROM magie
                             WHERE id = ?');
$rqSelect->execute(array($articleId));
//FETCH ALL RECUPERE D'UN COUP TOUTE LES RANGEES DE LA BDD DANS UN TABLEAU A 2 DIMENSIONS
$values = $rqSelect->fetchAll();

//FOREACH PERMET DE BOUCLER SUR LE TABLEAU PRECEDEMMENT CREE
foreach ($values as $value) :
    if (!isset($_SESSION['userId'])) {
        header('Location: index.php');
    }
endforeach;

if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['ecole'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $ecole = htmlspecialchars($_POST['ecole']);

    //GESTION DE L'IMAGE
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


    $request = $bdd->prepare('UPDATE magie
                              SET label = :label, description = :description, image = :image, ecole_id = :ecole
                              WHERE id = :id');

    $request->execute(array(
        'label'             => $name,
        'description'       => $description,
        'ecole'             => $ecole,
        'image'             => $uniqueName,
        'id'                => $articleId
    ));
    header('Location: magie.php?success=2');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/image/livre-de-sortileges.png">
    <title>modification de créature</title>
</head>

<body>
    <?php include_once('nav.php'); ?>
    <main>
        <h1>Modification du sort <?= $values[0]['label'] ?></h1>

        <!--Formulaire de modification-->
        <form action="magie_modification.php<?= '?id=' . $articleId ?>" method="POST" enctype="multipart/form-data">

            <!--ON FAIT UN FOREACH PLUTOT QU'UN WHILE CAR LES DONNEES SONT RECUPEREES EN FETCHALL()-->
            <?php foreach ($values as $value) : ?>
                <form action="magie_creation.php" method="POST" enctype="multipart/form-data">
                    <label for="name">Le nom du sort:</label>
                    <input type="text" id="name" name="name" value='<?= $value['label'] ?>'>

                    <label for="image">Ajouter une image:</label>
                    <input type="file" id="image" name="image" value='<?= $value['image'] ?>'>

                    <label for="description">La description du sort:</label>
                    <textarea name="description" id="description" cols=" 30" rows="10"><?= $value['description'] ?></textarea>

                    <label for="ecole">Selectionner son école de magie:</label>
                    <select name="ecole" id="ecole">
                        <!--BOUCLE DE RECUPERATION DES TYPES-->
                        <?php while ($ecole = $requestType->fetch()) : ?>
                            <option value="<?= $ecole['id'] ?>"><?= $ecole['type'] ?></option>
                        <?php endwhile ?>
                    </select>
                    <button>Ajouter</button>
                </form>
    </main>
<?php endforeach; ?>
<button>Modifier</button>
</form>
</main>
</body>

</html>