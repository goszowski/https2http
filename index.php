<?php

$destinationUrl = 'http://127.0.0.1:8000'; // Поставити правильний хост

$requestUri = $_SERVER['REQUEST_URI'];
$payload = file_get_contents('php://input');

// Ініціалізація курла
$request = curl_init($destinationUrl . $requestUri);

curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
curl_setopt($request, CURLINFO_HEADER_OUT, true);
curl_setopt($request, CURLOPT_POST, true);
curl_setopt($request, CURLOPT_POSTFIELDS, $payload);

// Загловки
curl_setopt($request, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload),
    'Authorization: ' . getallheaders()['Authorization'] ?? null,
]);

// Виконання запиту до ресурсу
$result = curl_exec($request);

// Ставиться http статус
http_response_code(curl_getinfo($request)['http_code']);

// Закриття коннекту
curl_close($request);

echo $result;