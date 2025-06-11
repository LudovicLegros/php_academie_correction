<?php
include_once('../environnement.php');

//REQUEST POUR RECUPERE LES TYPE POUR LA BOUCLE DU CHAMP SELECT
$requestType = $bdd->query('SELECT *
                        FROM ecole
                        ');

//REQUETE SELECT POUR REMPLISSAGE AUTO
$userId = $_GET['id'];

$rqSelect = $bdd->prepare('SELECT u.username, GROUP_CONCAT(ue.ecole_id) AS element
                             FROM users AS u
                             LEFT JOIN user_ecole AS ue
                             ON u.id = ue.user_id
                             WHERE u.id = ?');
$rqSelect->execute(array($userId));

// FETCH RECUPERE D'UN COUP TOUTE LA RANGEE DE LA REQUETE
$value = $rqSelect->fetch();
if($value['element'] != NULL){
    $element = explode(",",$value['element']);
}else{
    $element = [];
}

    //ON VERIFIE SI LE USER EST L'ADMIN
    if ($_SESSION['role'] == 'ADMIN') {
        if (isset($_POST['role'])) {
            $role = htmlspecialchars($_POST['role']);

            $request = $bdd->prepare('UPDATE users
                                SET role = :role
                                WHERE id = :id');
            $request->execute(array(
                'role'           => $role,
                'id'            => $userId
            ));

            // POUR MODIFIER UNE TABLE MANY TO MANY IL FAUT SUPPRIMER LES VALEURS ASSOCIEE ET LES REINSERER

            //FAIRE REQUETE DELETE

            $requestDelete = $bdd->prepare('DELETE FROM user_ecole
                                      WHERE user_id = :id');
            $requestDelete->execute(array(
            'id'            => $userId
            ));

            //FAIRE REQUETE INSERT INTO
           
            if(isset($_POST['element'])){
                $requestReinsert = $bdd->prepare('INSERT INTO user_ecole(user_id,ecole_id)
                                                VALUES (:userid,:ecoleid)
                                                ');

                                        
                foreach($_POST['element'] as $checkboxElement){
                    $requestReinsert->execute(array(
                    'userid'            => $userId,
                    'ecoleid'           => $checkboxElement

                    ));
                }

                header('Location: /perigueux_php_academie/admin/index.php?success=1');
            }
        }
    } else {
        header('Location: index.php');
    }


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
        <h1>Définir le rôle de <?= $value['username'] ?></h1>

        <!--Formulaire de modification-->
        <form action="usermodify.php<?= '?id=' . $userId ?>" method="POST">

           
                <label for="nom">Modifier le nom:</label>
                <input type="text" value="<?= $value['username'] ?>">

                <label for="role">Modifier le rôle :</label>
                    <select name="role" id="role">
                        <option value="USER">role USER</option>
                        <option value="ADMIN">role ADMIN</option>
                    </select>
                    
                    <?php while($type=$requestType->fetch()):?>
                    <label class="ckinput" for="<?= $type['type']?>"><?= $type['type']?></label>
                    <input class="ckinput" id="<?= $type['type']?>" type="checkbox" name="element[]" value="<?= $type['id']?>" 
                    <?php
                    if(in_array( $type['id'],$element)) {
                        echo "checked";
                    }
                    
                    ?>
                    >
                    
                    <?php endwhile; ?>
                
            <button>Modifier</button>
        </form>
    </main>
</body>

</html>