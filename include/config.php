<?php
// connessione a MySQL con l'estensione MySQLi
$mysqli = new mysqli("localhost", "root", "root", "rappro");
 
// verifica dell'avvenuta connessione
if (mysqli_connect_errno()) {
           // notifica in caso di errore
        echo "Errore in connessione al DB: ".mysqli_connect_error();
           // interruzione delle esecuzioni i caso di errore
        exit();
 
}