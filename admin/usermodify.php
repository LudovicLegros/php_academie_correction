<?php
include_once('../environnement.php');

//REQUETE SELECT POUR REMPLISSAGE AUTO
$articleId = $_GET['id'];

$rqSelect = $bdd->prepare('SELECT *
                             FROM users
                             WHERE id = ?');
$rqSelect->execute(array($articleId));
//FETCH ALL RECUPERE D'UN COUP TOUTE LES RANGEES DE LA BDD DANS UN TABLEAU A 2 DIMENSIONS
$values = $rqSelect->fetchAll();

//FOREACH PERMET DE BOUCLER SUR LE TABLEAU PRECEDEMMENT CREE
foreach ($values as $value) :
    //ON VERIFIE SI LE USER EST LE CREATION OU SI C'EST L'ADMIN
    if ($_SESSION['role'] == 'ADMIN') {
        if (isset($_POST['role'])) {
            $role = htmlspecialchars($_POST['role']);

            $request = $bdd->prepare('UPDATE users
                                SET role = :role
                                WHERE id = :id');

            $request->execute(array(
                'role'           => $role,
                'id'            => $articleId
            ));
            header('Location: index.php?success=2');
        }
    } else {
        header('Location: index.php');
    }
endforeach;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/image/livre-de-sortileges.png">
    <title>modification de créature</title>
</head>

<body>
    <?php
    include_once('nav.php');
    ?>
    <main>
        <h1>Définir le rôle de <?= $values[0]['username'] ?></h1>

        <!--Formulaire de modification-->
        <form action="usermodify.php<?= '?id=' . $articleId ?>" method="POST">

            <!--ON FAIT UN FOREACH PLUTOT QU'UN WHILE CAR LES DONNEES SONT RECUPEREES EN FETCHALL()-->
            <?php foreach ($values as $value) : ?>
                <label for="role">Modifier le rôle :</label>
                <select name="role" id="role">
                    <option value="USER">role USER</option>
                    <option value="ADMIN">role ADMIN</option>
                </select>
            <?php endforeach; ?>
            <button>Modifier</button>
        </form>
    </main>
</body>

</html>