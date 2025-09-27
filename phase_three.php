<?php

/*
    Advanced Generator: Resettable Counter

Generators can also accept values back from the loop:

*/

function counter() {
    $i = 0;
    while (true) {
        $reset = yield $i;
        if ($reset) {
            $i = 0;
        } else {
            $i++;
        }
    }
}

$gen = counter();
echo $gen->current() . PHP_EOL;   
echo $gen->send(false) . PHP_EOL; 
echo $gen->send(false) . PHP_EOL; 
echo $gen->send(true) . PHP_EOL;  
