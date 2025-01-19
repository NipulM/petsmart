<?php 

class Subscription {
    private $db;
    private $table = 'subscriptions';
    private $subscription_boxes = 'subscription_boxes';
    private $userModel;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->userModel = new User();
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->db->query($sql);

        $subscriptions = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $subscriptions[] = $row;
            }
        }
        return $subscriptions;
    }

    public function getAllSubscriptionBoxes () {
        $sql = "SELECT * FROM {$this->subscription_boxes}";
        $result = $this->db->query($sql);

        $subscriptionBoxes = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $row['order_items'] = json_decode($row['order_items'], true);
                $subscriptionBoxes[] = $row;
            }
        }
        return $subscriptionBoxes;
    }

    public function getUserSubscriptionBoxes() {
        $profile = $this->userModel->getUserProfile();
        if (!$profile) {
            http_response_code(401);
            echo json_encode([
                "status" => "error",
                "message" => "Not authenticated"
            ]);
            exit;
        }

        $sql = "SELECT * FROM {$this->subscription_boxes} WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $profile['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $subscriptionBoxes = [];

            while ($row = $result->fetch_assoc()) {
                $row['order_items'] = json_decode($row['order_items'], true);
                $subscriptionBoxes[] = $row;
            }

            return $subscriptionBoxes;
        }

        return [];
    }

    public function saveSubscription($data) {
        // First, verify if the subscription_id exists
        $stmt = $this->db->prepare("SELECT price FROM {$this->table} WHERE subscription_id = ?");
        $stmt->bind_param("i", $data['subscription_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("Invalid subscription plan");
        }

        $subscription = $result->fetch_assoc();
        $stmt->close();

        // Calculate expiry date based on subscription type
        $startDate = isset($data['start_date']) ? new DateTime($data['start_date']) : new DateTime();
        $expiryDate = clone $startDate;

        // Get subscription type to determine expiry date
        $stmt = $this->db->prepare("SELECT plan_type FROM {$this->table} WHERE subscription_id = ?");
        $stmt->bind_param("i", $data['subscription_id']);
        $stmt->execute();
        $planResult = $stmt->get_result();
        $planData = $planResult->fetch_assoc();
        $stmt->close();

        // Add months based on plan type
        if (strtolower($planData['plan_type']) === 'basic') {
            $expiryDate->modify('+3 months');
        } else if (strtolower($planData['plan_type']) === 'premium') {
            $expiryDate->modify('+12 months');
        }

        // Prepare and execute the insert statement
        $sql = "INSERT INTO {$this->subscription_boxes} 
                (user_id, subscription_id, total_amount, order_items, start_date, expiry_date, customer_name) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new Exception("Database preparation failed: " . $this->db->error);
        }

        // Format dates for MySQL
        $startDateStr = $startDate->format('Y-m-d H:i:s');
        $expiryDateStr = $expiryDate->format('Y-m-d H:i:s');
        
        $stmt->bind_param(
            "iidssss",
            $data['user_id'],
            $data['subscription_id'],
            $data['total_amount'],
            $data['order_items'],
            $startDateStr,
            $expiryDateStr,
            $data['customer_name']
        );

        if (!$stmt->execute()) {
            throw new Exception("Failed to save subscription: " . $stmt->error);
        }

        $newSubscriptionId = $stmt->insert_id;
        $stmt->close();

        // Return the newly created subscription box data
        $sql = "SELECT * FROM {$this->subscription_boxes} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $newSubscriptionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $newSubscription = $result->fetch_assoc();
        $stmt->close();

        return $newSubscription;
    }

}

?>