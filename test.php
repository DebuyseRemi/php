<?php

    echo("1");

        $sqlId = "SELECT * FROM `users`";

        //Préparation + Execution de la requête
        $stmtId = $pdo->prepare($sqlId);
        $stmtId->execute();
        echo("2");
        $resultsId = $stmtId->fetchAll(PDO::FETCH_ASSOC);

        echo '<form method="POST">
        <label for="">ID</label>
        <input type="text" name="idUpdate" value="' . $resultsId[0]['id_user'] . '">
        <br>
        <label for="">Nom</label>
        <input type="text" name="nomUpdate" value="' . $resultsId[0]['nom_user'] . '">
        <br>
        <label for="">Prenom</label>
        <input type="text" name="prenomUpdate" value="' . $resultsId[0]['prenom_user'] . '">
        <br>
        <label for="">Age</label>
        <input type="text" name="ageUpdate" value="' . $resultsId[0]['age_user'] . '">
        <br>
        <br>
        <label for="">e-mail</label>
        <input type="text" name="adresseMailUpdate" value="' . $resultsId[0]['adresse_mail_user'] . '">
        <br>
        <br>
        <label for="">mot de passe</label>
        <input type="text" name="passwordUpdate" value="' . $resultsId[0]['password_user'] . '">
        <br>
        <input type="submit" name="submitUpdate" value="Mettre à jour la BDD">
    </form>';
echo("3");

    if(isset($_POST['submitUpdate'])){

        $idUpdate = $_POST['idUpdate'];
        $nomUpdate = $_POST['nomUpdate'];
        $prenomUpdate = $_POST['prenomUpdate'];
        $ageUpdate = $_POST['ageUpdate'];
        $adresseMailUpdate = $_POST['adresseMailUpdate'];
        $passwordUpdate = $_POST['passwordUpdate'];
echo("4");
        $sqlUpdate = "UPDATE `users` SET `nom_user`='$nomUpdate', `prenom_user`='$prenomUpdate',`age_user`='$ageUpdate',`adresse_mail_user`='$adresseMailUpdate', `password_user`='$passwordUpdate' WHERE 
        id_user='$idUpdate'";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute();
    }