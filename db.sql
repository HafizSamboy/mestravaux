CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL
);

CREATE TABLE evenements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    heure TIME NOT NULL,
    lieu VARCHAR(100) NOT NULL,
    description TEXT,
    photo VARCHAR(255)
);

CREATE TABLE inscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_evenement INT NOT NULL,
    nombre_billets INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id),
    FOREIGN KEY (id_evenement) REFERENCES evenements(id)
);

CREATE TABLE annonces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    contenu TEXT NOT NULL,
    date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_evenement INT NOT NULL,
    commentaire TEXT NOT NULL,
    note INT NOT NULL,
    date_evaluation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id),
    FOREIGN KEY (id_evenement) REFERENCES evenements(id)
);
