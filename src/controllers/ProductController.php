<?php
class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function getNewProducts() {
        try {
            $products = $this->productModel->getNewProducts();
            return [
                "status" => "success",
                "data" => $products
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function deleteProductById($id) {
        try {
            $result = $this->productModel->delete($id);
            return [
                "status" => "success",
                "message" => "Product deleted successfully"
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function getAllProducts() {
        try {
            $products = $this->productModel->getAll();
            return [
                "status" => "success",
                "data" => $products
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function getProductById($id) {
        try {
            $product = $this->productModel->getById($id);
            if ($product) {
                return [
                    "status" => "success",
                    "data" => $product
                ];
            }
            return [
                "status" => "error",
                "message" => "Product not found"
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function saveProduct($data) {
        try {
            $validation = $this->validateProductData($data);
            if (!$validation['isValid']) {
                return [
                    "status" => "error",
                    "message" => "Validation failed",
                    "errors" => $validation['errors']
                ];
            }

            $result = $this->productModel->save($data);
            return [
                "status" => "success",
                "message" => "Product added successfully"
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function updateProduct($id, $data) {
        try {
            $result = $this->productModel->update($id, $data);
            return [
                "status" => "success",
                "message" => "Product updated successfully"
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function deleteProduct($id) {
        try {
            $result = $this->productModel->delete($id);
            return [
                "status" => "success",
                "message" => "Product deleted successfully"
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function filterProducts() {  // Changed to public
        $category = isset($_GET['category']) ? $_GET['category'] : null;
        $minPrice = isset($_GET['minPrice']) ? floatval($_GET['minPrice']) : null;
        $maxPrice = isset($_GET['maxPrice']) ? floatval($_GET['maxPrice']) : null;
    
        try {
            $products = $this->productModel->filterByCategoryAndOrPriceRange($category, $minPrice, $maxPrice);
            return [
                "status" => "success",
                "data" => $products
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    private function validateProductData($data) {
        $requiredFields = [
            'name' => 'string',
            'description' => 'string',
            'short_description' => 'string',
            'category_id' => 'int',
            'price' => 'float',
            'stock_quantity' => 'int',
            'is_seasonal' => 'bool',
            'is_new' => 'bool',
            'image_url' => 'string',
        ];

        $errors = [];
        foreach ($requiredFields as $field => $type) {
            if (!isset($data[$field])) {
                $errors[] = "$field is required";
            } elseif (!$this->validateType($data[$field], $type)) {
                $errors[] = "$field must be of type $type";
            }
        }

        return [
            'isValid' => empty($errors),
            'errors' => $errors
        ];
    }

    private function validateType($value, $type) {
        switch ($type) {
            case 'string':
                return is_string($value);
            case 'float':
                return is_numeric($value) && strpos((string)$value, '.') !== false;
            case 'int':
                return is_numeric($value) && strpos((string)$value, '.') === false;
            case 'bool':
                return is_bool($value) || $value === 0 || $value === 1 || $value === 'true' || $value === 'false';
            default:
                return false;
        }
    }
}

?>