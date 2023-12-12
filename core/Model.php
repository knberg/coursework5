<?php

class Model 
{
    protected $db;
    protected $table;

    public function __constructor() 
    {
        $this->db = new Database();
    }

}

