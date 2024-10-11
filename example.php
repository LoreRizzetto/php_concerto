<?php
include 'config.php';
include 'concerto.php';

$pdo = new PDO("mysql:dbname=" . DbConf::$database . ";host=" . DbConf::$host, DbConf::$username, DbConf::$password);

ConcertoFactory::bind("Concerto", $pdo);

foreach (Concerto::select() as $obj) {
    $obj->delete();
}

$obj = new Concerto("cod1", "titolo1", "descrizione1", "1970-01-01 01:01:01");
$obj->update();

$obj2 = Concerto::create(["codice"=>"cod2", "titolo"=>"titolo2", "descrizione"=>"descrizione2", "data"=>"1970-02-02 02:02:02"]);

Concerto::select(Filter::codice()->eq("cod2"))[0]->delete();

foreach (Concerto::select() as $obj) {
    echo $obj . PHP_EOL;
}
