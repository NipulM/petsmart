<?php 

include_once 'products.php';

header('Content-Type: application/json');

$requestURI = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

// Extract the path without the query string
$requestPath = parse_url($requestURI, PHP_URL_PATH);
$requestURL = trim(str_replace($scriptName, '', $requestPath), '/');

if ($requestURL === 'get-all-products') {
    $response = GetAllProducts();
    echo json_encode([
        "status" => "success",
        "data" => $response
    ]);
} elseif ($requestURL === 'get-product-by-id') {
    if (isset($_GET['id'])) {
        $productId = intval($_GET['id']);

        $response = GetProductById($productId);

        if ($response) {
            echo json_encode([
                "status" => "success",
                "data" => $response
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Product not found"
            ]);
        }
    } 
} elseif ($requestURL === 'add-product') {
    // Decode the JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    // Define required fields and their expected types
    $requiredFields = [
        'name' => 'string',
        'description' => 'string',
        'category' => 'string',
        'price' => 'float',
        'stock_quantity' => 'int',
        'is_seasonal' => 'bool'
    ];

    // Initialize an array to store missing or invalid fields
    $missingOrInvalidFields = [];

    // Validate each required field
    foreach ($requiredFields as $field => $type) {
        if (!isset($data[$field])) {
            $missingOrInvalidFields[] = "$field is required";
        } elseif (!validateType($data[$field], $type)) {
            $missingOrInvalidFields[] = "$field must be of type $type";
        }
    }

    // If there are missing or invalid fields, return an error response
    if (!empty($missingOrInvalidFields)) {
        echo json_encode([
            "status" => "error",
            "message" => "Validation failed",
            "errors" => $missingOrInvalidFields
        ]);
        exit;
    }
    
    // Extract validated data
    $name = (string)$data['name'];
    $description = (string)$data['description'];
    $category = (string)$data['category'];
    $price = (float)$data['price'];
    $stock_quantity = (int)$data['stock_quantity'];
    $is_seasonal = filter_var($data['is_seasonal'], FILTER_VALIDATE_BOOLEAN);
    
    // Call the AddProduct function to save the data
    $response = AddProduct($name, $description, $category, $price, $stock_quantity, $is_seasonal);

    if ($response) {
        echo json_encode([
            "status" => "success",
            "message" => "Product added successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Error adding product"
        ]);
    }
} elseif ($requestURL === "delete-product") {
    $inputData = file_get_contents('php://input');
    $decodedData = json_decode($inputData, true);

    echo json_encode($inputData);

    if (is_array($decodedData) && isset($decodedData['id'])) {
        $productId = intval($decodedData['id']);

        if ($productId > 0) {
            // Call the DeleteProduct function (implement this in your products.php file)
            $result = DeleteProduct($productId);

            if ($result) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Product deleted successfully"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to delete product or product not found"
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid product ID"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Product ID is required"
        ]);
    }
} elseif ($requestURL === "update-product") {
        // Read the raw input data
        $inputData = file_get_contents('php://input');
        $decodedData = json_decode($inputData, true);
    
        if (is_array($decodedData) && isset($decodedData['id'], $decodedData['name'], $decodedData['price'], $decodedData['description'])) {
            $productId = intval($decodedData['id']);
            $name = trim($decodedData['name']);
            $price = floatval($decodedData['price']);
            $description = trim($decodedData['description']);
    
            if ($productId > 0 && $name && $price > 0 && $description) {
                // Call the UpdateProduct function (implement this in your products.php file)
                $result = UpdateProduct($productId, $name, $price, $description);
    
                if ($result) {
                    echo json_encode([
                        "status" => "success",
                        "message" => "Product updated successfully"
                    ]);
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Failed to update product or product not found"
                    ]);
                }
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid input data"
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "ID, name, price, and description are required"
            ]);
        }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid endpoint"
    ]);
}

function validateType($value, $type) {
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
?>
