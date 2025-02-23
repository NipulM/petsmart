<?php
class Api {
    private $productController;
    private $categoryController;
    private $blogController;
    private $userController;
    private $orderController;
    private $subscriptionController;

    public function __construct() {
        $this->productController = new ProductController();
        $this->categoryController = new CategoryController();
        $this->blogController = new BlogController();
        $this->userController = new UserController();
        $this->orderController = new OrderController();
        $this->subscriptionController = new SubscriptionController();
    }

    public function handleRequest() {
        header('Content-Type: application/json');

        $requestURI = $_SERVER['REQUEST_URI'];
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $requestPath = parse_url($requestURI, PHP_URL_PATH);
        $requestURL = trim(str_replace($scriptName, '', $requestPath), '/');

        switch ($requestURL) {
            case 'get-new-products':
                echo json_encode($this->productController->getNewProducts());
                break;

            case 'update-order-status':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->orderController->updateOrderStatus($data));
                break;

            case 'get-blog-by-id':
                if (isset($_GET['id'])) {
                    echo json_encode($this->blogController->getBlogById(intval($_GET['id'])));
                }
                break;

            case 'get-all-orders':
                echo json_encode($this->orderController->getAll());
                break;

            case 'get-admin-dashboard-stats':
                echo json_encode($this->userController->getAdminDashboardStats());
                break;

            case 'get-user-orders':
                echo json_encode($this->orderController->getUserOrders());
                break;

            case 'place-order':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->orderController->placeOrder($data));
                break;

            case 'update-user-profile':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->userController->updateUserProfile($data));
                break;

            case 'user-profile':
                echo json_encode($this->userController->getUserProfile());
                break;

            case 'admin-login':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->userController->adminLogin($data));
                break;

            case 'validate-token':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->userController->validateToken($data));
                break;

            case 'login':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->userController->loginUser($data));
                break;

            case 'register':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->userController->registerUser($data));
                break;

            case 'get-all-products':
                echo json_encode($this->productController->getAllProducts());
                break;

            case 'get-product-by-id':
                if (isset($_GET['id'])) {
                    echo json_encode($this->productController->getProductById(intval($_GET['id'])));
                }
                break;

            case 'save-product':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->productController->saveProduct($data));
                break;

            case 'save-blog':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->blogController->saveBlog($data));
                break;

            case 'add-category':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->categoryController->createNewCategory($data));
                break;

            case 'update-product':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['id'])) {
                    echo json_encode($this->productController->updateProduct($data['id'], $data));
                }
                break;

            case 'delete-product':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['id'])) {
                    echo json_encode($this->productController->deleteProduct($data['id']));
                }
                break;

            case 'filter-products':
                echo json_encode($this->productController->filterProducts());
                break;

            case 'get-all-categories':
                echo json_encode($this->categoryController->getAllCategories());
                break;

            case 'get-category-by-id':
                if (isset($_GET['id'])) {
                    echo json_encode($this->categoryController->getCategoryById(intval($_GET['id'])));
                }
                break;  

            case 'get-all-blogs':
                echo json_encode($this->blogController->getAllBlogs());
                break;

            case 'get-subscription-plans':
                echo json_encode($this->subscriptionController->getAllSubscriptions());
                break;  
                
            case 'delete-product-by-id':
                if (isset($_GET['id'])) {
                    echo json_encode($this->productController->deleteProductById(intval($_GET['id'])));
                }
                break; 

            case 'get-all-subscription-boxes':
                echo json_encode($this->subscriptionController->getAll());
                break;    
                
            case 'save-subscription-box':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->subscriptionController->saveSubscriptionBox($data));
                break;

            case 'get-user-subscription-boxes':
                echo json_encode($this->subscriptionController->getUserSubscriptionBoxes());
                break;
            
            case 'get-latest-blog':
                echo json_encode($this->blogController->getLatestBlog());
                break;    

            default:
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid endpoint"
                ]);
        }
    }
}

?>