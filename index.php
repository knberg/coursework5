<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// подключение конфигурации
require_once("config/config.php");
require_once("config/helpers.php");
require_once("config/routes.php");
require_once("vendor/autoload.php");

spl_autoload_register(function ($className) {
    if (file_exists(CONTROLLER_PATH . $className . ".php")) {
        require_once (CONTROLLER_PATH . $className . ".php");
    }   
    else if (file_exists(MODEL_PATH . $className . ".php")) {
        require_once (MODEL_PATH . $className . ".php");
    } 
});

// подключение базы данных и маршрутов
require_once("core/Database.php");
require_once("core/Validator.php");
require_once("core/TicketMailer.php");

// подключение базовых классов
require_once("core/Controller.php");
require_once("core/Model.php");
require_once("core/View.php");


Router::handle($_SERVER['REQUEST_METHOD'], clearPath($_SERVER['REQUEST_URI']));