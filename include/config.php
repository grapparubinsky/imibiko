<?php
$BASE_URL='http://'.$_SERVER['SERVER_NAME'].'/imibiko';

$LocalDb['host'] = "localhost";
$LocalDb['user'] = "root";
$LocalDb['pass'] = "root";
$LocalDb['db'] = "imibiko";

$RemoteDb['host'] = "kenjoi.com";
$RemoteDb['user'] = "imibikosql";
$RemoteDb['pass'] = "tnAtYKbWzjzdNL6q";
$RemoteDb['db'] = "imibiko";

// connessione a MySQL con l'estensione MySQLi
$mysqli = new mysqli("localhost", "root", "root", "imibiko");
 
// verifica dell'avvenuta connessione
if (mysqli_connect_errno()) {
           // notifica in caso di errore
        echo "Errore in connessione al DB: ".mysqli_connect_error();
           // interruzione delle esecuzioni i caso di errore
        exit();
 
}


