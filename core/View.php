<?php


class View 
{
    protected $data;
    protected $errors;
    protected $template;

    public function __construct($template = null) 
    {
        $this->data = [];
        $this->errors = [];
        $this->template = $template;
    }

    public function add($key, $value) 
    {
        $this->data[$key] = $value;
    }
    
    public function error($key, $value) 
    {
        $this->errors[$key] = $value;
    }

    public function template($template) 
    {
        $this->template = $template;
    }

    public function render($title, $content) 
    {
        extract($this->data);
        include TEMPLATE_PATH . $this->template . '.php';
        exit();
    }

    public function send($data)
    {
        header('Content-Type: application/json');
        exit(json_encode($data));
    }
}