<?php
class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
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

    public function createProduct($data) {
        try {
            $validation = $this->validateProductData($data);
            if (!$validation['isValid']) {
                return [
                    "status" => "error",
                    "message" => "Validation failed",
                    "errors" => $validation['errors']
                ];
            }

            $result = $this->productModel->create($data);
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

    private function validateProductData($data) {
        $requiredFields = [
            'name' => 'string',
            'description' => 'string',
            'category' => 'string',
            'price' => 'float',
            'stock_quantity' => 'int',
            'is_seasonal' => 'bool'
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