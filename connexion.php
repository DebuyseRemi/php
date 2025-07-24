<?php

    session_start();
    // Connexion à la BDD
    $host = 'localhost';
    $dbname = 'utilisateur';
    $user = 'root';
    $password = '';   
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!--sesion_start() est nécessaire pour faire une session et garder actif pour se connecter
-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 

    if(!isset($_SESSION['user'])){
        echo '<form method="POST">
        <label>Identifiant</label>
        <input type="text" name="identifiant">
        <label>Password</label>
        <input type="password" name="password">
        <input type="submit" name="submitConnection" value="Se connecter">
    </form>';
    }
    else{
        echo '<form method="POST">
        <input type="submit" name="deconnexion" value="Se déconnecter">
    </form>';

        echo "Bonjour, " . $_SESSION['user']['nom_user'] . " " . $_SESSION['user']['prenom_user'] . " . Vous êtes connecté ";
    }

    ?>
    
<?php
    if(isset($_POST['submitConnection'])){
        $id = $_POST['identifiant'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `users` WHERE adresse_mail_user = '$id'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($results[0]["password_user"])) {
        if ($password == $results[0]["password_user"]){
            $_SESSION['user']=[
                "id_user" => htmlspecialchars( $results[0]["id_user"]),
                "nom_user" => htmlspecialchars( $results[0]["nom_user"]),
                "prenom_user" => htmlspecialchars( $results[0]["prenom_user"]),
                "age_user" => htmlspecialchars( $results[0]["age_user"]),
                "adresse_mail_user" => htmlspecialchars( $results[0]["adresse_mail_user"]),
                ];
                header("Location: connexion.php");
            }
        }
            else{
                echo "Utilisateur non connecté - Mot de passe incorrect";
            }
        }

        if(isset($_POST['deconnexion'])){
            session_destroy();
            header("Location: connexion.php");
        }
?>

</body>
</html>


