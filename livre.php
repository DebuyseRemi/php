<?php

    // Connexion à la BDD
    $host = 'localhost';
    $dbname = 'livres';
    $user = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Requête SQL
    $sqlAll = "SELECT * FROM `livres`";

    //Préparation + execution de la requête

    $stmtAll = $pdo->prepare($sqlAll);
    $stmtAll->execute();
    
    $resultsAll = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
    

    $sqlEmprunts = "SELECT * FROM `emprunts`";
    $stmtEmprunts = $pdo->prepare($sqlEmprunts);
    $stmtEmprunts->execute();

    $resultsEmprunts = $stmtEmprunts->fetchAll(PDO::FETCH_ASSOC);


    $sqlEcrivains = "SELECT * FROM `ecrivains`";
    $stmtEcrivains = $pdo->prepare($sqlEcrivains);
    $stmtEcrivains->execute();

    $resultsEcrivains = $stmtEcrivains->fetchAll(PDO::FETCH_ASSOC);
    

    $sqlUtilisateurs = "SELECT * FROM `utilisateurs`";
    $stmtUtilisateurs = $pdo->prepare($sqlUtilisateurs);
    $stmtUtilisateurs->execute();

    $resultsUtilisateurs = $stmtUtilisateurs->fetchAll(PDO::FETCH_ASSOC);
   

    $sqlGenres = "SELECT * FROM `genres`";
    $stmtGenres = $pdo->prepare($sqlGenres);
    $stmtGenres->execute();

    $resultsGenres = $stmtGenres->fetchAll(PDO::FETCH_ASSOC);


    try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Active les erreurs PDO en exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
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
            <label>Ajoutez un genre dans la BDD</label>
            <input type="text" name="genreName">
            <input type="submit" name="submitGenre" value="Envoyé le genre de livre dans la BDD">
            <br>
        </form><!--Bien penser à séparer en 2 form pour ne pas avoir les suivants en "required" qui bloque celui-ci
-->
        
        <form method="POST">
            <br>
            <label>Prénom Ecrivain</label>
            <input type="text" name="prenomEcrivain" required>
            <br>
            <label>Nom Ecrivain</label>
            <input type="text" name="nomEcrivain" required>
            <br>
            <label>Nationalité</label>
            <input type="text" name="nationalite" required>
            <input type="submit" name="submitEcrivain" value="Envoyé données ecrivain en BDD">
        </form>

        <form method="POST">
            <br>
            <label>Prénom Utilisateur</label>
            <input type="text" name="prenomUtilisateur" required>
            <br>
            <label>Nom Utilisateur</label>
            <input type="text" name="nomUtilisateur" required>
            <br>
            <label>E-mail</label>
            <input type="text" name="email" required>
            <input type="submit" name="submitUtilisateur" value="Envoyé données utilisateur en BDD">
            <br>
            <br>
        </form>

        
        <form method="POST">
            <label>Ajouter un Livre</label>
            <br>
            <label>Titre du Livre</label>
            <input type="text" name="titre" required>
            <br>
            <label>Année de sortie du Livre</label>
            <input type="text" name="annee" required>
            <br>
            <label>Genre du livre</label>
            <select name="selectAddGenre" required>
               <?php
                    foreach ($resultsGenres as $key => $value) {
                        echo "<option value='" . $value['id_Genre'] . "'>" . $value['Libelle'] . "</option>";
                    }
                ?>
            </select>
            <br>
            <label>Auteur du livre</label>
            <select name="selectAddEcrivain" required>
               <?php
                    foreach ($resultsEcrivains as $key => $value) {
                        echo "<option value='" . $value['id_Ecrivain'] . "'>" . $value['nom_Ecrivain'] . "</option>";
                    }
                ?>
            </select>
            <br>
            <input type="submit" name="submitLivre">
        </form>


        <form method="POST">
            <label>Emprunter un Livre</label>
            <br>
            <label>Livre à emprunter</label>
            <select name="selectAddLivre" required>
               <?php
                    foreach ($resultsAll as $key => $value) {
                        if ($value['Disponible'] == 1) {
                             echo "<option value='" . $value['id_Livre'] . "'>" . $value['Titre'] . "</option>";
                    }
                }
                ?>
            </select>
            <br>
            <label>Client effectuant l'emprunt du livre</label>
            <select name="selectAddUtilisateur" required>
               <?php
                    foreach ($resultsUtilisateurs as $key => $value) {
                        echo "<option value='" . $value['id_Utilisateur'] . "'>" . $value['nom_Utilisateur'] . "</option>";
                    }
                ?>
            </select>
            <br>
            <input type="submit" name="submitEmprunt">
        </form>

        <form method="POST">    
            <?php

                        ob_start();//Nécessaire pour pas de problèmes avec les echo

                foreach ($resultsAll as $key => $value) {
                    $idASupprimer = $value['id_Livre'];
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
                    $sqlDelete = "DELETE FROM `livres` WHERE id_Livre = '$idToDelete'";
                    $stmtDelete = $pdo->prepare($sqlDelete);
                    $stmtDelete->execute();
                    header("Location: livre.php");
                    exit();
                }
                ob_end_flush();//Il faut fermer après l'avoir ouvert
            ?>
        </form>
<?php

 if(isset($_POST['submitLivre'])){
        $genre = $_POST['selectAddGenre'];
        $titre = $_POST['titre'];
        $annee = $_POST['annee'];
        $ecrivain = $_POST['selectAddEcrivain'];

        echo $genre . ' - - ' . $titre . ' - - ' . $annee . ' - - ' . $ecrivain ;


        $sql = "INSERT INTO `livres`(`Annee`, `Titre`, `id_Ecrivain`, `id_Genre`, `Disponible`) 
        VALUES (:annee, :titre, :ecrivain, :genre, 1)";
        $stmt = $pdo->prepare($sql);

        // Lier les variables avec les paramètres préparés
        $stmt->bindParam(':annee', $annee);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':ecrivain', $ecrivain);
        $stmt->bindParam(':genre', $genre);

        $stmt->execute();
        echo "Livre envoyé en BDD";
        echo "<form action='livre.php' method='post'>";    
    }


if(isset($_POST['submitGenre'])){
        $libelle = $_POST['genreName'];
        $sql = "INSERT INTO `genres`(`libelle`) VALUES ('$libelle')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        echo "data Genre envoyée en BDD";
        header("Location: indexLogin.php?page=viewModifBook");


    }


if(isset($_POST['submitEcrivain'])){
        $preEcriv = $_POST['prenomEcrivain'];
        $nomEcriv = $_POST['nomEcrivain'];
        $nationalite = $_POST['nationalite'];

        echo $preEcriv . ' - - ' . $nomEcriv . ' - - ' . $nationalite ;
        
         $sqlCreate = "INSERT INTO `ecrivains`(`prenom_Ecrivain`, `nom_Ecrivain`, `Nationalite`) VALUES
        (:prenom,:nom,:nationalite)";// Changement de méthode pour pouvoir prendre en compte les apostrophes dans les saisies



            $stmtCreate = $pdo->prepare($sqlCreate);

            $stmtCreate->bindParam(':prenom', $preEcriv);
            $stmtCreate->bindParam(':nom', $nomEcriv);
            $stmtCreate->bindParam(':nationalite', $nationalite);//Rajout de cette partie entre le "prepare" et "execute"

            $stmtCreate->execute();

        echo "data envoyées en BDD";

    }

    if(isset($_POST['submitUtilisateur'])){
        $preUtil = $_POST['prenomUtilisateur'];
        $nomUtil = $_POST['nomUtilisateur'];
        $email = $_POST['email'];

        echo $preUtil . ' - - ' . $nomUtil . ' - - ' . $email ;
        
         $sqlCreate = "INSERT INTO `utilisateurs`(`prenom_Utilisateur`, `nom_Utilisateur`, `email`) VALUES
        (:prenom,:nom,:email)";// Changement de méthode pour pouvoir prendre en compte les apostrophes dans les saisies



            $stmtCreate = $pdo->prepare($sqlCreate);

            $stmtCreate->bindParam(':prenom', $preUtil);
            $stmtCreate->bindParam(':nom', $nomUtil);
            $stmtCreate->bindParam(':email', $email);//Rajout de cette partie entre le "prepare" et "execute"

            $stmtCreate->execute();

        echo "data envoyées en BDD";
        header("Location: indexLogin.php?page=viewModifBook");


    }


    if(isset($_POST['submitEmprunt'])){
        $livre = $_POST['selectAddLivre'];
        $utilisateur = $_POST['selectAddUtilisateur'];

        echo $livre . ' - - ' . $utilisateur  ;


        $sql = "INSERT INTO `emprunts`(`id_Livre`, `id_Utilisateur`,`date_Emprunt`,`date_Retour`) 
        VALUES (:livre, :utilisateur, NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY)  )";//NOW() recupère la date lors de l'exécution et le suivant avec DATE_ADD() rajoute un intervalle
        $stmt = $pdo->prepare($sql);

        // Lier les variables avec les paramètres préparés
        $stmt->bindParam(':livre', $livre);
        $stmt->bindParam(':utilisateur', $utilisateur);


        $stmt->execute();


        echo "Emprunt envoyé en BDD";
        header("Location: indexLogin.php?page=viewModifBook");

        }


        if(isset($_GET["id"])){        
        $id = $_GET['id'];
        $sqlId = "SELECT * FROM `livres` WHERE id_Livre = '$id'";

        //Préparation + Execution de la requête
        $stmtId = $pdo->prepare($sqlId);
        $stmtId->execute();
        
        $resultsId = $stmtId->fetchAll(PDO::FETCH_ASSOC);

        echo '<form method="POST">
        <label for="">ID</label>
        <input type="text" name="idUpdate" value="' . $resultsId[0]['id_Livre'] . '" readonly>
        <br>
        <label for="">Titre</label>
        <input type="text" name="titreUpdate" value="' . $resultsId[0]['Titre'] . '">
        <br>
        <label for="">Annee</label>
        <input type="text" name="anneeUpdate" value="' . $resultsId[0]['Annee'] . '">
        <br>
        <label for="">Ecrivain</label>
        <input type="text" name="ecrivainUpdate" value="' . $resultsId[0]['id_Ecrivain'] . '">
        <br>
        <label for="">Genre</label>
        <input type="text" name="genreUpdate" value="' . $resultsId[0]['id_Genre'] . '">
        <br>
        <label for="">Disponible</label>
        <input type="text" name="disponibleUpdate" value="' . $resultsId[0]['Disponible'] . '">
        <br>
        <input type="submit" name="submitUpdate" value="Mettre à jour la BDD">
    </form>';

        var_dump($resultsId);
    }

    if(isset($_POST['submitUpdate'])){
        echo "1";
        $idUpdate = $_POST['idUpdate'];
        $titre = $_POST['titreUpdate'];
        $annee = $_POST['anneeUpdate'];
        $ecrivain = $_POST['ecrivainUpdate'];
        $genre = $_POST['genreUpdate'];
        $disponible = $_POST['disponibleUpdate'];
        echo "2";
        $sqlUpdate = "UPDATE `livres` SET `Titre`='$titre', `Annee`='$annee',`id_Ecrivain`='$ecrivain',`id_Genre`='$genre',`Disponible`='$disponible' WHERE 
        id_Livre='$idUpdate'";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute();
        header("Location: livre.php?page=viewModifBook");
    }

?>
