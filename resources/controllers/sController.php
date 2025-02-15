<?php

namespace Ynet\Controllers;

class sController
{
    protected $pdo;
    
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function index()
    {
        $items = $this->pdo->query('SELECT * FROM sx')->fetchAll();
        return view('s/index', ['items' => $items]);
    }
    
    public function create()
    {
        return view('s/create');
    }
    
    public function store()
    {
        // Validation logic here
        
        $sql = 'INSERT INTO sx () 
                VALUES ()';
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($_POST));
        
        redirect('/s');
    }
    
    // Add update and delete methods
}