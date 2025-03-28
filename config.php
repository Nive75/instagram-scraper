<?php
// Paramètres de connexion
$host = 'ps20975-001.eu.clouddb.ovh.net';
$port = '35862';
$dbname = 'jeff_test';
$username = 'jeff_test';
$password = '5NnpDGkpTfF6G9s6';

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
