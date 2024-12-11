<?php
include('../environnement.php');

$id = htmlspecialchars($_GET['id']);

//VERIFICATION DU CHAMP USERS_ID AVEC L'ID GARDE EN VARIABLE DE SESSION
if (isset($_SESSION['role'])) {
    if (($_SESSION['role']) == 'ADMIN') {
        //ON EXECUTE LA REQUETE SI CA CORRESPOND
        $request = $bdd->prepare('DELETE FROM users
                                WHERE id=?');

        $request->execute([$id]);
        header('Location: index.php?success=3');
        exit();
    } else {
        //SINON ON RENVOIE SUR L'INDEX
        header('Location: ../index.php');
        exit();
    }
} else {
    header('Location: ../index.php');
    exit();
}
