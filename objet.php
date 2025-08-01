<?php

class Chat {  

    // Variable
    private $race;
    private $typePoil;
    private $couleurPoils;
    private $couleurYeux;
    private $genre;


    // Construct
    public function __construct($race, $typePoil, $couleurPoils, $couleurYeux, $genre) {
        $this->race = $race;
        $this->typePoil = $typePoil;
        $this->couleurPoils = $couleurPoils;
        $this->couleurYeux = $couleurYeux;
        $this->genre = $genre;
    }

    // Getter
    public function getRace(){
        return $this->race;
    }
    public function getTypePoil(){
        return $this->typePoil;
    }
    public function getCouleurPoils(){
        return $this->couleurPoils;
    }
    public function getCouleurYeux(){
        return $this->couleurYeux;
    }
    public function getGenre(){
        return $this->genre;
    }
    
    // Setter
    public function setRace($race){
        return $this->race = $race;
    }
    public function setTypePoil($typePoil){
        return $this->typePoil = $typePoil;
    }
    public function setCouleurPoils($couleur){
        return $this->couleurPoils = $couleur;
    }
    public function setCouleurYeux($couleur){
        return $this->couleurYeux = $couleur;
    }
    public function setGenre($genre){
        return $this->genre = $genre;
    }
    

    // Methode

    public function test(){
        echo "<p>je fais un test</p>";
    }
}

$chat = new Chat('Persan', "Long", "blanc", "orange", "femelle");
var_dump($chat);
$chat->test();//Bien penser à appeler chat vu que test est déclaré DEDANS