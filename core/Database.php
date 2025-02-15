<?php

namespace Ynet;

class Database
{
    protected static $instance = null;
    
    public static function getInstance(array $config)
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                "%s:host=%s;dbname=%s;charset=%s",
                $config['driver'],
                $config['host'],
                $config['database'],
                $config['charset']
            );
            
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            try {
                self::$instance = new \PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $options
                );
            } catch (\PDOException $e) {
                throw new \Exception("Database connection failed: " . $e->getMessage());
            }
        }
        
        return self::$instance;
    }
}