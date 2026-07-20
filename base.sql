DROP TABLE IF EXISTS operateurs;

DROP TABLE IF EXISTS type_operation;

DROP TABLE IF EXISTS frais;

DROP TABLE IF EXISTS operations;

DROP TABLE IF EXISTS solde;

DROP TABLE IF EXISTS utilisateurs;

DROP TABLE IF EXISTS commission;

DROP TABLE IF EXISTS transfert;

CREATE TABLE operateurs(
    idOperateur INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe varchar(10),
    nom varchar(50)
);

INSERT INTO operateurs(prefixe, nom) VALUES
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
    montant decimal(10,2),
    idTypeOperation INT REFERENCES type_operation(idType_operation)
);

INSERT INTO frais (description, montantMin, montantMax, montant, idTypeOperation) VALUES
('Depot entre 100 et 1 000 Ar', 100.00, 1000.00, 50.00, 1),
('Depot entre 1001 et 5 000 Ar', 1001.00, 5000.00, 50.00, 1),
('Depot entre 5 001 et 10 000 Ar', 5001.00, 10000.00, 100.00, 1),
('Depot entre 10 001 et 25 000 Ar', 10001.00, 25000.00, 200.00, 1),
('Depot entre 25 001 et 50 000 Ar', 25001.00, 50000.00, 400.00, 1),
('Depot entre 50 001 et 100 000 Ar', 50001.00, 100000.00, 800.00, 1),
('Depot entre 100 001 et 250 000 Ar', 100001.00, 250000.00, 1500.00, 1),
('Depot entre 250 001 et 500 000 Ar', 250001.00, 500000.00, 1500.00, 1),
('Depot entre 500 001 et 1 000 000 Ar', 500001.00, 1000000.00, 2500.00, 1),
('Depot entre 1 000 001 et 2 000 000 Ar', 1000001.00, 2000000.00, 3000.00, 1),

('Retrait entre 100 et 1 000 Ar', 100.00, 1000.00, 50.00, 2),
('Retrait entre 1001 et 5 000 Ar', 1001.00, 5000.00, 50.00, 2),
('Retrait entre 5 001 et 10 000 Ar', 5001.00, 10000.00, 100.00, 2),
('Retrait entre 10 001 et 25 000 Ar', 10001.00, 25000.00, 200.00, 2),
('Retrait entre 25 001 et 50 000 Ar', 25001.00, 50000.00, 400.00, 2),
('Retrait entre 50 001 et 100 000 Ar', 50001.00, 100000.00, 800.00, 2),
('Retrait entre 100 001 et 250 000 Ar', 100001.00, 250000.00, 1500.00, 2),
('Retrait entre 250 001 et 500 000 Ar', 250001.00, 500000.00, 1500.00, 2),
('Retrait entre 500 001 et 1 000 000 Ar', 500001.00, 1000000.00, 2500.00, 2),
('Retrait entre 1 000 001 et 2 000 000 Ar', 1000001.00, 2000000.00, 3000.00, 2),

('Transfert entre 100 et 1 000 Ar', 100.00, 1000.00, 50.00, 3),
('Transfert entre 1001 et 5 000 Ar', 1001.00, 5000.00, 50.00, 3),
('Transfert entre 5 001 et 10 000 Ar', 5001.00, 10000.00, 100.00, 3),
('Transfert entre 10 001 et 25 000 Ar', 10001.00, 25000.00, 200.00, 3),
('Transfert entre 25 001 et 50 000 Ar', 25001.00, 50000.00, 400.00, 3),
('Transfert entre 50 001 et 100 000 Ar', 50001.00, 100000.00, 800.00, 3),
('Transfert entre 100 001 et 250 000 Ar', 100001.00, 250000.00, 1500.00, 3),
('Transfert entre 250 001 et 500 000 Ar', 250001.00, 500000.00, 1500.00, 3),
('Transfert entre 500 001 et 1 000 000 Ar', 500001.00, 1000000.00, 2500.00, 3),
('Transfert entre 1 000 001 et 2 000 000 Ar', 1000001.00, 2000000.00, 3000.00, 3);


CREATE TABLE utilisateurs(
    idUtilisateur INTEGER PRIMARY KEY AUTOINCREMENT,
    nom varchar(75),
    telephone varchar(30),
    motdepasse varchar(20)
);

INSERT INTO utilisateurs(nom, telephone, motdepasse) VALUES
('Alice', '0320000000', 'a'),
('Admin', '0330000000', 'a'),
('Bob', '0341234567', 'pass123'),
('Charlie', '0339876543', 'secret'),
('Ravo', '0321122334', 'mypassword');

CREATE TABLE operations(
    idOperation INTEGER PRIMARY KEY AUTOINCREMENT,
    idOperateur INT REFERENCES operateurs(idOperateur),
    idType_operation INT REFERENCES type_operation(idType_operation),
    idFrais INT REFERENCES frais(idFrais),
    idUtilisateur INT REFERENCES utilisateurs(idUtilisateur),
    idDestinataire INT REFERENCES utilisateurs(idUtilisateur),
    date_operation DATE,
    montant decimal(10,2)
);

INSERT INTO operations (idOperateur, idType_operation, idFrais, idUtilisateur, date_operation, montant) VALUES
(1, 1, 2, 1, '2026-07-01', 5000.00),
(2, 2, 4, 2, '2026-07-02', 20000.00),
(2, 3, 5, 3, '2026-07-05', 50000.00),
(1, 1, 7, 4, '2026-07-10', 150000.00),
(1, 3, 1, 5, '2026-07-12', 500.00),
(2, 1, 9, 4, '2026-07-15', 600000.00),
(1, 3, 10, 3, '2026-07-18', 1500000.00),
(2, 1, 4, 1, '2026-07-20', 15000.00);

CREATE TABLE solde(
    idSolde INTEGER PRIMARY KEY AUTOINCREMENT,
    idUtilisateur INT REFERENCES utilisateurs(idUtilisateur),
    montant decimal(10,2)
);

INSERT INTO solde(idUtilisateur, montant) VALUES
(1, 10000),
(2, 20000),
(3, 50000.00),
(4, 150000.00),
(5, 5000.00);

CREATE TABLE commission(
    idCommission INTEGER PRIMARY KEY AUTOINCREMENT,
    idOperateur INT REFERENCES operateurs(idOperateur),
    pourcentage decimal(10,2)
);

INSERT INTO commission(idOperateur, pourcentage) VALUES
(1, 20);
 
