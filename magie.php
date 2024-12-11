<?php
include_once('environnement.php');

$request = $bdd->query('SELECT *,magie.id AS magieId
                        FROM magie
                        INNER JOIN ecole ON ecole_id = ecole.id
                        ORDER BY ecole_id');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/image/livre-de-sortileges.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Sortilèges magiques</title>
</head>

<body>
    <?php include_once('nav.php'); ?>
    <main id="magie">
        <h1>Codex des sortilèges magiques</h1>
        <!--ON AFFICHE LE BOUTON DE CREATION QUE POUR LES UTILISATEUR CONNECTE-->
        <?php if (isset($_SESSION['userName'])) : ?>
            <a class="btn btn-add" href="magie_creation.php">Ajouter un sort magique</a>
        <?php endif ?>

        <!--DEBUT DE LA BOUCLE D'AFFICHAGE-->
        <?php while ($magie = $request->fetch()) : ?>
            <!--STYLE EN FONCTION DU TYPE DE SORT + CONDITION POUR PAS METTRE D'ACCENT DANS LE CSS-->
            <article class='
            <?php if ($magie['type'] == 'lumière') {
                echo 'lumiere';
            } else {
                echo $magie['type'];
            } ?>
            
            '>
                <img src="assets/image/sorts/<?= $magie['image']; ?>" alt="image d'un sort de <?= $magie['label']; ?>">
                <div>
                    <h3><?= $magie['label']; ?></h3>
                    <p><?= $magie['description']; ?></p>
                    <p><strong>type: </strong><?= $magie['type']; ?></p>
                </div>
                <?php if (isset($_SESSION['userId'])) : ?>
                    <div class='btn_box'>
                        <a class="btn btn-modif" href="<?= 'magie_modification.php?id=' . $magie['magieId']; ?>">modifier</a>
                        <a class="btn btn-suppr" href="<?= 'magie_suppression.php?id=' . $magie['magieId']; ?>">supprimer</a>
                    </div>
                <?php endif; ?>
            </article>
        <?php endwhile ?>
    </main>
</body>

</html>