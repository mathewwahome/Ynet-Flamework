<?php

namespace Ynet\Controllers;

class mathController
{
    protected $pdo;
    
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function index()
    {
        $items = $this->pdo->query('SELECT * FROM mn')->fetchAll();
        return view('math/index', ['items' => $items]);
    }
    
    public function create()
    {
        return view('math/create');
    }
    
    public function store()
    {
        // Validation logic here
        
        $sql = 'INSERT INTO mn () 
                VALUES ()';
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($_POST));
        
        redirect('/math');
    }
    
    // Add update and delete methods
}