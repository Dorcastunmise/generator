<?php
function fetchApi($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // disable SSL verify for dev
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);

    if ($result === false) {
        throw new Exception("cURL Error: " . curl_error($ch));
    }

    curl_close($ch);
    return $result;
}

function getProductsFromApi($url) {
    $json = fetchApi($url);
    $data = json_decode($json, true);
    if (!is_array($data)) {
        throw new Exception("Invalid JSON data from API");
    }

    // Some APIs (DummyJSON) have products inside a key
    if (isset($data['products'])) {
        foreach ($data['products'] as $product) {
            yield $product;
        }
    } else {
        foreach ($data as $product) {
            yield $product;
        }
    }
}

// Demo
$url = "https://dummyjson.com/products";
$count = 0;
try {
    foreach (getProductsFromApi($url) as $product) {
        if ($count++ < 5) {
            echo "Product {$product['id']}: {$product['title']} - Price: {$product['price']}" . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
