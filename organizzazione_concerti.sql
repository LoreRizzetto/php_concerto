-- Cancellare database a caso senza aver controllato se ci sono dati importanti dentro
-- è una brutta idea. 
DROP DATABASE IF EXISTS organizzazione_concerti; 
CREATE DATABASE organizzazione_concerti;
-- Per evitare di dover specificare DB.TABLE ogni volta
USE organizzazione_concerti;

-- In teoria ci sono delle sottili differenze tra TEXT e VARCHAR(X) in particolare sul
-- troncamento delle stringhe e gestione dei trailing space.
-- In pratica queste differenza sono trascurabili
CREATE TABLE concerti (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    codice TEXT, 
    titolo TEXT, 
    descrizione TEXT, 
    data DATETIME
);

