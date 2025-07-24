<?php

    // Connexion à la BDD
    $host = 'localhost';
    $dbname = 'voiture';
    $user = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <form method="POST">
            <input type="text" name="colorName">
            <input type="submit" name="submitColor" value="Envoyé couleur dans la BDD">
        </form>

    </body>
</html>

<?php 

    if(isset($_POST['submitColor'])){
        $color = $_POST['colorName'];
        $sql = "INSERT INTO `couleur`(`Nom_Couleur`) VALUES ('$color')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        echo "data envoyées en BDD";

    }

?>