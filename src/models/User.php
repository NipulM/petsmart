<?php 

class User {
    private $db;
    private $table = 'users';
    private $sessionsTable = 'sessions';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function adminLogin($data) {
        if (empty($data['email']) || empty($data['password'])) {
            throw new \Exception("All fields are required");
        }
    
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("s", $data['email']);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
    
                if (!$user || !password_verify($data['password'], $user['password_hash'])) {
                    throw new \Exception("Invalid email or password");
                }
    
                if ($user['role'] !== 'admin') {
                    throw new \Exception("Unauthorized access");
                }
    
                $issuedAt = time();
                $expirationTime = $issuedAt + 3600 * 10; 
                $payload = [
                    'iat' => $issuedAt,
                    'exp' => $expirationTime,
                    'user_id' => $user['user_id']
                ];
    
                $token = bin2hex(random_bytes(32));
    
                // Insert session into database
                $sql_sessions = "INSERT INTO {$this->sessionsTable} (user_id, token) VALUES (?, ?)";
                $stmt_sessions = $this->db->prepare($sql_sessions);
    
                if ($stmt_sessions) {
                    $stmt_sessions->bind_param(
                        "is",
                        $user['user_id'],
                        $token,
                    );
    
                    $stmt_sessions->execute();
                    return [
                        'status' => 'success',
                        'message' => 'Login successful',
                        'token' => $token,
                    ];
                } else {
                    throw new \Exception("Failed to create session");
                }
            } else {
                throw new \Exception("Invalid email or password");
            }
        } else {
            throw new \Exception("Database error");
        }
    }

    public function validateToken($data) {
        $sessionToken = $data['token'] ?? null;
    
        if (!$sessionToken) {
            http_response_code(401);
            echo json_encode([
                "status" => "error",
                "message" => "Not authenticated"
            ]);
            exit;
        }
    
        $userId = $this->getUserIdBySessionToken($sessionToken);
    
        if (!$userId) {
            http_response_code(401);
            echo json_encode([
                "status" => "error",
                "message" => "Invalid or expired session"
            ]);
            exit;
        }

        if ($data['role'] && $data['role'] !== 'admin') {
            $profile = $this->getUserProfileByUserId($userId);
    
            if (!$profile || $profile['role'] !== $role) {
                http_response_code(401);
                echo json_encode([
                    "status" => "error",
                    "message" => "Unauthorized access"
                ]);
                exit;
            }
        }

        if ($data['role'] && $data['role'] === 'admin') {
            $profile = $this->getUserProfileByUserId($userId);
    
            if (!$profile || $profile['role'] !== 'admin') {
                http_response_code(401);
                echo json_encode([
                    "status" => "error",
                    "message" => "Unauthorized access"
                ]);
                exit;
            }
        }
    
        return [
            "status" => "success",
            "message" => "Token is valid"
        ];
    }

    public function getAdminDashboardStats() {
        // $profile = $this->getUserProfile();
    
        // if (!$profile && $profile['role'] !== 'admin') {
        //     http_response_code(401);
        //     echo json_encode([
        //         "status" => "error",
        //         "message" => "Not authenticated"
        //     ]);
        //     exit;
        // }



        $stats = [
            'total_users' => 0,
            'total_orders' => 0,
            'total_revenue' => 0,
            'pending_orders' => 0,
            'total_products' => 0,
            'latest_orders' => []
        ];
        $chartData = [];
        
        // Fetch total users
        $sql_users = "SELECT COUNT(*) as total_users FROM {$this->table}";
        $result_users = $this->db->query($sql_users);
        
        if ($result_users) {
            $stats['total_users'] = $result_users->fetch_assoc()['total_users'];
        }
        
        // Fetch total orders
        $sql_orders = "SELECT COUNT(*) as total_orders FROM orders";
        $result_orders = $this->db->query($sql_orders);
        
        if ($result_orders) {
            $stats['total_orders'] = $result_orders->fetch_assoc()['total_orders'];
        }
        
        // Fetch total revenue
        $sql_revenue = "SELECT SUM(total_amount) as total_revenue FROM orders WHERE status = 'completed'";
        $result_revenue = $this->db->query($sql_revenue);
        
        if ($result_revenue) {
            $stats['total_revenue'] = $result_revenue->fetch_assoc()['total_revenue'] ?? 0;
        }
        
        // Fetch pending orders
        $sql_pending_orders = "SELECT COUNT(*) as pending_orders FROM orders WHERE status = 'pending'";
        $result_pending_orders = $this->db->query($sql_pending_orders);
        
        if ($result_pending_orders) {
            $stats['pending_orders'] = $result_pending_orders->fetch_assoc()['pending_orders'];
        }
        
        $sql_products = "SELECT COUNT(*) as total_products FROM products";
        $result_products = $this->db->query($sql_products);
        
        if ($result_products) {
            $stats['total_products'] = $result_products->fetch_assoc()['total_products'];
        }
    
        $sql_products_by_category = "
            SELECT c.name as category_name, COUNT(p.product_id) as total_products 
            FROM products p
            JOIN category c ON p.category_id = c.category_id 
            GROUP BY c.category_id, c.name
        ";
        $result_products_by_category = $this->db->query($sql_products_by_category);
        
        $chartData['products_by_category'] = [];
        if ($result_products_by_category) {
            while ($row = $result_products_by_category->fetch_assoc()) {
                $chartData['products_by_category'][] = [
                    'category' => $row['category_name'],
                    'total_products' => $row['total_products']
                ];
            }
        }

        $sql_latest_orders = "
            SELECT order_id, name, status, total_amount 
            FROM orders 
            ORDER BY created_at DESC 
            LIMIT 5
        ";

        $result_latest_orders = $this->db->query($sql_latest_orders);

        if ($result_latest_orders) {
            while ($row = $result_latest_orders->fetch_assoc()) {
                $stats['latest_orders'][] = [
                    'order_id' => $row['order_id'],
                    'customer_name' => $row['name'],
                    'status' => $row['status'],
                    'total_amount' => $row['total_amount']
                ];
            }
        }
    
        $sql_orders_by_status = "
            SELECT 
                status,
                COUNT(*) as total_orders 
            FROM orders 
            GROUP BY status
        ";
        $result_orders_by_status = $this->db->query($sql_orders_by_status);
        
        $chartData['orders_by_status'] = [];
        if ($result_orders_by_status) {
            while ($row = $result_orders_by_status->fetch_assoc()) {
                $chartData['orders_by_status'][] = [
                    'status' => $row['status'],
                    'total_orders' => $row['total_orders']
                ];
            }
        }
    
        return [
            'stats' => $stats,
            'chartData' => $chartData
        ];
    }

    public function updateUserProfile($data) {
        $profile = $this->getUserProfile();
    
        if (!$profile) {
            http_response_code(401);
            echo json_encode([
                "status" => "error",
                "message" => "Not authenticated"
            ]);
            exit;
        }
    
        $updateFields = [];
        $types = "";
        $values = [];
    
        // Map of field names to their corresponding SQL types
        $fieldTypes = [
            'name' => 's',
            'email' => 's',
            'bio' => 's',
            'preferences' => 's',
            'address' => 's',
            'phone' => 's',
            'pet_info' => 's'
        ];
    
        foreach ($fieldTypes as $field => $type) {
            if (isset($data[$field]) && $data[$field] !== null) {
                if (in_array($field, ['preferences', 'pet_info']) && is_array($data[$field])) {
                    $data[$field] = json_encode($data[$field]);
                }
                
                $updateFields[] = "{$field} = ?";
                $types .= $type;
                $values[] = $data[$field];
            }
        }
    
        if (empty($updateFields)) {
            return [
                "status" => "success",
                "message" => "No fields to update"
            ];
        }
    
        $types .= "i";
        $values[] = $profile['user_id'];
    
        $sql = "UPDATE {$this->table} SET " . implode(", ", $updateFields) . " WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param($types, ...$values);
            $result = $stmt->execute();
    
            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Profile updated successfully"
                ];
            }
        }
    
        return [
            "status" => "error",
            "message" => "Failed to update profile"
        ];
    }

    public function login($data) {
        if (empty($data['email']) || empty($data['password'])) {
            throw new \Exception("All fields are required");
        }
    
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("s", $data['email']);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
    
                // Verify password
                if (!$user || !password_verify($data['password'], $user['password_hash'])) {
                    throw new \Exception("Invalid email or password");
                }

                $issuedAt = time();
                $expirationTime = $issuedAt + 3600 * 3; // JWT valid for 3 hours
                $payload = [
                    'iat' => $issuedAt,
                    'exp' => $expirationTime,
                    'user_id' => $user['user_id']
                ];

                $token = bin2hex(random_bytes(32));
    
                // Insert session into database
                $sql_sessions = "INSERT INTO {$this->sessionsTable} (user_id, token) VALUES (?, ?)";
                $stmt_sessions = $this->db->prepare($sql_sessions);
    
                if ($stmt_sessions) {
                    $stmt_sessions->bind_param(
                        "is",
                        $user['user_id'],
                        $token,
                    );
    
                    $stmt_sessions->execute();
                    return [
                        'status' => 'success',
                        'message' => 'Login successful',
                        'token' => $token,
                    ];
                } else {
                    throw new \Exception("Failed to create session");
                }
            } else {
                throw new \Exception("Invalid email or password");
            }
        } else {
            throw new \Exception("Database error");
        }
    }
    

    public function register($data){
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            throw new \Exception("All fields are required");
        }

        $existingUser = $this->getUserByEmail($data['email']);
        if ($existingUser) {
            throw new \Exception("User with this email already exists");
        }

        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO {$this->table} (name, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $data['name'], $data['email'], $passwordHash);
            return $stmt->execute();
        }

        throw new \Exception("Error preparing statement");
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
        }
        return null;
    }

    public function getUserProfile() {
        // Retrieve the session token from cookies
        $sessionToken = $_COOKIE['session_token'] ?? null; 
    
        if (!$sessionToken) {
            // Return error if no session token is provided
            http_response_code(401);
            echo json_encode([
                "status" => "error",
                "message" => "Not authenticated"
            ]);
            exit;
        }
    
        // Validate the session token and retrieve the user ID
        $userId = $this->getUserIdBySessionToken($sessionToken);
    
        if (!$userId) {
            // Return error if the session token is invalid
            http_response_code(401);
            echo json_encode([
                "status" => "error",
                "message" => "Invalid or expired session"
            ]);
            exit;
        }
    
        // Fetch the user profile
        $profile = $this->getUserProfileByUserId($userId);
    
        return $profile;
    }
    
    private function getUserIdBySessionToken($token) {
        // Query to fetch the session information
        $sql = "SELECT user_id FROM {$this->sessionsTable} WHERE token = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            return null;
        }
    
        $session = $result->fetch_assoc();
        return $session['user_id'] ?? null;
    }
    
    private function getUserProfileByUserId($userId) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            return null;
        }
    
        $profile = $result->fetch_assoc();

        unset($profile['password_hash']);
    
        return $profile;
    }
}

?>