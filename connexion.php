<?php
include_once('environnement.php');

// ON VERIFIE SI LES CHAMPS SONT REMPLIS ET PAS VIDE
if (isset($_POST['name']) && (isset($_POST['password']))) {
    if (!empty($_POST['name']) && (!empty($_POST['password']))) {
        $username = htmlspecialchars(trim(strtolower($_POST['name'])));
        $password = htmlspecialchars(trim($_POST['password']));
        $passwordCrypt = sha1(sha1('123' . $password . 'kpkoazf1516'));

        //VERIFICATION SI LE MOT DE PASSE EST CORRECT
        $request = $bdd->prepare('SELECT * 
                                FROM users
                                WHERE username = ?');

        $request->execute(array($username));

        while ($userData = $request->fetch()) {
            if ($passwordCrypt == $userData['password']) {
                $_SESSION['userName'] = $userData['username'];
                $_SESSION['userId'] = $userData['id'];
                $_SESSION['role'] = $userData['role'];
                header('Location:index.php?successconnect=1');
            } else {
                header('Location:connexion.php?errorconnect=1');
                //ERREUR MOT DE PASSE FAUX
            }
        }
    } else {
        header('Location:connexion.php?errorconnect=2');
        //ERREUR CHAMP VIDE
    }
}
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
    <title>Connexion</title>
</head>

<body>
    <?php include_once('nav.php'); ?>

    <!--MESSAGES-->
    <?php
    if (isset($_GET['successsubscribe'])) {
        echo '<p class="success">Vous pouvez maintenant vous connecter </p>';
    }
    ?>
    <main>
        <form action="connexion.php" method="POST">
            <label for="name">Votre nom:</label>
            <input type="text" name="name" id="name">
            <label for="password">Votre mot de passe:</label>
            <input type="password" name="password" id="password">
            <button>Valider</button>
        </form>
    </main>
</body>

</html>