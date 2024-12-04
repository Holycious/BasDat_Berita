<?php
require '../vendor/autoload.php'; // Pastikan Anda menginstal MongoDB PHP Library

function connectMongoDB() {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    return $client->webberita->news; // news_database adalah nama database, dan news adalah koleksi
}
?>
