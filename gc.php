<?php

    class Node {
        public $next;
    }

    $a = new Node();
    $b = new Node();

    $a->next = $b;
    $b->next = $a;

    // Now $a and $b reference each other forever
    unset($a, $b);

    // Memory is still held unless GC runs
    $collected = gc_collect_cycles();
    echo "Collected $collected cycles" . PHP_EOL;
