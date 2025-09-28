# Generators in PHP

Generators in PHP provide a powerful way to iterate through large datasets without loading everything into memory at once.
They allow you to pause a function with yield and resume later, making code efficient and elegant.
This training introduces the concept of generators, compares them with traditional approaches, and demonstrates their real-world use cases.

## Why Generators?
Traditional Functions
Use return to hand back the entire dataset at once.
All data is loaded into memory (can be expensive with large files, arrays, or database queries).
 
## Generators
Use yield to return values one at a time.
Pause execution after each yield, resuming only when the next value is requested.
Memory-friendly and scalable.

## Key Benefits
- Efficiency: Handle millions of rows or log lines without exhausting memory.
- Performance: Faster startup time since not everything is built upfront.
- Streaming: Perfect for APIs, logs, large files, and database queries.
Examples Included
This repository contains 7 examples that compare traditional array/return methods against generators with yield.

## 1. Basic Array vs Generator
- Concept: Returning a full array vs yielding values one by one.
- Array: Returns [1,2,3,4,5] in memory.
- Generator: Yields 1, then pauses. Yields 2, pauses again... until done.

## 2. Large Dataset (1 Million Numbers)
- Concept: Streaming a large dataset efficiently.
- Array: Consumes huge memory.
- Generator: Streams numbers one by one with minimal memory usage.

## 3. Resettable Counter
Concept: Generators can accept values back using $gen- >send().
Example shows a counter that can be reset to zero from outside the generator.

## 4. Reading Large Files
Concept: Process log files line- by- line instead of loading entire file.
Array (file()): Reads entire file into memory.
Generator: Streams lines using yield fgets($handle).

## 5. Streaming Database Queries
Concept: Iterate database rows without fetching everything upfront.
Array: fetchAll() loads the entire result set.
Generator: Streams rows one by one with yield $row.

## 6. Streaming API Responses
- Concept: Fetch JSON data from an API and yield products as they arrive.
- Array: Decode and return full JSON in memory.
- Generator: Yield each product row lazily.

## 7. Memory Usage Benchmark
- Concept: Compare memory consumption of arrays vs generators.
- Uses gc_collect_cycles() and memory_get_usage() to show memory difference.
- Demonstrates post- loop behavior where generators continue execution even after yielding values.

## How to Run
- Clone this repo or copy the examples.
- Make sure you are running from the CLI (not browser).
Run examples: php file's_name.php
## Live Scenarios to Try

- Replace the log file URL in Example 4 with a real server log.
- Use your company’s database in Example 5 to stream real customer rows.
- Hit a live API (e.g., DummyJSON) in Example 6 to see streaming in action.
## Key Functions Used

- yield: Pause and return a value.
- current() / next(): Resume a generator.
- send(): Pass a value into a generator.
- memory_get_usage(): Check memory consumption.
- gc_collect_cycles(): Force garbage collection before measurement.
## Training Goal

- By the end of this training, you should:
- Understand the difference between return and yield.
- Apply generators to optimize memory usage.
- Use generators in real-world scenarios: APIs, files, databases.
- Measure and prove efficiency gains with benchmarks.
