<?php

    // Connexion à la BDD
    $host = 'localhost';
    $dbname = 'voiture';
    $user = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Requête SQL
    $sqlAll = "SELECT * FROM `vehicule`";

    //Préparation + execution de la requête

    $stmtAll = $pdo->prepare($sqlAll);
    $stmtAll->execute();

    $resultsAll = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
    var_dump($resultsAll);

    $sqlCouleur = "SELECT * FROM `couleur`";
    $stmtCouleur = $pdo->prepare($sqlCouleur);
    $stmtCouleur->execute();

    $resultsCouleur = $stmtCouleur->fetchAll(PDO::FETCH_ASSOC);

    $sqlType = "SELECT * FROM `type_vehicule`";
    $stmtType = $pdo->prepare($sqlType);
    $stmtType->execute();

    $resultsType = $stmtType->fetchAll(PDO::FETCH_ASSOC);

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
            <label>Ajoutez un type de véhicule dans la BDD</label>
            <input type="text" name="typeName">
            <input type="submit" name="submitType" value="Envoyé le type de véhicule dans la BDD">
            <br>
            <label>Ajoutez une couleur dans la BDD</label>
            <input type="text" name="colorName">
            <input type="submit" name="submitColor" value="Envoyé couleur dans la BDD">
        </form>

        <form method="POST">
            <label>Ajouter un Véhicule</label>
            <input type="text" name="immatriculation">
            <select name="selectAddCouleur">
               <?php
                    foreach ($resultsCouleur as $key => $value) {
                        echo "<option value='" . $value['ID_Couleur'] . "'>" . $value['Nom_Couleur'] . "</option>";
                    }
                ?>
            </select>
            <select name="selectAddType">
               <?php
                    foreach ($resultsType as $key => $value) {
                        echo "<option value='" . $value['ID_Type'] . "'>" . $value['Nom_Type'] . "</option>";
                    }
                ?>
            </select>
            <input type="submit" name="submitVehicule">
            <a href="?id="><p>Modifier</p></a>
        </form>

        <hr>
        <form method="POST">    
            <?php


                foreach ($resultsAll as $value) {
                    echo $value['ID_Vehicule'];
                    echo "<br>";
                }

                foreach ($resultsAll as $key => $value) {
                    $idASupprimer = $value['ID_Vehicule'];
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='idDelete' value='$idASupprimer'>";

                    foreach ($value as $key => $value2) {
                        echo $key . " : " . $value2 . " - ";
                    }
                    echo '<a href="?id=' . $idASupprimer . '"><p>Modifier</p></a>';
                    echo '<input type="submit" name="submitDelete" value="Supprimer"><br>';
                    echo "</form>";
                }

                if (isset($_POST['submitDelete'])){
                    $idToDelete = $_POST['idDelete'];
                    $sqlDelete = "DELETE FROM `vehicule` WHERE ID_Vehicule = '$idToDelete'";
                    $stmtDelete = $pdo->prepare($sqlDelete);
                    $stmtDelete->execute();
                }
            ?>
        </form>

    </body>
</html>

<?php 

    if(isset($_POST['submitVehicule'])){
        $color = $_POST['selectAddCouleur'];
        $immatriculation = $_POST['immatriculation'];
        $type = $_POST['selectAddType'];
        echo $immatriculation;
        echo $color;
        echo $type;

        $sql = "INSERT INTO `vehicule`(`immatriculation`,`Vehicule_Type_FK`,`Vehicule_Couleur_FK`) VALUES ('$immatriculation','$type','$color')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        echo "Véhicule envoyée en BDD";
        }


    if(isset($_POST['submitType'])){
        $type = $_POST['typeName'];
        $sql = "INSERT INTO `type_vehicule`(`Nom_Type`) VALUES ('$type')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        echo "data envoyées en BDD";

    }


    if(isset($_POST['submitColor'])){
        $color = $_POST['colorName'];
        $sql = "INSERT INTO `couleur`(`Nom_Couleur`) VALUES ('$color')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        echo "data envoyées en BDD";

    }

?>

<hr>

<?php

    if(isset($_GET["id"])){        
        $id = $_GET['id'];
        $sqlId = "SELECT * FROM `vehicule` WHERE ID_Vehicule = '$id'";

        //Préparation + Execution de la requête
        $stmtId = $pdo->prepare($sqlId);
        $stmtId->execute();
        
        $resultsId = $stmtId->fetchAll(PDO::FETCH_ASSOC);

        echo '<form method="POST">
        <label for="">ID</label>
        <input type="text" name="idUpdate" value="' . $resultsId[0]['ID_Vehicule'] . '">
        <br>
        <label for="">immatriculation</label>
        <input type="text" name="immatriculationUpdate" value="' . $resultsId[0]['immatriculation'] . '">
        <br>
        <label for="">Type</label>
        <input type="text" name="typeUpdate" value="' . $resultsId[0]['Vehicule_Couleur_FK'] . '">
        <br>
        <label for="">Couleur</label>
        <input type="text" name="couleurUpdate" value="' . $resultsId[0]['Vehicule_Type_FK'] . '">
        <br>
        <input type="submit" name="submitUpdate" value="Mettre à jour la BDD">
    </form>';

        var_dump($resultsId);
    }

    if(isset($_POST['submitUpdate'])){

        $idUpdate = $_POST['idUpdate'];
        $immatriculation = $_POST['immatriculationUpdate'];
        $type = $_POST['typeUpdate'];
        $couleur = $_POST['couleurUpdate'];

        $sqlUpdate = "UPDATE `vehicule` SET `immatriculation`='$immatriculation', `Vehicule_Type_FK`='$type',`Vehicule_Couleur_FK`='$couleur' WHERE 
        ID_Vehicule='$idUpdate'";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute();
    }