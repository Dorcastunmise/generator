<?php
include 'format.php';

//Traditional way (bad):
function readLogFileTraditional($filename) {
    $handle = fopen($filename, "r");
    if (!$handle) {
        throw new Exception("Cannot open file: $filename");
    }
    
    $lines = []; // build the full array
    while (!feof($handle)) {
        $lines[] = fgets($handle);
    }
    fclose($handle);
    
    return $lines; // return entire array at once
}

// Usage
foreach (readLogFileTraditional("https://norvig.com/big.txt") as $i => $line) {
    if ($i >= 10 && $i <= 14) {
        echo "[RETURN] Line " . ($i + 1) . ": " . trim($line) . PHP_EOL;
        echo "Memory after building array: " . formatMB(memory_get_usage(true)) . PHP_EOL;
        echo "-------------------------" . PHP_EOL;
    }
    if ($i > 14) {
        break;
    }
}

//Better way (using generator):

function readLogFile($filename) {
    $handle = fopen($filename, "r");
    if (!$handle) {
        throw new Exception("Cannot open file: $filename");
    }
    while (!feof($handle)) {
        yield fgets($handle);
    }
    fclose($handle);
}

foreach (readLogFile("https://norvig.com/big.txt") as $i => $line) { //$i is line number starting from 0 and $line is the content of that line
    // Process each line as needed
    // Just print lines 11 to 15 as a demo
     if ($i >= 10 && $i <= 14) {
        echo "Line " . ($i + 1) . ": " . trim($line) . PHP_EOL;
        echo "Memory used while streaming generator: " . formatMB(memory_get_usage(true)) . PHP_EOL;
        echo "-------------------------" . PHP_EOL;
    }
    if ($i > 14) {
        break;
    }
}
