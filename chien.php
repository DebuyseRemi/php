<?php

class Chien {  

    // Variable
    private $race;
    private $nom;

    public function __construct($race, $nom) {
        $this->race = $race;
        $this->nom = $nom;
    }

    
    // Getter
    public function getRace(){
        return $this->race;
    }
    public function getNom(){
        return $this->nom;
    }

     // Setter
    public function setRace($race){
        return $this->race = $race;
    }
    public function setnom($nom){
        return $this->nom = $nom;
    }

    // Methode

    public function aboyer(){
        echo "Woof! Je suis ", $this->nom;
    }
}

$chien1 = new Chien('Berger Allemand',"Rex");
var_dump($chien1);
$chien1->aboyer();
$chien1->setnom("Max");
$chien1->aboyer();