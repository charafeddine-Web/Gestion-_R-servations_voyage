CREATE DATABASE IF NOT EXISTS agence_de_voyage_OOP;
USE agence_de_voyage_OOP;

CREATE TABLE IF NOT EXISTS roles (
    idRole INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nomRole ENUM('superadmin', 'admin', 'client')
);

CREATE TABLE IF NOT EXISTS user (
    id_client INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(100),
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(15),
    idRole INT,
    FOREIGN KEY (idRole) REFERENCES roles(idRole)
);

CREATE TABLE IF NOT EXISTS reservations (
    id_reservation INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_client INT,
    id_activite INT,
    date_reservation TIMESTAMP,
    status ENUM('En_attente', 'Confirmée', 'Annulée'),
    FOREIGN KEY (id_client) REFERENCES user(id_client) ON DELETE CASCADE,
    FOREIGN KEY (id_activite) REFERENCES activites(id_activite) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS activites (
    id_activite INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(150),
    description TEXT,
    destination VARCHAR(100),
    price DECIMAL(10, 2) NOT NULL,
    start_date DATE,
    end_date DATE,
    nbr_places INT NOT NULL,
    id_reservation INT,
    FOREIGN KEY (id_reservation) REFERENCES reservations(id_reservation)
);
