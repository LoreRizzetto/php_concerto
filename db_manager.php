<?php

class DbManager extends PDO {
    public function __construct(string $database, string $host, ?string $username=null, ?string $password=null) {
        parent::__construct("mysql:dbname=$database;host=$host", $username, $password);
    }
}
