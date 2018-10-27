<?php
// Définition des informations de connexion à la base de données
define('HOST', 'localhost');
define('LOGIN', 'fabienlamotte');
define('PASSWORD', 'Platinum#00');
define('DBNAME', 'mermaid');
// Ajout des fichiers nécessaire au bon fonctionnement du site
include 'class/database.php';
include 'models/users.php';
include 'models/cities.php';
include 'models/type.php';