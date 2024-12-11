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
        <?php while ($user = $request->fetch()) : ?>
            <article>
                <p><?= $user['username'] ?></p>
                <p><?= $user['role'] ?></p>
                <div>
                    <a href="usermodify.php?id=<?= $user['id'] ?>" class='btn'><i class="fa-solid fa-pen"></i></a>
                    <a href="userdelete.php?id=<?= $user['id'] ?>" class='btn'><i class="fa-solid fa-trash-can"></i></a>
                </div>
            </article>
        <?php endwhile ?>
    </main>
</body>

</html>