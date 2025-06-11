<?php
include_once('../environnement.php');

//REQUETE SELECT POUR REMPLISSAGE AUTO
$articleId = htmlspecialchars($_GET['id']);
if ($_SESSION['role'] != 'ADMIN'){
    $checkUser = 'WHERE user_id = ?';
    $array = [$_SESSION['userId']];
}else{
    $checkUser = '';
    $array = [];
}

$requestType = $bdd->prepare('SELECT *
                        FROM ecole as e
                        LEFT JOIN user_ecole as ue
                        ON ue.ecole_id = e.id ' . $checkUser . 
                        'GROUP BY e.type');

$requestType->execute($array);

$associedElements = $requestType->fetchAll();
$numberOfCurrent = 0;




// var_dump($associedElements);


$rqSelect = $bdd->prepare('SELECT *
                             FROM magie
                             WHERE id = ?');
$rqSelect->execute(array($articleId));
//FETCH ALL RECUPERE D'UN COUP TOUTE LES RANGEES DE LA BDD DANS UN TABLEAU A 2 DIMENSIONS
$values = $rqSelect->fetchAll();

    //ON VERIFIE LE NOMBRE DE CORRESPONDANCE QUE L'UTILISATEUR ACTUEL POSSEDE
    foreach($associedElements as $associedElement){
        if($associedElement['ecole_id'] == $values[0]['ecole_id']){
            $numberOfCurrent += 1;
        }
    }

    //SI L'UTILISATEUR N'A AUCUN ELEMENT ASSOCIE A CETTE PAGE IL EST REDIRIGE
    if($_SESSION['role']!='ADMIN' ){
            if (!isset($_SESSION['userId']) || $numberOfCurrent == 0 ) {
            header('Location: /perigueux_php_academie/magie/magie.php');
        }
    }
   

//FOREACH PERMET DE BOUCLER SUR LE TABLEAU PRECEDEMMENT CREE
// var_dump($values);
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
        unlink('../assets/image/sorts/' . $value['image']);
        move_uploaded_file($imageTmp, '../assets/image/sorts/' . $uniqueName);
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

<?php 
$title = "modification de créature";
include_once('../include/head.php')
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
    <?php include_once('../include/nav.php'); ?>
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
                  
                        
                      
                            <?php foreach ($associedElements as $ecole) : ?>
                                <option value="<?= $ecole['id'] ?>"   
                                <?php
                                if($ecole['ecole_id'] == $value['ecole_id']){
                                    echo " selected";
                                }
                                ?>><?= $ecole['type']; ?>
                            
                                </option>
                            <?php endforeach ?>
                   
               
    
                    </select>
               
    </main>
<?php endforeach; ?>
<button>Modifier</button>
</form>
</main>
</body>

</html>