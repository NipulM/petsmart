<?php 

class Order {
    private $db;
    private $table = 'orders';
    private $userModel;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->userModel = new User();
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