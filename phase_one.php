<?php

// Example 1: Normal Function with Array
// -------------------------------

// A regular function that returns an array.
function getNumbersArray() {
    // The function builds the entire array in memory.
    // At this moment, PHP creates an array [1, 2, 3, 4, 5].
    // That whole array is stored in memory before the function ends.
    return [1, 2, 3, 4, 5]; 
    // Once 'return' is executed, the function is finished.
    // You cannot come back and ask it for more values.
}

// -------------------------------
// Example 2: Generator Function
// -------------------------------

// A generator function looks almost the same,
// but instead of 'return' we use 'yield'.
function getNumbersGenerator() {
    // When PHP hits 'yield', it gives back the value
    // BUT it does not end the function completely.
    // It "pauses" here and remembers where it left off.
    
    yield 1; // Think of this as: "Here is 1, but keep my place open."
    
    yield 2; // Resume from here next time: "Here is 2, still not done yet."
    
    yield 3; // And again: "Here is 3, waiting for you to ask for more."
    
    yield 4; // Continue: "Here is 4."
    
    yield 5; // Last one: "Here is 5."
    
    // After this last yield, there are no more instructions.
    // At this point, the generator is finished.
}

// -------------------------------
// How They Behave Differently
// -------------------------------

echo "Using Array Function:" . PHP_EOL;
foreach (getNumbersArray() as $num) {
    // Because getNumbersArray() returns the FULL array,
    // PHP loads the entire [1, 2, 3, 4, 5] into memory at once.
    echo $num . PHP_EOL;
    echo "Memory usage after loading data: " . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL;
    echo "-------------------------" . PHP_EOL;
}

echo PHP_EOL . "Using Generator Function:" . PHP_EOL;
foreach (getNumbersGenerator() as $num) {
    // Here, PHP calls getNumbersGenerator().
    // The function does not give back all values at once.
    // Instead:
    //   - First loop iteration: yields 1 and pauses.
    //   - Second iteration: resumes, yields 2 and pauses.
    //   - This continues until 5, then it ends.
    // Memory usage is tiny because nothing is pre-stored.
    echo $num . PHP_EOL;
    echo "Memory usage after loading data: " . (memory_get_usage(true) / 1024 / 1024) . " MB" . PHP_EOL;
    echo "-------------------------" . PHP_EOL;
}


