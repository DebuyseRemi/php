<?php

class Humain {  

    // Variable
    private $couleurYeux;
    private $genre;


    // Construct
    public function __construct($couleurYeux, $genre) {
        $this->couleurYeux = $couleurYeux;
        $this->genre = $genre;
    }
}
    class Homme extends Humain {
        public function __construct($genre){
        $this->$genre="Homme";
    }
}

class Femme extends Humain {
        public function __construct($genre){
        $this->$genre="Femme";
    }
}

$femme = new Femme('bleu');