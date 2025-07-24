<?php


// BDB CONNECT
    $host = 'localhost';
    $dbname = 'exercice';
    $user = 'root';
    $password = '';

    $pdo = new PDO ("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // REQUETE SQL

    $sql = "SELECT * FROM `personnage`";

    //EXECUTION

    $req = $pdo->prepare($sql);
    $req->execute();
    $results = $req->fetchAll();

    //EXPLOITATION

    foreach ($results as $key => $tab) {


        echo $tab["nom"];
        echo"<br>";


    }

    ?>