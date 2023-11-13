<?php
include 'concerto.php';
include 'db_manager.php';

// Iniziamo con il ""parsing"" di config.txt
// $cfg è il dizionario (/ array associativo / map) che contiene la configurazione
$cfg = [];

// Per prima cosa dobbiamo leggere il file.
// Grazie all'ottimo design della standard library di php, ci sono circa 753 modi per farlo
// file(string $filename) è uno di questi.
// Il nome del file viene passato come primo argomento e restituisce un array contente le 
// linee del file. Non rimuove il \n che termina la linea.
//
// array(4) {
//   [0]=> string(4) "foo\n"
//   [1]=> string(4) "bar\n"
//   [2]=> string(1) "\n"
//   [3]=> string(4) "baz\n"
// }
$cfg_linee = file("config.txt");

foreach ($cfg_linee as $linea) {
    // Per prima cosa bisogna assicurarsi che la linea non sia vuota e che non sia un commento
    if (
        str_starts_with($linea, "//")
        || $linea === "\n"
    ) {
        continue;
    }

    // Se raggiungiamo questo codice sappiamo che la linea non è ne un commento nè una linea vuota
    // In questo caso ci sono due possibilità: o è nel formato KEY:VALUE oppure non è una linea valida
    //
    // explode(string $separator, string $string, int $limit = PHP_INT_MAX)
    // il primo argomento è il separatore da utilizzare per separare la stringa
    // il secondo argomento è la stringa da separare
    // il terzo argomento è il numero massimo di parti in cui dividere la stringa
    //
    // In questo caso, visto che vogliamo dividere la stringa $linea usando ":" come separatore e ammettiamo
    // solo due possibili gruppi (KEY e VALUE) dobbiamo invocarla in questo modo:
    $gruppi = explode(":", $linea, 2);

    // Se c'è un solo elemento nell'array allora : non è presente nella linea
    if (count($gruppi) == 1) {
        echo 'Linea non valida (non contiene ":"): ' . $linea . PHP_EOL;
        exit(1);
    }

    // key = parte prima dei ":"
    // value = parte dopo
    $key = $gruppi[0];
    $value = substr($gruppi[1], 0, -1);

    // non si possono iterare le stringe con foreach, bisogna convertire la stringa ad un array, grazie php
    foreach (str_split($key) as $lettera) {
        if ($lettera < "A" || $lettera > "z") {
            echo "Key non valida (non è formata solo da lettere): " . $key . PHP_EOL;
            exit(1);
        }
    }

    // Come abbiamo stabilito circa 110 linee fa $cfg deve contenere la nostra configurazione
    $cfg[$key] = $value; 
};

// Il prossimo step è connettersi al database
$db = new DbManager($cfg["database"], $cfg["host"], $cfg["username"], $cfg["password"]);
// E inizializzare Concerto con la connessione al db
Concerto::setPdo($db);

while (true) {
    echo "premere 1 per creare un record" . PHP_EOL
        . "premere 2 per mostrare un record" . PHP_EOL
        . "premere 3 per modificare un record" . PHP_EOL
        . "premere 4 per eliminare un record" . PHP_EOL
        . "premere 5 per mostrare tutti i records presenti nella tabella" . PHP_EOL
        . "premere 0 per terminare il programma" . PHP_EOL;
    $input = readline("> ");

    if ($input == "1\n") {
        $concerto = Concerto::Create([
            "codice" => readline("codice> "), 
            "titolo" => readline("titolo> "),
            "descrizione" => readline("descrizione> "),
            "data" => readline("data> "),
        ]);
        var_dump($concerto);

    } else if ($input == "2\n") {
        $id = readline("id> ");
        var_dump(Concerto::Find($id));

    } else if ($input == "3\n") {
        $id = readline("id> ");
        $obj = Concerto::Find($id);

        $codice = readline("codice> ");
        $obj->setCodice($codice === "\n" ? $obj->getCodice() : $codice);

        $titolo = readline("titolo> ");
        $obj->setTitolo($titolo === "\n" ? $obj->getTitolo() : $titolo);

        $descrizione = readline("descrizione> ");
        $obj->setDescrizione($descrizione === "\n" ? $obj->getDescrizione() : $descrizione);

        $data = readline("data> ");
        $obj->setData($data === "\n" ? $obj->getData() : $data);

        $obj->update();

        var_dump($obj);

    } else if ($input == "4\n") {
        $id = readline("> ");
        $obj = Concerto::Find($id);
        if ($obj !== false) {
            $obj->Delete();
        }

    } else if ($input == "5\n") {
        foreach (Concerto::FindAll() as $obj) {
            var_dump($obj);
            echo "=========" . PHP_EOL;
        }

    } else if ($input == "0\n") {
        exit(0);
    } 
}
