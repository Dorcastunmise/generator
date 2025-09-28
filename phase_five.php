<?php
include 'format.php';
$pdo = new PDO("mysql:host=localhost;dbname=misc", "root", "");
//Traditional way:

$users = $pdo->query("SELECT * FROM users")->fetchAll();
foreach ($users as $c) {
    echo $c['surName'] . PHP_EOL;
    echo "Memory after building array: " . formatMB(memory_get_usage(true)) . PHP_EOL;
    echo "-------------------------" . PHP_EOL;
}

// Generator for streaming DB rows
function getUsers($pdo) {
    $stmt = $pdo->query("SELECT ID, surName, email FROM users");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        yield $row;
    }
}

foreach (getUsers($pdo) as $i => $customer) {
    if ($i < 5) {
        echo "Customer: {$customer['ID']} - {$customer['surName']} ({$customer['email']})" . PHP_EOL;
        echo "Memory used while streaming generator: " . formatMB(memory_get_usage(true)) . PHP_EOL;
        echo "-------------------------" . PHP_EOL;
    } else {
        break;
    }
}
