<?php 
include_once './config/db.php';

function GetAllProducts() {
    global $conn;    

    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);

    $products = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    } else {
        die("Error executing query: " . mysqli_error($conn));
    }
    
    return $products;
}

function GetProductById($product_id) {
    global $conn;

    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}

function AddProduct($name, $description, $category, $price, $stock_quantity, $is_seasonal) {
    global $conn;
    
    $sql = "INSERT INTO products (name, description, category, price, stock_quantity, is_seasonal) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("sssdis", $name, $description, $category, $price, $stock_quantity, $is_seasonal);
        return $stmt->execute();
    } else {
        return false;
    }
}

function DeleteProduct($product_id) {
    global $conn;

    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        return $stmt->execute();
    } else {
        return false;
    }
}

function UpdateProduct($id, $name, $price, $description) {
    global $conn; // Assuming $conn is your database connection

    $sql = "UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sdsi", $name, $price, $description, $id);
        return $stmt->execute();
    } else {
        return false;
    }
}

?>
