<?php
$BASE_URL='http://'.$_SERVER['SERVER_NAME'].'/imibiko';

$LocalDb['host'] = "localhost";
$LocalDb['user'] = "root";
$LocalDb['pass'] = "root";
$LocalDb['db'] = "imibiko";

$RemoteDb['host'] = "kenjoi.com";
$RemoteDb['user'] = "imibikosql";
$RemoteDb['pass'] = "7Q6ycUuNYPhFmn7d";
$RemoteDb['db'] = "imibiko";

// connessione a MySQL con l'estensione MySQLi
$mysqli = new mysqli($LocalDb['host'], $LocalDb['user'], $LocalDb['pass'], $LocalDb['db']);
 
// verifica dell'avvenuta connessione
if (mysqli_connect_errno()) {
           // notifica in caso di errore
        echo "Errore in connessione al DB: ".mysqli_connect_error();
           // interruzione delle esecuzioni i caso di errore
        exit();
 
}


