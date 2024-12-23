<?php

namespace YakovHrebtov\bothub;

class DB
{
    private const DB_SERVER = 'wildquail.twc1.net';
    private const DB_NAME = 'telebot';
    private const DB_USER = 'dmn';
    private const DB_PASS = 'NhbVsif77';

    public static function getConnection() 
    {
        try {
            $db = new \PDO("pgsql:host=".self::DB_SERVER.";port=5432;dbname=".self::DB_NAME.";user=".self::DB_USER.";password=".self::DB_PASS);
        }
        catch (\PDOException $e) {
            echo "Не удается подключиться к БД (".self::DB_NAME."@".self::DB_SERVER."): ".$e->getMessage();
            die();
        }    

        return $db;
    }
}
#