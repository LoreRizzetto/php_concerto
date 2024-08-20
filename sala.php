<?php

class Sala {
    private string $codice;
    private string $nome; 
    private string $capienza;
    
    public function getCodice(){
        return $this->codice;
    }
    public function setCodice($codice){
        $this->codice = $codice;
    }

    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getCapienza(){
        return $this->capienza;
    }
    public function setCapienza($capienza){
        $this->capienza = $capienza;
    }
}
