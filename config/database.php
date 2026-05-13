<?php
//include the connection file
include('connection.php');

//create an instance of Connection class
$connection = new Connection();

//call the createDatabase methods to create database "location"
// $connection->createDatabase('location');

$queries = [
    "CREATE TABLE client (
        id_client INT AUTO_INCREMENT PRIMARY KEY,
        num_permis VARCHAR(14) NOT NULL,
        CIN VARCHAR(8) NOT NULL,
        nom VARCHAR(50) NOT NULL,
        prenom VARCHAR(50) NOT NULL,
        adress VARCHAR(255) NOT NULL,
        telephone VARCHAR(20) NOT NULL,
        email VARCHAR(100) NOT NULL,
        Pass VARCHAR(100) NOT NULL
    )",

    "CREATE TABLE vehicule (
        ID_vehicule INT AUTO_INCREMENT PRIMARY KEY,
        immatriculation VARCHAR(15) UNIQUE NOT NULL,
        marque VARCHAR(50),
        modele VARCHAR(50),
        genre VARCHAR(50),
        type_carburant VARCHAR(50),
        tarif_du_jour DECIMAL(10,2),
        disponibilite BIT,
        categorie VARCHAR(50),
        cout_retard DECIMAL(10,2),
         image  VARCHAR(255)
    )",

    "CREATE TABLE  reservation (
        ID_reservation INT AUTO_INCREMENT PRIMARY KEY,
        date_debut DATE NOT NULL,
        date_fin DATE NOT NULL
    )",

    "CREATE TABLE contrat (
        Num_contrat INT AUTO_INCREMENT PRIMARY KEY,
        ID_reservation INT UNIQUE NOT NULL,
        date_debut DATE NOT NULL,
        date_fin DATE,
        prix_total DECIMAL(10,2),
        etat_paiement VARCHAR(50),
        FOREIGN KEY (ID_reservation) REFERENCES reservation(ID_reservation)
    )",
    "CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(150) NOT NULL
)",
"INSERT INTO vehicule (
    immatriculation, marque, modele, genre, type_carburant,
    tarif_du_jour, disponibilite, categorie, cout_retard, image
) VALUES
('AA-123-BB', 'Mitsubishi', 'Pajero', 'SUV', 'Diesel', 400.00, 1, '4x4', 20.00, '../../assets/images/car_6.jpg'),

('BB-456-CC', 'Nissan', 'Moco', 'Citadine', 'Essence', 599.00, 1, 'Compacte', 25.00, '../../assets/images/car_5.jpg'),

('CC-789-DD', 'Honda', 'Fitta', 'SUV', 'Essence', 600.00, 1, 'Premium', 30.00, '../../assets/images/car_4.jpg'),

('MZ-456-LP', 'Mazda', 'LaPuta', 'Sport', 'Essence', 990.00, 1, 'Sport', 40.00, '../../assets/images/car_2.jpg'),

('BK-789-LC', 'Buick', 'LaCrosse', 'SUV', 'Essence', 40.00, 1, 'SUV', 10.00, '../../assets/images/car_7.jpg'),

('SK-123-LA', 'Skoda', 'Laura', 'Berline', 'Essence', 700.00, 1, 'Premium', 30.00, '../../assets/images/car_3.jpg'),

('123-TUN-001', 'Toyota', 'Corolla', 'Berline', 'Essence', 120.00, 1, 'Standard', 15.00, '../../assets/images/corolla.jpg');
",
"INSERT INTO reservation (date_debut, date_fin, ID_vehicule, id_client) VALUES
('2025-12-05', '2025-12-10', 1, 1),
('2025-12-03', '2025-12-07', 2, NULL),
('2025-12-01', '2025-12-04', 3, NULL),
('2025-12-08', '2025-12-12', 4, NULL),
('2025-12-02', '2025-12-05', 5, NULL),
('2025-12-06', '2025-12-09', 6, NULL),
('2025-12-04', '2025-12-08', 1, NULL),
('2025-12-07', '2025-12-11', 2, NULL),
('2025-12-09', '2025-12-15', 3, NULL),
('2025-12-10', '2025-12-13', 4, NULL),

('2025-01-10', '2025-01-14', 3, 1),
('2025-01-15', '2025-01-18', 1, 2),

('2025-02-01', '2025-02-05', 5, 3),
('2025-02-10', '2025-02-12', 2, 4),
('2025-03-01', '2025-03-07', 7, 5),
('2025-03-15', '2025-03-18', 4, 6),

('2025-05-10', '2025-05-12', 6, 10);
",
"INSERT INTO contrat (ID_reservation, date_debut, date_fin, prix_total, etat_paiement) VALUES
(1, '2025-01-10', '2025-01-14', 480.00, 'Payé'),
(2, '2025-01-15', '2025-01-18', 360.00, 'Non payé'),
(3, '2025-02-01', '2025-02-05', 800.00, 'Payé'),
(4, '2025-02-10', '2025-02-12', 250.00, 'Payé'),
(5, '2025-03-01', '2025-03-07', 900.00, 'Non payé'),
(6, '2025-03-15', '2025-03-18', 450.00, 'Payé'),
(7, '2025-04-01', '2025-04-04', 360.00, 'Payé'),
(8, '2025-04-10', '2025-04-15', 750.00, 'Non payé'),
(9, '2025-05-01', '2025-05-03', 270.00, 'Payé'),
(10, '2025-05-10', '2025-05-12', 320.00, 'Payé');
",
"INSERT INTO client (num_permis, CIN, nom, prénom, adress, téléphone, email, Pass) VALUES
('PERM12345', 'AB123456', 'El Mansouri', 'Sara', 'Rabat, Maroc', '0612345678', 'sara.mansouri@gmail.com',
'$2y$10$eBzXJ1FxE4p0pGBHqHh9r.OFJtC2KXJ8xTW1Ijq7Kf6UvR0wS6gya'),

('PERM98765', 'CD789012', 'Bennani', 'Youssef', 'Casablanca, Maroc', '0623456789', 'youssef.bennani@gmail.com',
'$2y$10$fJ3pwuCckmFJjESxuoG1HuDk5Xn4yoF1n4gZQ2OoKQOqOMbH1tW1C'),

('PERM45678', 'EF345678', 'Haddad', 'Imane', 'Marrakech, Maroc', '0634567890', 'imane.haddad@gmail.com',
'$2y$10$z0J/5aA0VjJkOFx8gzi8lu1pO2tM7y9Gqv2VJQykrKN9GQ3wIp6lK'),

('PERM11223', 'GH901234', 'Alaoui', 'Rachid', 'Fès, Maroc', '0645678901', 'rachid.alaoui@gmail.com',
'$2y$10$1T8Fq4Dk7JExqzM6O7uUHeLrYyqM0X5sQYQ9zdDEKXOFpp4QpV1n6'),

('PERM33445', 'JK567890', 'Touhami', 'Nadia', 'Agadir, Maroc', '0656789012', 'nadia.touhami@gmail.com',
'$2y$10$9FQGbW1lFf4vdIjZf3W76uc.E5XpehVw36AATbR9T6XW8a5J6sT7C');
",
"INSERT INTO admin (nom, email, mot_de_passe) VALUES
('Hajar', 'hajar.admin@site.com',
'$2y$10$9eup0Zb6Vj8FkS9WOQ6I7u8nWkzH/7zYH/ed1qj0ti6dhtl8Qm8du'),

('Karim', 'karim.admin@site.com',
'$2y$10$VY1O9a2Jz9kZlN9Hf0CT2eYpPp9QFxf4GK8HkVZk9AqvGJm7if27i'),

('Sara', 'sara.admin@site.com',
'$2y$10$G5h0ly2/2x2Hzy3mXeF2vOx2yRt8UuR3jM7h0TnS8oMZq1sIYkK6y'),

('Amine', 'amine.admin@site.com',
'$2y$10$F3s7aR4tSe9X0h0TtNq.1Oo8KLlNzF3PwY4XnE0L9A2mxz5fq1R3C'),

('Rania', 'rania.admin@site.com',
'$2y$10$o9D4sU8gYy7QvHnJdU1a5eXc2PpQ8w7lF6JqM2Uqz5BvHnLxX1gEa'),

('Yassine', 'yassine.admin@site.com',
'$2y$10$Jk4dF8wL3mQh9PzB7tN0xOt7HrWwK1pFqE0bNs1LjT7Mq9c0Z3MI6'),

('Marie', 'marie.admin@site.com',
'$2y$10$0qH8mT2eYs3VkR6LjY1U8.iwF8vM2sQeB7OqT9rHk4pS6zVtXf2Gm'),

('Samir', 'samir.admin@site.com',
'$2y$10$sAyU7Kf2Vt3PzJ4LmQ1d7qWzZy6UvP8rTqE5Hf6GbB3LnX8OpM1F6'),

('Fatima', 'fatima.admin@site.com',
'$2y$10$U8eQ4pA5vK2RwN7LmP0yYumXy6WgP0dCfB3qF5hJzL9NpE2WtQx1O'),

('Adam', 'adam.admin@site.com',
'$2y$10$P7hE3sQwU6nL9mP0yB1gYtXfCvP2wDqH0F5lS8hJrK7OuE2DzQ0Ga');
"

];




//call the selectDatabase method to select the chap4Db
$connection->selectDatabase('location');

//call the createTable method to create table with the $query
$connection->createTable($queries);


?>
