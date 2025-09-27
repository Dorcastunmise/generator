<?php
// generator_memory_demo.php
// Run with: php generator_memory_demo.php
// Make sure to run in CLI. The script increases memory_limit so you can test safely.

ini_set('memory_limit', '1024M'); // increase limit for the test

// Helper: format bytes to human readable MB with two decimals
function formatMB(int $bytes): string {
    return number_format($bytes / 1024 / 1024, 2) . ' MB';
}

// Build a large array where each element is a string of $size bytes
function buildLargeArray(int $limit, int $size): array {
    $chunk = str_repeat('A', $size);
    $arr = [];
    for ($i = 1; $i <= $limit; $i++) {
        // Concatenate index so values are unique and not shared by copy-on-write
        $arr[] = $chunk . (string)$i;
    }
    return $arr;
}

// Generator that yields the same large strings one by one
function generateLargeStrings(int $limit, int $size): Generator {
    $chunk = str_repeat('A', $size);
    for ($i = 1; $i <= $limit; $i++) {
        yield $chunk . (string)$i;
    }
}

// Small generator to demonstrate code after the loop executes
function generatorWithPostLoop(int $limit): Generator {
    for ($i = 1; $i <= $limit; $i++) {
        yield "Item $i";
    }

    // This echo is executed only when the generator runs past the loop.
    // It demonstrates the function continues executing after yields.
    echo ">>> Inside generator: finished loop, running post-loop code" . PHP_EOL;

    // You can yield additional values after the loop
    yield "FINAL";
}

// -------- MEMORY TEST: Array vs Generator (partial iteration) --------
$limit = 50000;     // number of items. Adjust up or down depending on your machine.
$size  = 1024;      // bytes per string (1 KB). Adjust to enlarge memory footprint.

// Clear possible garbage
gc_collect_cycles();
sleep(1);

echo PHP_EOL . "=== MEMORY TEST (partial iteration) ===" . PHP_EOL;

// -------- Array test --------
echo PHP_EOL . "[Array] Building array of {$limit} items, each {$size} bytes..." . PHP_EOL;
gc_collect_cycles();
$start = memory_get_usage(true);

// Build the array - this allocates memory for all elements at once
$array = buildLargeArray($limit, $size);

// Memory used after creation (peak will include the allocation)
$peakAfterArray = memory_get_peak_usage(true);
echo "[Array] Memory used after creation (peak - baseline): " . formatMB($peakAfterArray - $start) . PHP_EOL;
echo "[Array] Global peak memory so far: " . formatMB(memory_get_peak_usage(true)) . PHP_EOL;

// Iterate but stop early - note array was still fully allocated in memory
echo "[Array] Iterating array but stopping after 5 items..." . PHP_EOL;
foreach ($array as $i => $v) {
    if ($i >= 5) break;
}
echo "[Array] Peak memory after iterating: " . formatMB(memory_get_peak_usage(true)) . PHP_EOL;

// Free array and collect garbage
unset($array);
gc_collect_cycles();
sleep(1);

// -------- Generator test --------
echo PHP_EOL . "[Generator] Streaming (generator) the same data, stopping after 5 items..." . PHP_EOL;
gc_collect_cycles();
$startGen = memory_get_usage(true);
foreach (generateLargeStrings($limit, $size) as $i => $v) {
    if ($i >= 5) break; // we stop early to show generator did not allocate the whole dataset
}
$peakAfterGen = memory_get_peak_usage(true);
echo "[Generator] Peak memory during partial iteration (peak - baseline): " . formatMB($peakAfterGen - $startGen) . PHP_EOL;
echo "[Generator] Global peak memory so far: " . formatMB(memory_get_peak_usage(true)) . PHP_EOL;

// Free and GC
gc_collect_cycles();
sleep(1);

// -------- Demonstrate generator continues after yields --------
echo PHP_EOL . "=== GENERATOR POST-LOOP DEMONSTRATION ===" . PHP_EOL;
echo "Iterating generatorWithPostLoop(3) to the end:" . PHP_EOL;
foreach (generatorWithPostLoop(3) as $val) {
    echo "Got: $val" . PHP_EOL;
}

echo PHP_EOL . "Script finished." . PHP_EOL;
