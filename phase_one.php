<?php
ini_set('memory_limit', '512M');

// Build array
function getArrayRange($limit) {
    $numbers = [];
    for ($i = 1; $i <= $limit; $i++) {
        $numbers[] = str_repeat("X", 1000); // make each item 1KB
    }
    return $numbers;
}

// Generator
function getGeneratorRange($limit) {
    for ($i = 1; $i <= $limit; $i++) {
        yield str_repeat("X", 1000);
    }
}

// -----------------------
// ARRAY TEST
// -----------------------
$limit = 200000;
echo "=== ARRAY ===" . PHP_EOL;

$array = getArrayRange($limit);
echo "Memory after creating array: " . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL;

$count = 0;
foreach ($array as $item) {
    $count++;
    if ($count % 50000 === 0) {
        echo "Processed $count items, memory: " . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL;
    }
}

echo PHP_EOL;

// -----------------------
// GENERATOR TEST
// -----------------------
echo "=== GENERATOR ===" . PHP_EOL;

$gen = getGeneratorRange($limit);
$count = 0;
foreach ($gen as $item) {
    $count++;
    if ($count % 50000 === 0) {
        echo "Processed $count items, memory: " . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL;
    }
}
