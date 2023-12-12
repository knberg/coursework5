<?php 

class Route 
{
    public $path;
    public $pattern;
    public $params;
    public $handler;
    public $filters;

    public function __construct($path, $pattern, $params, $handler)
    {
        $this->path = $path;
        $this->pattern = $pattern;
        $this->params = $params;
        $this->handler = $handler;
        $this->filters = [];
    }

    public function match($path) 
    {
        return preg_match($this->pattern, $path);
    }

    public function extractParameters($path)
    {
        if (preg_match($this->pattern, $path, $matches)) {
            $params = [];
            foreach ($this->params as $i => $param) {
                $params[$param] = $matches[$i + 1];
            }
            return $params;
        }
    }

    public function filter($filters) 
    {
        if (is_string($filters)) {
            $this->filters[] = $filters;
        } else {
            $this->filters = array_merge($this->filters, $filters);
        }
    }
}