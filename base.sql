DROP TABLE IF EXISTS operateurs;

DROP TABLE IF EXISTS type_operation;

DROP TABLE IF EXISTS frais;

DROP TABLE IF EXISTS operations;

DROP TABLE IF EXISTS solde;

DROP TABLE IF EXISTS utilisateurs;

CREATE TABLE operateurs(
    idOperateur INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe varchar(10),
    nom varchar(50)
);

INSERT INTO operateurs(prefixe, nom) VALUES
('032', 'Orange'),
('033', 'Airtel'),
('037', 'Orange'),
('034', 'Yas'),
('038', 'Yas');

CREATE TABLE type_operation(
    idType_operation INTEGER PRIMARY KEY AUTOINCREMENT,
    nom varchar(50)
);

INSERT INTO type_operation(nom) VALUES
('depot'),
('retrait'),
('transfert');

CREATE TABLE frais(
    idFrais INTEGER PRIMARY KEY AUTOINCREMENT,
    description varchar(100),
    montantMin decimal(10,2),
    montantMax decimal(10,2),
    montant decimal(10,2)
);

CREATE TABLE operations(
    idOperation INTEGER PRIMARY KEY AUTOINCREMENT,
    idOperateur INT REFERENCES operateurs(idOperateur),
    idType_operation INT REFERENCES type_operation(idType_operation),
    idFrais INT REFERENCES frais(idFrais),
    date_operation DATE,
    montant decimal(10,2)
);

CREATE TABLE utilisateurs(
    idUtilisateur INTEGER PRIMARY KEY AUTOINCREMENT,
    nom varchar(75),
    telephone varchar(30),
    motdepasse varchar(20)
);

INSERT INTO utilisateurs(nom, telephone, motdepasse) VALUES
('Alice', '0320000000', 'a'),
('Admin', '0330000000', 'a');

CREATE TABLE solde(
    idSolde INTEGER PRIMARY KEY AUTOINCREMENT,
    idUtilisateur INT REFERENCES utilisateurs(idUtilisateur),
    montant decimal(10,2)
);

INSERT INTO solde(idUtilisateur, montant) VALUES
(1, 10000),
(2, 20000);
