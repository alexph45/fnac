<?php

// Connection au serveur

try {

$dns = 'mysql:host=localhost;dbname=bookstruct';

$utilisateur_admin = 'admin';

$motDePasse_admin = 'admin2024';

$connection = new PDO( $dns, $utilisateur, $motDePasse );

$connection->query("SET NAMES utf8");

} catch ( Exception $e ) {

echo "Connection à MySQL impossible : ", $e->getMessage();

die();

}

?>