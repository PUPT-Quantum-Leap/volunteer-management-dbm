<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $q = $pdo->query('SHOW DATABASES');
    foreach ($q as $row) {
        echo $row[0].PHP_EOL;
    }
} catch (Exception $e) {
    echo 'ERR: '.$e->getMessage().PHP_EOL;
}
