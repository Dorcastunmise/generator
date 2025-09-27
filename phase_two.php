<?php
function generateLargeNumbers($limit) {
    for ($i = 1; $i <= $limit; $i++) {
        yield $i;
    }
}

// Stream 1 million numbers
$count = 0;
foreach (generateLargeNumbers(1000000) as $num) {
    echo "Memory usage before array streaming: " . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL;

    if ($count++ < 5) {
        echo "Streaming: $num" . PHP_EOL;
        echo "Memory usage after array streaming: " . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL;
    }

}

echo "-------------------------" . PHP_EOL;

$yield_set = generateLargeNumbers(10);
foreach ($yield_set as $val) {
    echo "From yield_set: $val" . PHP_EOL;
    echo "Memory usage after yieldstreaming: " . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL;
}


