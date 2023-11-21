<?php

namespace iutnc\hellokant\factory;
use Exception;
use PDO;

class ConnectionFactory
{
    private static $pdo;
    public static function makeConnection(array $conf){
        $dsn = "mysql:host={$conf['host']};dbname={$conf['dbname']};charset={$conf['charset']}";
        $pdo = new PDO($dsn, $conf['user'], $conf['password']);
        $pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
        return self::$pdo = $pdo;
    }

    public static function getConnection(){
        return self::$pdo ?? new Exception("Connection not initialized");
    }


}