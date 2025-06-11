<nav>
    <ul>
        <li><a href="<?= BASE_URL ?>/index.php">Accueil</a></li>
        <li><a href="<?= BASE_URL ?>/bestiaire/bestiaire.php">Bestiaire</a></li>
        <li><a href="<?= BASE_URL ?>/magie/magie.php">Codex des sortilèges</a></li>
        <?php if (isset($_SESSION['role'])) : ?>
            <?php if ($_SESSION['role'] == 'ADMIN') : ?>
                <li><a href="<?= BASE_URL ?>/admin/index.php">Gestion administrateur</a></li>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!isset($_SESSION['userName'])) { ?>
            <li><a href="<?= BASE_URL ?>/auth/inscription.php">Inscription</a></li>
            <li><a href="<?= BASE_URL ?>/auth/connexion.php">Connexion</a></li>
        <?php } else { ?>
            <li><a href="<?= BASE_URL ?>/auth/deconnexion.php">Deconnexion</a></li>
        <?php } ?>
    </ul>
</nav>