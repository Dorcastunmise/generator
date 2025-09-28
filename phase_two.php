<?php
// Compare Array vs Generator memory usage

ini_set('memory_limit', '512M'); // Just in case

function buildLargeArray($limit) {
    $arr = [];
    for ($i = 1; $i <= $limit; $i++) {
        $arr[] = $i;
    }
    return $arr;
}

function generateLargeNumbers($limit) {
    for ($i = 1; $i <= $limit; $i++) {
        yield $i;
    }
}

function formatMB($bytes) {
    return number_format($bytes / 1024 / 1024, 2) . " MB";
}

$limit = 1000000; // 1 million numbers

echo "=== ARRAY TEST ===" . PHP_EOL;
$start = memory_get_usage(true);
echo "Memory before building array: " . formatMB(memory_get_usage(true) - $start) . PHP_EOL;
$array = buildLargeArray($limit);
echo "Memory after building array: " . formatMB(memory_get_usage(true) - $start) . PHP_EOL;

for ($i = 0; $i < 5; $i++) {
    echo $array[$i] . PHP_EOL;
}

unset($array);
$collected = gc_collect_cycles();
echo "Collected $collected cycles" . PHP_EOL;


echo PHP_EOL . "=== GENERATOR TEST ===" . PHP_EOL;
$start = memory_get_usage(true);
$count = 0;
foreach (generateLargeNumbers($limit) as $num) {
    if ($count++ < 5) {
        echo $num . PHP_EOL;
    } else {
        break; // stop early to show memory difference
    }
}
echo "Memory used while streaming generator: " . formatMB(memory_get_usage(true) - $start) . PHP_EOL;
