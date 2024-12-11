<nav>
    <ul>
        <li><a href="/perigueux_php_academie/index.php">Accueil</a></li>
        <li><a href="/perigueux_php_academie/bestiaire/bestiaire.php">Bestiaire</a></li>
        <li><a href="/perigueux_php_academie/magie/magie.php">Codex des sortilèges</a></li>
        <?php if (isset($_SESSION['role'])) : ?>
            <?php if ($_SESSION['role'] == 'ADMIN') : ?>
                <li><a href="/perigueux_php_academie/admin/index.php">Gestion administrateur</a></li>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!isset($_SESSION['userName'])) { ?>
            <li><a href="/perigueux_php_academie/auth/inscription.php">Inscription</a></li>
            <li><a href="/perigueux_php_academie/auth/connexion.php">Connexion</a></li>
        <?php } else { ?>
            <li><a href="/perigueux_php_academie/auth/deconnexion.php">Deconnexion</a></li>
        <?php } ?>
    </ul>
</nav>