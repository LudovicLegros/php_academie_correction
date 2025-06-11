<?php
include_once('environnement.php');
?>

<?php 
$title = "Academie";
include_once("include/head.php") 
?>

<body>
    <?php 
    
    include_once('include/nav.php'); 
    ?>
    <main id="home">
        <h1>Codex de l'academie de la magie</h1>
        <?php if (isset($_SESSION['userName'])) { ?>
            <h2>Bienvenue <?= $_SESSION['userName'] ?>
            <?php } else { ?>
                <h2>Bienvenue visiteur
                <?php } ?>
                sur le site de référencement des créatures magiques et des sortilèges existants</h2>
                <section>
                    <a href="/perigueux_php_academie/bestiaire/bestiaire.php">
                        <h3>Bestiaire</h3>
                        <article class="bestiaire_link"></article>
                    </a>
                    <a href="/perigueux_php_academie/magie/magie.php">
                        <h3>Codex des sortilèges</h3>
                        <article class="sortilege_link"></article>
                    </a>
                </section>

    </main>
</body>

</html>