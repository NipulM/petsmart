<?php 

require_once '../src/config/Database.php';
require_once '../src/models/Product.php';
require_once '../src/controllers/ProductController.php';
require_once '../src/routes/api.php';

$api = new Api();
$api->handleRequest();

?>