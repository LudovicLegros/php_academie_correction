<?php
include_once('../environnement.php');

if ($_SESSION['role'] != 'ADMIN') {
    header('Location: ../index.php');
}

$request = $bdd->query('SELECT *
                        FROM users');



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/image/livre-de-sortileges.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Panel Admin</title>
</head>

<body>
    <?php include_once('nav.php'); ?>
    <main id='admin'>
        <?php 
        if (isset($_GET['success'])) {
                $success = $_GET['success'];
                switch ($success) {
                    case 1:
                        echo "<p class='success'>l'utilisateur à bien été modifé</p>";
                        break;
                    case 2:
                        echo "<p class='success'>Votre créature a bien été modifié </p>";
                        break;
                    case 3:
                        echo "<p class='success'>Votre créature a bien été supprimé</p>";
                        break;
                }
            }
        ?>
        <?php while ($user = $request->fetch()) : ?>
            <article>
                <p><?= $user['username'] ?></p>
                <p><?= $user['role'] ?></p>
                <p>
                    <?php 
                        $requestType = $bdd->prepare('SELECT e.type
                                                    FROM ecole AS e
                                                    LEFT JOIN user_ecole AS ue
                                                    ON ue.ecole_id = e.id
                                                    WHERE ue.user_id = :uid');

                        $requestType->execute(['uid'=>$user['id']]);

                        while($type = $requestType->fetch()){
                            echo '<span> ' . $type['type'] . '</span>';

                        }

                    ?>

                </p>
                <div>
                    <a href="usermodify.php?id=<?= $user['id'] ?>" class='btn'><i class="fa-solid fa-pen"></i></a>
                    <a href="userdelete.php?id=<?= $user['id'] ?>" class='btn'><i class="fa-solid fa-trash-can"></i></a>
                </div>
            </article>
        <?php endwhile ?>
    </main>
</body>

</html>