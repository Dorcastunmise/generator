<?php
$pdo = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
//Traditional way:

$customers = $pdo->query("SELECT * FROM customers")->fetchAll();
foreach ($customers as $c) {
    echo $c['name'] . PHP_EOL;
}

// Generator for streaming DB rows
function getCustomers($pdo) {
    $stmt = $pdo->query("SELECT id, name, email FROM customers");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        yield $row;
    }
}

foreach (getCustomers($pdo) as $i => $customer) {
    if ($i < 5) {
        echo "Customer: {$customer['id']} - {$customer['name']} ({$customer['email']})" . PHP_EOL;
    } else {
        break;
    }
}
