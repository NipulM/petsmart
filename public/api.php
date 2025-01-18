<?php 

require_once '../src/config/Database.php';

require_once '../src/models/Product.php';
require_once '../src/controllers/ProductController.php';

require_once '../src/models/Category.php';
require_once '../src/controllers/CategoryController.php';

require_once '../src/models/Blog.php';
require_once '../src/controllers/BlogController.php';

require_once '../src/models/User.php';
require_once '../src/controllers/UserController.php';

require_once '../src/models/Order.php';
require_once '../src/controllers/OrderController.php';

require_once '../src/models/Subscription.php';
require_once '../src/controllers/SubscriptionController.php';

require_once '../src/routes/api.php';

$api = new Api();
$api->handleRequest();


?>