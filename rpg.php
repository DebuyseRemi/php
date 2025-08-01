<?php

class Personnage {  

    // Variable
    public $nom;
    public $vie;
    public $force;

    public function __construct($nom, $vie, $force) {
        $this->nom = $nom;
        $this->vie = $vie;
        $this->force = $force;
    }

    
    // Getter
    public function getNom(){
        return $this->nom;
    }
    public function getVie(){
        return $this->vie;
    }

    public function getForce(){
        return $this->force;
    }

     // Setter
    public function setnom($nom){
        return $this->nom = $nom;
    }

    public function setVie($vie){
        return $this->vie = $vie;
    }

    public function setForce($force){
        return $this->force = $force;
    }


        // Methode

    public function afficherEtat(){
        echo "Le " , $this->nom , " a " , $this->vie , " points de vie ";
    }

    public function attaque(Personnage $adversaire)
    {
        if ($adversaire instanceof Voleur  && rand(1, 100) <= 30) { // 30% de chance d'esquiver avec l'utilisation de rand
            echo $adversaire->nom . " esquive l’attaque et ne subit pas de dégâts! .<br>";
        } else {
        if ($this instanceof Magicien && rand(0, 1) === 1) { // 50% de chance de faire un sort spécial et faire double dégats
            $adversaire->vie=$adversaire->vie-$this->force;
            echo "  Le magicien lance un sort spécial ! <br>" ;
        }
        $adversaire->vie=$adversaire->vie-$this->force;
        echo "Le " , $this->nom . " attaque " . $adversaire->nom . " et lui inflige " . $this->force . " points de dégâts.<br>";
        if ($adversaire->vie < 0) {
            $adversaire->vie = 0;
        }
        }

    }

    public function recevoirDegats(int $degats)
    {
        $this->vie=$this->vie-$degats;
    }
}

 class Guerrier extends Personnage {
        public function __construct(){
        $this->nom="Guerrier";
        $this->vie=120;
        $this->force=15;
    }
}

 class Voleur extends Personnage {
        public function __construct(){
        $this->nom="Voleur";
        $this->vie=100;
        $this->force=12;
    }
}

 class Magicien extends Personnage {
        public function __construct(){
        $this->nom="Magicien";
        $this->vie=90;
        $this->force=8;
    }
}

$guerrier = new Guerrier();
$voleur = new Voleur();
$mage = new Magicien();
$guerrier->afficherEtat();
echo "<br>";
$voleur->afficherEtat();
echo "<br>";
$mage->afficherEtat();
echo "<br>";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['personnage'])) {//En attente du choix du combattant par l'utilisateur
    $choix = $_POST['personnage'];//Récupération du personnage choisi

    switch($choix) {
        case 'guerrier':
            $joueur = new Guerrier();
            $adversaires = [new Voleur(), new Magicien()];
            break;
        case 'voleur':
            $joueur = new Voleur();
            $adversaires = [new Guerrier(), new Magicien()];
            break;
        case 'magicien':
            $joueur = new Magicien();
            $adversaires = [new Guerrier(), new Voleur()];
            break;
    }

    $adversaire = $adversaires[array_rand($adversaires)];// array_rand prends au hasard dans un tableau pour choisir un des deux adversaire possible

    echo "<h3>Combat entre {$joueur->getNom()} et {$adversaire->getNom()}</h3>";

    $tour = 1;
    while ($joueur->getVie() > 0 && $adversaire->getVie() > 0) {
        echo ">Tour $tour :<br>";
        $joueur->attaque($adversaire);
        if ($adversaire->getVie() <= 0) {
            echo $adversaire->getNom() . " est vaincu !<br>";
            break;
        }
        $adversaire->attaque($joueur);
        if ($joueur->getVie() <= 0) {
            echo $joueur->getNom() . " est vaincu !<br>";
            break;
        }
        $tour++;
        $joueur->afficherEtat();
        $adversaire->afficherEtat();
        echo "<br>";
    }

    echo "<br><strong>État final :</strong><br>";
    $joueur->afficherEtat();
    $adversaire->afficherEtat();
    echo "<br><a href=''>Rejouer</a>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RPG</title>
    </head>
    <body>
        <h2">Chosissez votre personnage pour le combat : </h2>
        <form method="post">
            <label><input type="radio" name="personnage" value="guerrier" > Guerrier</label><br>
            <label><input type="radio" name="personnage" value="voleur"> Voleur</label><br>
            <label><input type="radio" name="personnage" value="magicien"> Magicien</label><br><br>
            <input type="submit" value="Lancer le combat">
        </form>

        </body>
</html>
