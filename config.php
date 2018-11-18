<?php
// Définition des informations de connexion à la base de données
define('HOST', 'localhost');
define('LOGIN', 'fabienlamotte');
define('PASSWORD', 'Platinum#00');
define('DBNAME', 'mermaid');
// Ajout des fichiers nécessaire au bon fonctionnement du site
include 'class/database.php';
include 'models/users.php';
include 'models/userPhotos.php';
include 'models/cities.php';
include 'models/type.php';
include 'models/band.php';
include 'models/bandPhotos.php';
include 'models/members.php';
include 'models/notifications.php';
include 'models/establishment.php';
include 'models/proPhotos.php';
include 'models/typeInstrument.php';
include 'models/instrument.php';
include 'models/contract.php';
include 'models/establishmentInResearch.php';
include 'models/musicianInResearch.php';
include 'models/bandInResearch.php';
include 'models/messages.php';