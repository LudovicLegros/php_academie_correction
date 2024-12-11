<?php
include_once('environnement.php');
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
    <title>Academie</title>
</head>

<body>
    <?php include_once('nav.php'); ?>
    <main id="home">
        <h1>Codex de l'academie de la magie</h1>
        <?php if (isset($_SESSION['userName'])) { ?>
            <h2>Bienvenue <?= $_SESSION['userName'] ?>
            <?php } else { ?>
                <h2>Bienvenue visiteur
                <?php } ?>
                sur le site de référencement des créatures magiques et des sortilèges existants</h2>
                <section>
                    <a href="bestiaire.php">
                        <h3>Bestiaire</h3>
                        <article class="bestiaire_link"></article>
                    </a>
                    <a href="magie.php">
                        <h3>Codex des sortilèges</h3>
                        <article class="sortilege_link"></article>
                    </a>
                </section>

    </main>
</body>

</html>