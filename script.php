<?php 

include 'config.php';
include 'concerto.php';

$pdo = new PDO($dsn, $username, $password);
Concerto::setPdo($pdo);

$concerto = Concerto::create([
    "codice"=>"codice1", 
    "titolo"=>"titolo1", 
    "descrizione"=>"descrizione1", 
    "data"=>"2023-08-12 23:01:55"
]);
