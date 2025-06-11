<?php
include_once('../environnement.php');

//REQUETE POUR LES FAMILLES DU MENU DEROULANT DE FILTRE
$requestFamille = $bdd->query('SELECT *
                        FROM famille');



// REQUETE DE BASE POUR L'AFFICHAGE
//CONDITION POUR VERIFIER SI LE GET DU FILTRE EXISTE

$where = '';
if (!empty($_GET['famille'])) {
    $famille = htmlspecialchars($_GET['famille']);
    $where = 'WHERE (:famille IS NULL OR famille.id = :famille)';
}


$ordre = (isset($_GET['ordre']) && $_GET['ordre'] == 2) ? ' ASC' : ' DESC';

//ON STOCKE LA REQUETE SQL DANS UNE VARIABLE ET ON VA POUVOIR LA DECONSTRUIRE ET LA MANIPULER POUR LES FILTRE
$sql = 'SELECT *,users.username AS author,  creature.id AS creatureid, famille.nom_famille AS famille
                        FROM creature
                        LEFT JOIN users ON users_id = users.id
                        LEFT JOIN famille ON famille_id = famille.id
                        ' . $where . 'ORDER BY nom' . $ordre;

$request = $bdd->prepare($sql);
//ON EXCECUTE EN FONCTION DE L'EXISTANCE DU FILTRE OU PAS

$params = [];
if (!empty($_GET['famille'])) {
    $params['famille'] = $_GET['famille'];
}
$request->execute($params);

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
                    echo "<p class='success'>Votre créature à bien été ajouté </p>";
                    break;
                case 2:
                    echo "<p class='success'>Votre créature à bien été modifié </p>";
                    break;
                case 3:
                    echo "<p class='success'>Votre créature à bien été supprimé</p>";
                    break;
            }
        }
        ?>

        <h2>Liste des créatures :</h2>
        <!-- SECTION FILTRES -->
        <form action="bestiaire.php" method="get">
            <label for="famille">selectionner par famille :</label>
            <select name="famille" id="famille">
                <option value=""></option>
                <?php while($famille = $requestFamille->fetch()): ?>
                    <option value="<?= $famille['id'] ?>"><?= $famille['nom_famille'] ?></option>
                <?php endwhile ?>
            </select>
            <label for="ordre">ordre</label>
            <select name="ordre" id="ordre">
                <option value="2">v</option>
                <option value="1">^</option>
            </select>
            <button>filtrer</button>
        </form>

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