<?php
class Concerto {
    private static $pdo;
    private $id;
    private $codice;
    private $titolo;
    private $descrizione;
    private $data;

    public function getId() {
        return $this->id;
    }

    public function getCodice() {
        return $this->codice;
    }

    public function setCodice($codice) {
        $this->codice = $codice;
    }

    public function getTitolo($titolo){
        return $this->titolo;
    }

    public function setTitolo($titolo){
        $this->titolo=$titolo;
    }

    public function getDescrizione($descrizione){
        return $this->descrizione;
    }
    public function setDescrizione($descrizione){
        $this->descrizione=$descrizione;
    }

    public function getData($data){
        return $this->data;
    }

    public function setData($data){
        $this->data=$data;
    }

    private function __construct($codice, $titolo, $descrizione, $data) {
        $this->codice = $codice;
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
        $this->data = $data;
    }

    public function delete() {
        // once delete is invoked this object should never be used again
        $stmt = self::getPdo()->prepare("DELETE FROM concerti WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function update($data = null) {
        if ($data === null) {
            $data=[];
        }

        $stmt = self::getPdo()->prepare("UPDATE concerti SET codice = :codice, titolo = :titolo, descrizione = :descrizione, data = :data WHERE id = :id");

        $stmt->bindParam(':codice', isset($data['codice']) ? $data['codice'] : $this->codice);
        $stmt->bindParam(':titolo', isset($data['titolo']) ? $data['titolo'] : $this->titolo);
        $stmt->bindParam(':descrizione', isset($data['descrizione']) ? $data['descrizione'] : $this->descrizione);
        $stmt->bindParam(':data', isset($data['data']) ? $data['data'] : $this->data);
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        // Update the object attributes (this may set attributes other than the intended ones. Oh well)
        foreach ($data as $key => $value) {
            $this->{$key} = $value; 
        }
    }

    public function show() {
        $stmt = self::getPdo()->prepare("SELECT * FROM concerti WHERE id = :id");
        $stmt->bindParam (':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $stmt = self::getPdo()->prepare("INSERT INTO concerti (codice, titolo, descrizione, data) VALUES (:codice, :titolo, :descrizione, :data)");
        $stmt->bindParam(':codice', $data['codice']);
        $stmt->bindParam(':titolo', $data['titolo']);
        $stmt->bindParam(':descrizione', $data['descrizione']);
        $stmt->bindParam(':data', $data['data']);
        $stmt->execute();
        return new self($data['codice'], $data['titolo'], $data['descrizione'], $data['data']);
    }

    public static function find() {
        throw new Exception("Not Implemented.");
    }

    public static function getPdo() {
        return self::$pdo;
    }

    public static function setPdo($pdo) {
        self::$pdo = $pdo;
    }
}
