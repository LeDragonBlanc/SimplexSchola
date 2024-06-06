<?php
require 'vendor/autoload.php'; // Charger l'autoloader de Composer

use MongoDB\Client as MongoClient;

header('Content-Type: application/json');

// Connexion à MongoDB
$mongoClient = new MongoClient("mongodb://localhost:27017");

// Sélection de la base de données et de la collection
$database = $mongoClient->selectDatabase('groupe_etude');
$collection = $database->selectCollection('groupes');

// Récupération des données POST
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['groupName']) && isset($input['description']) && isset($input['subjects'])) {
    $groupName = $input['groupName'];
    $description = $input['description'];
    $subjects = $input['subjects'];

    // Insertion des données dans MongoDB
    $result = $collection->insertOne([
        'groupName' => $groupName,
        'description' => $description,
        'subjects' => $subjects
    ]);

    if ($result->getInsertedCount() === 1) {
        echo json_encode(['message' => 'Groupe créé avec succès']);
    } else {
        echo json_encode(['error' => 'Erreur lors de la création du groupe']);
    }
} else {
    echo json_encode(['error' => 'Données de formulaire invalides']);
}
?>
