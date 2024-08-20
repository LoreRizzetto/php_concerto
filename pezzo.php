<?php

class Pezzo {
    private int $id;
    private string $codice;
    private string $titolo;

    public function getId(){
        return $this->id;
    }

    public function getCodice(){
        return $this->codice;
    }
    public function setCodice($codice){
        $this->codice = $codice;
    }

    public function getTitolo(){
        return $this->titolo;
    }
    public function setTitolo($titolo){
        $this->titolo = $titolo;
    }
}
