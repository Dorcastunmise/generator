<?php
// Bad practice: using arrays for massive data
$data = range(1, 1000000); 

echo "Loaded " . count($data) . " items" . PHP_EOL;
echo "Memory usage after loading data: " . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL;

