<?php
include 'config.php';
include 'concerto.php';

$pdo = new PDO("mysql:dbname=" . DbConf::$database . ";host=" . DbConf::$host, DbConf::$username, DbConf::$password);

ConcertoFactory::bind("Concerto", $pdo);

$obj = new Concerto("cod1", "titolo1", "descrizione1", "1970-01-01 01:01:01");
$obj->update();

$obj2 = Concerto::create(["codice"=>"cod2", "titolo"=>"titolo2", "descrizione"=>"descrizione2", "data"=>"1970-02-02 02:02:02"]);

system('doas mariadb -e "SELECT * FROM concerti.concerti";');
echo "=============" . PHP_EOL;

$obj->delete();
$obj2->delete();

system('doas mariadb -e "SELECT * FROM concerti.concerti";');
echo "=============" . PHP_EOL;
