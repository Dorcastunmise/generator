<?php
//Traditional way (bad):

$lines = file($filename); // loads ALL lines into memory
foreach ($lines as $line) {
    echo $line;
}

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

foreach (readLogFile("https://norvig.com/big.txt") as $i => $line) {
     if ($i >= 10 && $i <= 14) {
        echo "Line " . ($i + 1) . ": " . trim($line) . PHP_EOL;
    }
    if ($i > 14) {
        break;
    }
}
