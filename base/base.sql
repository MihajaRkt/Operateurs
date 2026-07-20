DROP TABLE IF EXISTS Utilisateur;

CREATE OR REPLACE TABLE Utilisateur(
    idUtilisateur int primary key auto_increment,
    nom varchar(75),
    email varchar(30),
    genre varchar(1),
    motdepasse varchar(20)
);

INSERT INTO Utilisateur(nom, email, genre, motdepasse) VALUES
('Alice', 'alice@gmail.com', 'F', 'a'),
('Admin', 'a@local', 'M', 'a');
