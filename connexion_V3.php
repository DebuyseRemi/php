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
    </form>
        <a href="?page=createAccount"><p>Pas de compte ? Créez en un ici</p></a>';
    }
    else{
        echo '<form method="POST">
        <input type="submit" name="deconnexion" value="Se déconnecter">
    </form>';

        echo "Bonjour, " . $_SESSION['user']['nom_user'] . " " . $_SESSION['user']['prenom_user'] . " . Vous êtes connecté ";
        include 'test2.php';
    }

    ?>
    
<?php
    if(isset($_POST['submitConnection'])  && !empty($_POST['identifiant']) && !empty($_POST['password'])){
        $id = $_POST['identifiant'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `users` WHERE adresse_mail_user = '$id'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($results[0]["password_user"])) {
        if (password_verify( $password, $results[0]["password_user"])){//Pour vérifier  un mdp crypté
            $_SESSION['user']=[
                "id_user" => $results[0]["id_user"],
                "nom_user" => $results[0]["nom_user"],
                "prenom_user" => $results[0]["prenom_user"],
                "age_user" => $results[0]["age_user"],
                "adresse_mail_user" => $results[0]["adresse_mail_user"],
                ];
            }
            header("Location: connexion_V3.php");            
        }
            else{
                echo "Utilisateur non connecté - Mot de passe incorrect";
            }
        }

        if(isset($_POST['deconnexion'])){
            session_destroy();
            header("Location: connexion_V3.php");     
        }

        if (isset($_GET['page']) && $_GET['page'] == 'createAccount'){
            echo '<form method="POST">
        <label>Nom</label>
        <input type="text" name="nomCreate">
        <br>
        <label>Prenom</label>
        <input type="text" name="prenomCreate">
        <br>
        <label>Age</label>
        <input type="text" name="ageCreate">
        <br>
        <label>Mail</label>
        <input type="email" name="mailCreate">
        <br>
        <label>Mote de passe</label>
        <input type="password" name="passwordCreate">
        <br>
        <input type="submit" name="submitCreate" value="Créer mon compte">
    </form>';
        }

        if(isset($_POST['submitCreate'])){
            $nomCreate = $_POST['nomCreate'];
            $prenomCreate = $_POST['prenomCreate'];
            $ageCreate = $_POST['ageCreate'];
            $mailCreate = $_POST['mailCreate'];
            $passwordCreate = $_POST['passwordCreate'];

            $hashedPassword = password_hash($passwordCreate, PASSWORD_DEFAULT);//Bien utiliser cette valeur pour envoyer le mdp crypté en BDD
            echo $nomCreate . ' - - ' . $prenomCreate . ' - - ' . $ageCreate . ' - - ' . $mailCreate . ' - - ' . $passwordCreate;

            $sqlCreate = "INSERT INTO `users`(`nom_user`, `prenom_user`, `age_user`, `adresse_mail_user`, `password_user`) VALUES
            (:nom,:prenom,:age,:mail,:motDePass)";// Changement de méthode pour pouvoir prendre en compte les apostrophes dans les saisies

            $stmtCreate = $pdo->prepare($sqlCreate);

            $stmtCreate->bindParam(':nom', $nomCreate);
            $stmtCreate->bindParam(':prenom', $prenomCreate);
            $stmtCreate->bindParam(':age', $ageCreate);
            $stmtCreate->bindParam(':mail', $mailCreate);
            $stmtCreate->bindParam(':motDePass', $hashedPassword);//Rajout de cette partie entre le "prepare" et "execute"

            $stmtCreate->execute();

            echo "data ajoutée en BDD";
        }
    ?>

</body>
</html>


