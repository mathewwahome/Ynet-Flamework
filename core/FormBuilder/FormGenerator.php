<?php

namespace Ynet\FormBuilder;

class FormGenerator
{
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createForm($formData)
    {
        // Create database table
        $this->createTable($formData);

        // Generate form files
        $this->generateFormFiles($formData);

        // Generate CRUD operations
        $this->generateCrud($formData);
    }

    protected function createTable($formData)
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$formData['tableName']} (
            id INT AUTO_INCREMENT PRIMARY KEY,";

        foreach ($formData['fields'] as $field) {
            $sql .= $this->getFieldSQL($field) . ",";
        }

        $sql .= "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->pdo->exec($sql);
    }

    protected function getFieldSQL($field)
    {
        switch ($field['type']) {
            case 'text':
            case 'email':
                return "{$field['name']} VARCHAR(255)" . ($field['required'] ? ' NOT NULL' : '');
            case 'textarea':
                return "{$field['name']} TEXT" . ($field['required'] ? ' NOT NULL' : '');
            case 'number':
                return "{$field['name']} INT" . ($field['required'] ? ' NOT NULL' : '');
            case 'date':
                return "{$field['name']} DATE" . ($field['required'] ? ' NOT NULL' : '');
            default:
                return "{$field['name']} VARCHAR(255)";
        }
    }


    protected function generateFormFiles($formData)
    {
        $viewsDir = YNET_ROOT . "/resources/views/forms/";
        $controllersDir = YNET_ROOT . "/resources/controllers/";

        // Ensure directories exist
        if (!is_dir($viewsDir)) {
            mkdir($viewsDir, 0777, true);
        }
        if (!is_dir($controllersDir)) {
            mkdir($controllersDir, 0777, true);
        }

        try {
            // Generate view file
            $viewContent = $this->generateViewContent($formData);
            file_put_contents($viewsDir . "{$formData['name']}.php", $viewContent);

            // Generate controller file
            $controllerContent = $this->generateControllerContent($formData);
            file_put_contents($controllersDir . "{$formData['name']}Controller.php", $controllerContent);
        } catch (\Exception $e) {
            error_log("Error generating form files: " . $e->getMessage());
        }
    }


    protected function generateViewContent($formData)
    {
        $html = "<form method='post' action='/forms/{$formData['name']}/save'>\n";

        foreach ($formData['fields'] as $field) {
            $html .= $this->generateFieldHTML($field);
        }

        $html .= "    <button type='submit'>Submit</button>\n";
        $html .= "</form>";

        return $html;
    }

    protected function generateFieldHTML($field)
    {
        $required = $field['required'] ? 'required' : '';

        switch ($field['type']) {
            case 'text':
                return "    <div class='form-group'>
                    <label>{$field['label']}</label>
                    <input type='text' name='{$field['name']}' {$required}>
                </div>\n";

            case 'textarea':
                return "    <div class='form-group'>
                    <label>{$field['label']}</label>
                    <textarea name='{$field['name']}' {$required}></textarea>
                </div>\n";

                // Add cases for other field types
        }
    }

    protected function generateControllerContent($formData)
    {
        return "<?php

namespace Ynet\Controllers;

class {$formData['name']}Controller
{
    protected \$pdo;
    
    public function __construct(\$pdo)
    {
        \$this->pdo = \$pdo;
    }
    
    public function index()
    {
        \$items = \$this->pdo->query('SELECT * FROM {$formData['tableName']}')->fetchAll();
        return view('{$formData['name']}/index', ['items' => \$items]);
    }
    
    public function create()
    {
        return view('{$formData['name']}/create');
    }
    
    public function store()
    {
        // Validation logic here
        
        \$sql = 'INSERT INTO {$formData['tableName']} (" . implode(',', array_keys($_POST)) . ") 
                VALUES (" . implode(',', array_fill(0, count($_POST), '?')) . ")';
        
        \$stmt = \$this->pdo->prepare(\$sql);
        \$stmt->execute(array_values(\$_POST));
        
        redirect('/{$formData['name']}');
    }
    
    // Add update and delete methods
}";
    }

    protected function generateCrud($formData)
    {
        // Generate list view
        $listView = $this->generateListView($formData);
        file_put_contents(
            YNET_ROOT . "/views/forms/{$formData['name']}/index.php",
            $listView
        );

        // Generate create/edit views
        $createView = $this->generateCreateView($formData);
        file_put_contents(
            YNET_ROOT . "/views/forms/{$formData['name']}/create.php",
            $createView
        );
    }
    protected function generateListView($formData)
    {
        return "<h1>{$formData['name']} List</h1>\n";
    }
    protected function generateCreateView($formData)
    {
        $html = "<h2>Create {$formData['name']}</h2>\n";
        $html .= "<form method='post' action='/forms/{$formData['name']}/store'>\n";

        foreach ($formData['fields'] as $field) {
            $html .= $this->generateFieldHTML($field);
        }

        $html .= "    <button type='submit'>Submit</button>\n";
        $html .= "</form>";

        return $html;
    }
}
