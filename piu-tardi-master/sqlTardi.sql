
CREATE TABLE utente(
	ID int(11) PRIMARY KEY auto_increment,
    password varchar(256) NOT NULL,
    nome varchar(30) NOT NULL,
    cognome varchar(30) NOT NULL,
    eta int(11) NOT NULL,
    classe varchar(30) NOT NULL,
    email varchar(30) NOT NULL,
	foto varchar(50)
);

CREATE TABLE tipologia(
	ID int(11) PRIMARY KEY auto_increment,
    nome varchar(30) NOT NULL
);

CREATE TABLE annuncio(
	ID int(11) PRIMARY KEY auto_increment,
    nome varchar(30) NOT NULL,
    descrizione varchar(255) DEFAULT NULL,
    foto varchar(50),
    datacaricamento timestamp DEFAULT current_timestamp(),
    ID_utente int(11) NOT NULL,
    ID_tipologia int(11) NOT NULL,
    FOREIGN KEY(ID_utente) REFERENCES utente(ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(ID_tipologia) REFERENCES tipologia(ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE proposta(
	ID int(11) PRIMARY KEY auto_increment,
    prezzo int(11) NOT NULL,
    ID_utente int(11) NOT NULL,
    dataproposta timestamp DEFAULT current_timestamp(),
    ID_annuncio int(11) NOT NULL,
    stato varchar(11) NOT NULL,
    FOREIGN KEY (ID_utente) REFERENCES utente(ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ID_annuncio) REFERENCES annuncio(ID) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO tipologia (nome) VALUES ('Telefonia');
INSERT INTO tipologia (nome) VALUES ('Informatica');
INSERT INTO tipologia (nome) VALUES ('Videogiochi');
INSERT INTO tipologia (nome) VALUES ('Libri');
