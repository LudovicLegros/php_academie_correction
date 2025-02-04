<?php
include_once('../environnement.php');

if (isset($_POST['name']) && (isset($_POST['password'])) && (isset($_POST['passwordConfirm']))) {
    $username = htmlspecialchars(trim(strtolower($_POST['name'])));
    $password = htmlspecialchars(trim($_POST['password']));
    $role = 'USER';

    $passwordConfirm = htmlspecialchars(trim($_POST['passwordConfirm']));

    //Verification des champs de mot de passe et confirmation de mdp
    if ($password == $passwordConfirm) {
        // VERIFICATION SI UTILISATEUR DEJA EXISTANT EN BDD

        $rqCount = $bdd->prepare('  SELECT COUNT(*) AS usercount
                                    FROM users
                                    WHERE username = ?');

        $rqCount->execute([$username]);

        while ($count = $rqCount->fetch()) {
            $countVerify = $count['usercount'];

            if ($countVerify < 1) {
                //ENCRYPTAGE DU MOT DE PASSE
                $passwordCrypt = sha1(sha1('123' . $password . 'kpkoazf1516'));

                $request = $bdd->prepare('  INSERT INTO users(username,password,role)
                                            VALUES(?,?,?)');

                $request->execute(array($username, $passwordCrypt, $role));
                header('Location:connexion.php?successsubscribe=1');
            } else {
                header('Location:inscription.php?userexist=1');
            }
        }
    } else {
        header('Location:inscription.php?passworderror=1');
    }
}
?>
<?php
$title = 'Inscription';
include_once('../include/head.php');
?>

<!DOCTYPE html>
<html lang="en">


<body>
    <?php include_once('../include/nav.php'); ?>
    <main>
        <!--ERROR MESSAGES-->
        <?php
        if (isset($_GET['userexist'])) {
            echo '<p class="error">Le nom d\'utilisateur existe déjà! </p>';
        }
        if (isset($_GET['passworderror'])) {
            echo '<p class="error">Les mots de passes ne correspondent pas! </p>';
        }
        ?>
        <form action="inscription.php" method="POST">
            <label for="name">Votre nom:</label>
            <input type="text" name="name" id="name">
            <label for="password">Votre mot de passe:</label>
            <input type="password" name="password" id="password">
            <label for="passwordConfirm">Confirmez votre mot de passe:</label>
            <input type="password" name="passwordConfirm" id="passwordConfirm">
            <button>Valider</button>
        </form>
    </main>
</body>

</html>