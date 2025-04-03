<?php
// Connexion à la base de données
try {
    $host = 'ps20975-001.eu.clouddb.ovh.net';
    $port = '35862';
    $dbname = 'jeff_test';
    $db_username = 'jeff_test';
    $password = '5NnpDGkpTfF6G9s6';
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $db_username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer l'historique des recherches
    $stmt = $pdo->query("SELECT * FROM recherches ORDER BY date_recherche DESC");
    $recherches = $stmt->fetchAll();

    if ($recherches) {
        echo "<h2>Historique des recherches</h2>";
        echo "<ul>";
        foreach ($recherches as $recherche) {
            echo "<li><strong>" . htmlspecialchars($recherche['username']) . "</strong> - " . $recherche['date_recherche'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune recherche enregistrée.";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

