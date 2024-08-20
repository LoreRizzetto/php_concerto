DROP DATABASE IF EXISTS organizzazione_concerti; 
CREATE DATABASE organizzazione_concerti;

USE organizzazione_concerti;

CREATE TABLE concerti (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    codice TEXT, 
    titolo TEXT, 
    descrizione TEXT, 
    data DATETIME
);

CREATE TABLE sale (
    codice TEXT,
    nome TEXT,
    capienza INT,
    concerto_id INT,

    FOREIGN KEY (concerto_id) REFERENCES concerti(id)
);

CREATE TABLE pezzi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codice TEXT,
    titolo TEXT
);

CREATE TABLE concerti_pezzi (
    concerto_id INT,
    pezzo_id INT,

    FOREIGN KEY (concerto_id) REFERENCES concerti(id),
    FOREIGN KEY (pezzo_id) REFERENCES pezzi(id)
);

CREATE TABLE autori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codice TEXT,
    nome TEXT
);

CREATE TABLE autori_pezzi (
    pezzo_id INT,
    autore_id INT,

    FOREIGN KEY (pezzo_id) REFERENCES pezzi(id),
    FOREIGN KEY (autore_id) REFERENCES autori(id)
);

INSERT INTO concerti VALUES
(1, "c_cod1", "c_tit1", "c_desc1", "1970-01-01 01:01:01"),
(2, "c_cod2", "c_tit2", "c_desc2", "1970-02-02 02:02:02");

INSERT INTO sale VALUES
("s_cod1", "s_nom1", 1, 1),
("s_cod2", "s_nom2", 2, 2);

INSERT INTO pezzi VALUES
(1, "p_cod1", "p_tit1"),
(2, "p_cod2", "p_tit2"),
(3, "p_cod3", "p_tit3");

INSERT INTO concerti_pezzi VALUES
(1, 1),
(1, 2),
(2, 2),
(2, 3);

INSERT INTO autori VALUES
(1, "a_cod1", "a_nom1"),
(2, "a_cod2", "a_nom2");

INSERT INTO autori_pezzi VALUES
(1, 1),
(2, 2),
(3, 1),
(3, 2);
