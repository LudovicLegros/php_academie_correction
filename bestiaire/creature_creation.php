<?php
include_once('../environnement.php');

if (!isset($_SESSION['userName'])) {
    header('Location:index.php');
}

if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['famille'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $famille = htmlspecialchars($_POST['famille']);



    if (isset($_FILES['image'])) {
        // NOM DU FICHIER IMAGE
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name']; // NOM TEMPORAIRE DU FICHIER IMAGE
        $infoImage = pathinfo($image); //TABLEAU QUI DECORTIQUE LE NOM DE FICHIER
        $extImage = $infoImage['extension']; //EXTENSION 
        $imageName = $infoImage['filename']; //NOM DU FICHIER SANS L'EXTENSION
        //GENERATION D'UN NOM DE FICHIER UNIQUE
        $uniqueName = $imageName . time() . rand(1, 1000) . "." . $extImage;

        move_uploaded_file($imageTmp, '../assets/image/creatures/' . $uniqueName);
    }

    $request = $bdd->prepare('INSERT INTO creature(nom,description,image,famille_id,users_id)
                              VALUES(?,?,?,?,?)');

    $request->execute(array($name, $description, $uniqueName,$famille, $_SESSION['userId']));

    // $last_insert_id = $bdd->lastInsertId();



    
    // foreach ($caracsChckBox as $caracs) {
    //     $requestCaracs->execute(array($last_insert_id, $caracs));
    // }
    // header('Location: bestiaire.php?success=1');
    // foreach($caracs as $caracsChckBox)
}

    $requestOptions = $bdd->prepare('SELECT id, nom_famille 
                                     FROM famille');

    $requestOptions->execute([]);
            
?>

<?php 
$title = "Création de créature";
include_once("../include/head.php");
?>

<body>
    <?php include_once('../include/nav.php'); ?>
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
            <label>La Famille:</label>
            <select name="famille" id="famille">
                
                <?php while($data = $requestOptions->fetch()): ?>
                    <option value="<?php echo $data['id']; ?>"><?php echo $data['nom_famille']; ?></option>
                <?php endwhile; ?>
            </select>
            <button>Ajouter</button>
        </form>
    </main>
</body>

</html>