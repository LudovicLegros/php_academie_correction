<?php
include('environnement.php');

$id = htmlspecialchars($_GET['id']);
//REQUETE POUR VERIFICATION DU USER A QUI APPARTIENT L'ARTICLE
$requestSelect = $bdd->prepare('SELECT * FROM magie 
                                WHERE id=?');
$requestSelect->execute([$id]);
while ($data = $requestSelect->fetch()) {
    //VERIFICATION DU CHAMP USERS_ID AVEC L'ID GARDE EN VARIABLE DE SESSION
    if (isset($_SESSION['userId'])) {
        //ON EXECUTE LA REQUETE SI CA CORRESPOND
        $request = $bdd->prepare('DELETE FROM magie
                          WHERE id=?');

        $request->execute([$id]);
        header('Location: magie.php?success=3');
        exit();
    } else {
        //SINON ON RENVOIE SUR L'INDEX
        header('Location: index.php');
        exit();
    }
}
