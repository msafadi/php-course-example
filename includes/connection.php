<?php

$config = include __DIR__ . '/config.php';
$database = $config['database'];

$dsn = "mysql:host={$database['host']};port={$database['port']};dbname={$database['schema']}";

$db = new PDO($dsn, $database['username'], $database['password']);