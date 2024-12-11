<?php
include_once('../environnement.php');

$request = $bdd->query('SELECT *,magie.id AS magieId
                        FROM magie
                        INNER JOIN ecole ON ecole_id = ecole.id
                        ORDER BY ecole_id');



?>

<?php 
$title = "Sortilèges magiques";
include('../include/head.php')
?>


<body>
    <?php include_once('../include/nav.php'); ?>
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
                <img src="../assets/image/sorts/<?= $magie['image']; ?>" alt="image d'un sort de <?= $magie['label']; ?>">
                <div>
                    <h3><?= $magie['label']; ?></h3>
                    <p><?= $magie['description']; ?></p>
                    <p><strong>type: </strong><?= $magie['type']; ?></p>

                    <?php 
                        $innerRequest= $bdd->prepare('SELECT u.username AS specialiste,e.type,u.id AS uid 
                                                        FROM `users` AS u
                                                        INNER JOIN user_ecole AS ue ON ue.user_id = u.id 
                                                        INNER JOIN ecole AS e ON ue.ecole_id = e.id
                                                        WHERE ue.ecole_id = :ecoleid');

                        $innerRequest->execute([':ecoleid' => $magie['id']]);

                    ?>
                    <p><strong>spécialistes:
                        <?php 
                        $listOfSpecialiste=[];
                        while($specialiste = $innerRequest->fetch()){
                            echo $specialiste['specialiste'] . " ";   
                            array_push($listOfSpecialiste,$specialiste['uid']);       
                        }?>

                        
                    </p>
                </div>
                <?php if (isset($_SESSION['userId'])) : ?>
                    <?php if (in_array(($_SESSION['userId']),$listOfSpecialiste)) : ?>
                    <div class='btn_box'>
                        <a class="btn btn-modif" href="<?= 'magie_modification.php?id=' . $magie['magieId']; ?>">modifier</a>
                        <a class="btn btn-suppr" href="<?= 'magie_suppression.php?id=' . $magie['magieId']; ?>">supprimer</a>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </article>
        <?php endwhile ?>
    </main>
</body>

</html>