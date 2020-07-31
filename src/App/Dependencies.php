<?php

declare(strict_types=1);

use App\Handler\ApiError;
use App\Service\RedisService;

$container['db'] = static function (): PDO {
    $dbname = is_string($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : null;
    $host = is_string($_SERVER['DB_HOSTNAME']) ? $_SERVER['DB_HOSTNAME'] : null;
    $user = is_string($_SERVER['DB_USERNAME']) ? $_SERVER['DB_USERNAME'] : null;
    $pass = is_string($_SERVER['DB_PASSWORD']) ? $_SERVER['DB_PASSWORD'] : null;
    $dsn = sprintf('mysql:host=%s;dbname=%s', $host, $dbname);
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    return $pdo;
};

$container['errorHandler'] = static function (): ApiError {
    return new ApiError();
};

$container['redis_service'] = static function (): RedisService {
    return new RedisService(new \Predis\Client($_SERVER['REDIS_URL']));
};
