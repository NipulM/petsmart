<?php 

class User {
    private $db;
    private $table = 'users';
    private $sessionsTable = 'sessions';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
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
                $sql_sessions = "INSERT INTO {$this->sessionsTable} (user_id, token, expires_at) VALUES (?, ?, ?)";
                $stmt_sessions = $this->db->prepare($sql_sessions);
    
                if ($stmt_sessions) {
                    $stmt_sessions->bind_param(
                        "iss",
                        $user['user_id'],
                        $token,
                        date('Y-m-d H:i:s', $expirationTime)
                    );
    
                    $stmt_sessions->execute();
                    return [
                        'status' => 'success',
                        'message' => 'Login successful',
                        'token' => $token,
                        'expires_at' => $expirationTime
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
}

?>