<?php
class Api {
    private $productController;
    private $categoryController;

    public function __construct() {
        $this->productController = new ProductController();
        $this->categoryController = new CategoryController();
    }

    public function handleRequest() {
        header('Content-Type: application/json');

        $requestURI = $_SERVER['REQUEST_URI'];
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $requestPath = parse_url($requestURI, PHP_URL_PATH);
        $requestURL = trim(str_replace($scriptName, '', $requestPath), '/');

        switch ($requestURL) {
            case 'get-all-products':
                echo json_encode($this->productController->getAllProducts());
                break;

            case 'get-product-by-id':
                if (isset($_GET['id'])) {
                    echo json_encode($this->productController->getProductById(intval($_GET['id'])));
                }
                break;

            case 'add-product':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($this->productController->createProduct($data));
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

            case 'get-all-categories':
                echo json_encode($this->categoryController->getAllCategories());
                break;

            case 'get-category-by-id':
                if (isset($_GET['id'])) {
                    echo json_encode($this->categoryController->getCategoryById(intval($_GET['id'])));
                }
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