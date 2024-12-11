<?php
include_once('../environnement.php');

//REQUETE SELECT POUR REMPLISSAGE AUTO
$articleId = $_GET['id'];

$rqSelect = $bdd->prepare('SELECT *
                             FROM creature
                             WHERE id = ?');
$rqSelect->execute(array($articleId));
//FETCH ALL RECUPERE D'UN COUP TOUTE LES RANGEES DE LA BDD DANS UN TABLEAU A 2 DIMENSIONS
$values = $rqSelect->fetchAll();

//FOREACH PERMET DE BOUCLER SUR LE TABLEAU PRECEDEMMENT CREE
foreach ($values as $value) :
    //ON VERIFIE SI LE USER EST LE CREATION OU SI C'EST L'ADMIN
    if ($value['users_id'] == $_SESSION['userId'] || $_SESSION['role'] == 'ADMIN') {
        if (isset($_POST['name']) && isset($_POST['description'])) {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description']);

            $request = $bdd->prepare('UPDATE creature
                                SET nom = :nom, description = :description
                                WHERE id = :id');

            $request->execute(array(
                'nom'           => $name,
                'description'   => $description,
                'id'            => $articleId
            ));
            header('Location: bestiaire.php?success=2');
        }
    } else {
        header('Location: index.php');
    }
endforeach;

?>
<?php 
$title="modification de créature";
include_once('../include/head.php');
?>



<body>
    <?php
    include_once('../include/nav.php');
    ?>
    <main>
        <h1>Modification de la créature</h1>

        <!--Formulaire de modification-->
        <form action="creature_modification.php<?= '?id=' . $articleId ?>" method="POST">

            <!--ON FAIT UN FOREACH PLUTOT QU'UN WHILE CAR LES DONNEES SONT RECUPEREES EN FETCHALL()-->
            <?php foreach ($values as $value) : ?>
                <label for="name">Modifier le nom :</label>
                <input type="text" id="name" name="name" value="<?= $value['nom'] ?>">

                <label for="description">Modifier la description :</label>
                <textarea name="description" id="description" cols=" 30" rows="10"><?= $value['description'] ?></textarea>
            <?php endforeach; ?>
            <button>Modifier</button>
        </form>
    </main>
</body>

</html>