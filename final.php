<?php
// generator_memory_demo.php
// Run with: php generator_memory_demo.php
// Make sure to run in CLI. The script increases memory_limit so you can test safely.
include 'format.php';

ini_set('memory_limit', '1024M'); // increase limit for the test

function buildLargeArray(int $limit, int $size): array {
    $chunk = str_repeat('A', $size);
    $arr = [];
    for ($i = 1; $i <= $limit; $i++) {
        $arr[] = $chunk . $i;
    }
    return $arr;
}

function generateLargeStrings(int $limit, int $size): Generator {
    $chunk = str_repeat('A', $size);
    for ($i = 1; $i <= $limit; $i++) {
        yield $chunk . $i;
    }
}

function generatorWithPostLoop(int $limit): Generator {
    for ($i = 1; $i <= $limit; $i++) {
        yield "Item $i";
    }

    echo ">>> Generator finished loop, now running post-loop code" . PHP_EOL;
    yield "FINAL VALUE";
}

// ----------------------------------------------------------
// CONFIGURATION
// ----------------------------------------------------------
ini_set('memory_limit', '1024M'); //setting memory limit to 1GB for testing purposes
$limit = 50000;   // total items
$size  = 1024;    // each string = 1 KB

// ----------------------------------------------------------
// TEST 1: Array vs Generator Memory Usage
// ----------------------------------------------------------
gc_collect_cycles();
echo PHP_EOL . "=== MEMORY TEST (Array vs Generator) ===" . PHP_EOL;

// --- Array Test ---
echo PHP_EOL . "[Array] Building {$limit} items of {$size} bytes each..." . PHP_EOL;
$start = memory_get_usage(true);
$array = buildLargeArray($limit, $size);
echo "[Array] Memory increase: " . formatMB(memory_get_peak_usage(true) - $start) . PHP_EOL;

echo "[Array] Iterating only first 5 items..." . PHP_EOL;
foreach ($array as $i => $v) {
    if ($i >= 5) break;
}
echo "[Array] Peak memory: " . formatMB(memory_get_peak_usage(true)) . PHP_EOL;

unset($array);
gc_collect_cycles();

// --- Generator Test ---
echo PHP_EOL . "[Generator] Streaming same data, but stopping after 5 items..." . PHP_EOL;
$startGen = memory_get_usage(true);
foreach (generateLargeStrings($limit, $size) as $i => $v) {
    if ($i >= 5) break;
}
echo "[Generator] Memory increase: " . formatMB(memory_get_peak_usage(true) - $startGen) . PHP_EOL;

// ----------------------------------------------------------
// TEST 2: Generator Post-Loop Behavior
// ----------------------------------------------------------
echo PHP_EOL . "=== GENERATOR POST-LOOP BEHAVIOR ===" . PHP_EOL;
foreach (generatorWithPostLoop(3) as $val) {
    echo "Got: $val" . PHP_EOL;
}

echo PHP_EOL . "=== End of Demo ===" . PHP_EOL;