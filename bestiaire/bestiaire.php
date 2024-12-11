<?php
include_once('../environnement.php');

$request = $bdd->query('SELECT *,users.username AS author,  creature.id AS creatureid, famille.nom_famille AS famille
                        FROM creature
                        LEFT JOIN users ON users_id = users.id
                        LEFT JOIN famille ON famille_id = famille.id');
?>

<?php 
    $title="Bestiaire";
    include_once('../include/head.php');

?>

<body>
    <?php include_once('../include/nav.php'); ?>
    <main id="creature">
        <h1>Référencement du bestiaire</h1>

        <?php if (isset($_SESSION['userName'])) : ?>
            <a class="btn btn-add" href="creature_creation.php">Ajouter une créature</a>
        <?php endif ?>
        <!-- Gestion des messages de success -->
        <?php
        if (isset($_GET['success'])) {
            $success = $_GET['success'];
            switch ($success) {
                case 1:
                    echo "<p class='success'>Votre créature a bien été ajouté </p>";
                    break;
                case 2:
                    echo "<p class='success'>Votre créature a bien été modifié </p>";
                    break;
                case 3:
                    echo "<p class='success'>Votre créature a bien été supprimé</p>";
                    break;
            }
        }
        ?>

        <h2>Liste des créatures :</h2>
        <section id="creature_list">
            <!-- BOUCLE POUR RECUPERATION DE LA REQUETE -->
            <?php while ($creature = $request->fetch()) : ?>
                <?php
                // var_dump($creature)
                ?>
                <article>
                    <p class="auteur">Par : <strong><?= $creature['author']; ?></strong></p>
                    <img src="../assets/image/creatures/<?= $creature['image']; ?>" alt="image de <?= $creature['nom']; ?>">
                    <h3> <?= $creature['nom']; ?> </h3>
                    <h3> famille :<?= $creature['famille']; ?> </h3>
                    <p> <?= $creature['description']; ?> </p>
                    <!-- ON VERIFIE SI LA VARIABLE DE SESSION EXISTE-->
                    <?php if (isset($_SESSION['userId'])) : ?>
                        <!-- ON VERIFIE SI L'ID DE L'USER CONNECTE EST LE MEME QUE L'ID_USER DE LA TABLE CREATURE-->
                        <?php if ($_SESSION['userId'] == $creature['users_id'] || $_SESSION['role'] == 'ADMIN') : ?>
                            <a class="btn btn-modif" href="<?= 'creature_modification.php?id=' . $creature['creatureid']; ?>">modifier</a>
                            <a class="btn btn-suppr" href="<?= 'creature_suppression.php?id=' . $creature['creatureid']; ?>">supprimer</a>
                        <?php endif ?>
                    <?php endif ?>
                </article>
            <?php endwhile ?>
        </section>
    </main>
</body>

</html>