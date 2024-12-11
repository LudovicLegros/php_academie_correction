<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="bestiaire.php">Bestiaire</a></li>
        <li><a href="magie.php">Codex des sortilèges</a></li>
        <?php if (isset($_SESSION['role'])) : ?>
            <?php if ($_SESSION['role'] == 'ADMIN') : ?>
                <li><a href="admin/index.php">Gestion administrateur</a></li>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!isset($_SESSION['userName'])) { ?>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        <?php } else { ?>
            <li><a href="deconnexion.php">Deconnexion</a></li>
        <?php } ?>
    </ul>
</nav>