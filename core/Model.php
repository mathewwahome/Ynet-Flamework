<?php

namespace Ynet;

abstract class Model
{
    protected static $table;
    protected static $primaryKey = 'id';
    protected $attributes = [];
    
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }
    
    public static function getTable()
    {
        return static::$table;
    }
    
    public static function find($id, Database $db)
    {
        $table = static::getTable();
        $primaryKey = static::$primaryKey;
        
        $result = $db->select("SELECT * FROM {$table} WHERE {$primaryKey} = ?", [$id]);
        
        if (!empty($result)) {
            return new static($result[0]);
        }
        
        return null;
    }
    
    public static function all(Database $db)
    {
        $table = static::getTable();
        $results = $db->select("SELECT * FROM {$table}");
        
        $models = [];
        foreach ($results as $result) {
            $models[] = new static($result);
        }
        
        return $models;
    }
    
    public function save(Database $db)
    {
        $table = static::getTable();
        
        if (isset($this->attributes[static::$primaryKey])) {
            // Update existing record
            // ...
        } else {
            // Create new record
            $id = $db->insert($table, $this->attributes);
            $this->attributes[static::$primaryKey] = $id;
        }
        
        return $this;
    }
    
    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }
    
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}