CREATE DATABASE IF NOT EXISTS agence_de_voyage_OOP;
USE agence_de_voyage_OOP;

CREATE TABLE IF NOT EXISTS roles (
    idRole INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nomRole ENUM('superadmin', 'admin', 'client')
);


CREATE TABLE IF NOT EXISTS users (
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
    nbr_places int not null,
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
);
----------------------------------------INSERTION LES DONNER----------------
-- insert roles
INSERT INTO roles (nomRole) VALUES ('superadmin');
INSERT INTO roles (nomRole) VALUES ('admin');
INSERT INTO roles (nomRole) VALUES ('client');

-- Insert users
INSERT INTO users (name, email, password, idRole) 
VALUES ('Ali Benomar', 'ali.benomar@gmail.com', 'password123', 2);
INSERT INTO users (name, email, password, idRole) 
VALUES ('Fatima Zohra', 'fatima.zohra@gmail.com', 'mypassword456', 3);
INSERT INTO users (name, email, password, idRole) 
VALUES ('Omar El Mansouri', 'omar.mansouri@gmail.com', 'securepass789', 3);

-- Insert activities 
INSERT INTO activites (name, description, destination, price, start_date, end_date) 
VALUES ('Excursion au désert', 'Explorez les dunes de Merzouga avec une nuit dans un camp berbère.', 'Merzouga', 1200.00, '2025-01-10', '2025-01-12');
INSERT INTO activites (name, description, destination, price, start_date, end_date) 
VALUES ('Visite guidée de Marrakech', 'Découvrez les monuments historiques et les souks colorés de la médina.', 'Marrakech', 500.00, '2025-02-01', '2025-02-02');
INSERT INTO activites (name, description, destination, price, start_date, end_date) 
VALUES ('Randonnée à Imlil', 'Une journée de randonnée dans les montagnes de l’Atlas.', 'Imlil', 300.00, '2025-03-05', '2025-03-05');

-- Insert reservations
INSERT INTO reservations (id_client, id_activite, date_reservation, nbr_places, status)
VALUES (1, 1, NOW(), 2, 'Confirmée');
INSERT INTO reservations (id_client, id_activite, date_reservation, nbr_places, status)
VALUES (2, 2, NOW(), 1, 'En_attente');
INSERT INTO reservations (id_client, id_activite, date_reservation, nbr_places, status)
VALUES (3, 3, NOW(), 4, 'Annulée');
