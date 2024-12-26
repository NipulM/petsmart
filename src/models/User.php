<?php 

class User {
    private $db;
    private $table = 'users';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
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