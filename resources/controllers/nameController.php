<?php

namespace Ynet\Controllers;

class nameController
{
    protected $pdo;
    
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function index()
    {
        $items = $this->pdo->query('SELECT * FROM names')->fetchAll();
        return view('name/index', ['items' => $items]);
    }
    
    public function create()
    {
        return view('name/create');
    }
    
    public function store()
    {
        // Validation logic here
        
        $sql = 'INSERT INTO names () 
                VALUES ()';
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($_POST));
        
        redirect('/name');
    }
    
    // Add update and delete methods
}