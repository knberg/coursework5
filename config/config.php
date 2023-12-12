<?php


define("ROOT", $_SERVER['DOCUMENT_ROOT']);
define("CONTROLLER_PATH", ROOT . "/app/controllers/");
define("MODEL_PATH", ROOT . "/app/models/");
define("VIEW_PATH", ROOT . "/app/views/");
define("TEMPLATE_PATH", ROOT . "/app/views/templates/");

define('DB_HOST', "db");
define('DB_USER', "root");
define('DB_PASS', "password");
define('DB_NAME', "booking");

define('SMTP_HOST', 'ssl://smtp.yandex.ru');
define('SMTP_PORT', 465);
define('SMTP_USERNAME', 'knberg@yandex.ru');
define('SMTP_PASSWORD', 'nfvapvszewyrwqqd');
define('SMTP_FROM', 'knberg@yandex.ru');
define('SMTP_FROM_NAME', 'TicketBooking');

date_default_timezone_set('Europe/Moscow');