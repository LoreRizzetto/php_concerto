//<?php

class {{NAME}} {
    public static PDO $pdo;

    private int $id;
    private string $codice;
    private string $titolo;
    private string $descrizione;
    private string $data;

    private bool $local;
    private bool $dirty;

    public function getId(): int {
        return $this->id;
    }

    public function getCodice(): string {
        return $this->codice;
    }
    public function setCodice(string $codice): void {
        $this->dirty = true;
        $this->codice = $codice;
    }

    public function getTitolo(): string {
        return $this->titolo;
    }
    public function setTitolo(string $titolo): void {
        $this->dirty = true;
        $this->titolo=$titolo;
    }

    public function getDescrizione(): string {
        return $this->descrizione;
    }
    public function setDescrizione(string $descrizione): void {
        $this->dirty = true;
        $this->descrizione=$descrizione;
    }

    public function getData(): string {
        return $this->data;
    }
    public function setData(string $data): void {
        $this->dirty = true;
        $this->data=$data;
    }

    public function __construct(string $codice, string $titolo, string $descrizione, string $data, int $id = null) {
        $this->local = $id === null;
        $this->dirty = $id === null;

        if ($id !== null) {
            $this->id = $id;
        }
        $this->codice = $codice;
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
        $this->data = $data;
    }

    public function __toString(): string {
        return "Concerto('$this->codice', '$this->titolo', '$this->descrizione', '$this->data', $this->id)";
    }

    public function delete(): void {
        if ($this->local) {
            throw new Error("Cannot delete local-only instance");
        }

        $stmt = self::$pdo->prepare("DELETE FROM concerti WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $this->local = true;
    }

    public function update(array $data = null): void {
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

    public static function create(array $data) {
        $inst = new self($data['codice'], $data['titolo'], $data['descrizione'], $data['data']);
        $inst->update();
        return $inst;
    }

    public static function select(Filter $filter = null, int $limit = 1000000) {
        if ($filter === null) {
            $stmt = self::$pdo->prepare("SELECT * FROM concerti LIMIT " . 0+$limit);
        } else {
            list($where_cond, $parameters) = $filter->render();
            $stmt = self::$pdo->prepare("SELECT * FROM concerti WHERE $where_cond LIMIT " . 0+$limit);
            foreach ($parameters as $key => $value) {
                $stmt->bindParam($key, $value);
            }
        }

        $stmt->execute();
        return array_map(
            function ($record) {
                return new {{NAME}}($record["codice"], $record["titolo"], $record["descrizione"], $record["data"], id: $record["id"]);
            },
            $stmt->fetchAll()
        );
    }
}

{{NAME}}::$pdo = $getpdo();
