//<?php

class {{NAME}} {
    public static $pdo;

    private $id;
    private $codice;
    private $titolo;
    private $descrizione;
    private $data;

    private $local;
    private $dirty;

    public function getId() {
        return $this->id;
    }

    public function getCodice() {
        return $this->codice;
    }
    public function setCodice($codice) {
        $this->dirty = true;
        $this->codice = $codice;
    }

    public function getTitolo($titolo){
        return $this->titolo;
    }
    public function setTitolo($titolo){
        $this->dirty = true;
        $this->titolo=$titolo;
    }

    public function getDescrizione($descrizione){
        return $this->descrizione;
    }
    public function setDescrizione($descrizione){
        $this->dirty = true;
        $this->descrizione=$descrizione;
    }

    public function getData($data){
        return $this->data;
    }
    public function setData($data){
        $this->dirty = true;
        $this->data=$data;
    }

    public function __construct($codice, $titolo, $descrizione, $data) {
        $this->local = true;
        $this->dirty = true;

        $this->codice = $codice;
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
        $this->data = $data;
    }

    public function delete() {
        if ($this->local) {
            throw new Error("Cannot delete local-only instance");
        }

        $stmt = self::$pdo->prepare("DELETE FROM concerti WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $this->local = true;
    }

    public function update($data = null) {
        if ($data === null) {
            $data=[];
        }

        foreach ($data as $key => $value) {
            $this->{$key} = $value; 
        }

        if ($this->local) {
            $stmt = self::$pdo->prepare("INSERT INTO concerti (codice, titolo, descrizione, data) VALUES (:codice, :titolo, :descrizione, :data)");

        } else {
            $stmt = self::$pdo->prepare("UPDATE concerti SET codice = :codice, titolo = :titolo, descrizione = :descrizione, data = :data WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
        }

        $stmt->bindParam(':codice', $this->codice);
        $stmt->bindParam(':titolo', $this->titolo);
        $stmt->bindParam(':descrizione', $this->descrizione);
        $stmt->bindParam(':data', $this->data);

        $stmt->execute();

        if ($this->local) {
            $this->id = self::$pdo->lastInsertId();
            $this->local = false;
        }

        $this->dirty = false;
    }

    //public function show() {
    //    $stmt = self::$pdo->prepare("SELECT * FROM concerti WHERE id = :id");
    //    $stmt->bindParam (':id', $this->id);
    //    $stmt->execute();
    //    return $stmt->fetch(PDO::FETCH_ASSOC);
    //}

    public static function create($data) {
        $inst = new self($data['codice'], $data['titolo'], $data['descrizione'], $data['data']);
        $inst->update();
        return $inst;
    }

    //public static function find() {
    //    throw new Exception("Not Implemented.");
    //}
}

{{NAME}}::$pdo = $getpdo();
