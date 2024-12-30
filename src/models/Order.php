<?php 

class Order {
    private $db;
    private $table = 'orders';
    private $userModel;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->userModel = new User();
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->db->query($sql);

        $orders = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders;
    }

    public function updateOrderStatus($data) {
        $sql = "UPDATE {$this->table} SET status = ? WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $data['status'], $data['order_id']);
            if ($stmt->execute()) {
                return [
                    "status" => "success",
                    "message" => "Order status updated successfully"
                ];
            }
        }

        return [
            "status" => "error",
            "message" => "Failed to update order status: " . $this->db->error
        ];
    }

    public function getUserOrders() {
        $profile = $this->userModel->getUserProfile();
        if (!$profile) {
            http_response_code(401);
            echo json_encode([
                "status" => "error",
                "message" => "Not authenticated"
            ]);
            exit;
        }

        $sql = "SELECT * FROM {$this->table} WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $profile['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $orders = [];

            while ($row = $result->fetch_assoc()) {
                $row['order_items'] = json_decode($row['order_items'], true);
                $orders[] = $row;
            }

            return $orders;
        }

        return [];
    }

    public function placeOrder($data) {
        $profile = $this->userModel->getUserProfile();
        if (!$profile) {
            http_response_code(401);
            echo json_encode([
                "status" => "error",
                "message" => "Not authenticated"
            ]);
            exit;
        }
    
        // // Validate required fields
        $requiredFields = ['name', 'email', 'phone_number', 'address', 'items', 'total_amount'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return [
                    "status" => "error",
                    "message" => "Missing required field: {$field}"
                ];
            }
        }

        if (is_array($data['items'])) {
            $data['items'] = array_map(function($item) {
                $item['price'] = number_format($item['price'], 2, '.', '');
                return $item;
            }, $data['items']);
        }

        $orderItems = is_string($data['items']) ? $data['items'] : json_encode($data['items']);
    
        $sql = "INSERT INTO {$this->table} (
            user_id, 
            name, 
            email, 
            phone_number, 
            address, 
            order_items, 
            total_amount, 
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
    
        $stmt = $this->db->prepare($sql);
    
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param(
                "isssssd", 
                $profile['user_id'],
                $data['name'],
                $data['email'],
                $data['phone_number'],
                $data['address'],
                $orderItems,
                $data['total_amount']
            );

            if ($stmt->execute()) {
                $orderId = $stmt->insert_id;
    
                // TODO: - Updating product stock quantities
                
                return [
                    "status" => "success",
                    "message" => "Order created successfully",
                    "order_id" => $orderId
                ];
            }
        }
    
        return [
            "status" => "error",
            "message" => "Failed to create order: " . $this->db->error
        ];
    }
}

?>