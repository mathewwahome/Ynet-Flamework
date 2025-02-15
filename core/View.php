<?php

namespace Ynet;

class View
{
    protected $layout = 'main';
    protected $viewPath;
    protected $layoutPath;

    public function __construct()
    {
        $this->viewPath = YNET_ROOT . '/resources/views/';
        $this->layoutPath = $this->viewPath . 'layouts/';
    }

    public function render($view, $params = [])
    {
        $viewContent = $this->renderView($view, $params);
        $layoutContent = $this->renderLayout();
        
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderView($view, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        
        ob_start();
        include $this->viewPath . $view . '.php';
        return ob_get_clean();
    }

    protected function renderLayout()
    {
        ob_start();
        include $this->layoutPath . $this->layout . '.php';
        return ob_get_clean();
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}