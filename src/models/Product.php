<?php 
class Product {
    private $db;
    private $table = 'products';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->db->query($sql);

        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
        }
        return null;
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (name, description, category, price, stock_quantity, is_seasonal) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param(
                "sssdis",
                $data['name'],
                $data['description'],
                $data['category'],
                $data['price'],
                $data['stock_quantity'],
                $data['is_seasonal']
            );
            return $stmt->execute();
        }
        throw new \Exception("Error preparing statement");
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET name = ?, price = ?, description = ? WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sdsi", $data['name'], $data['price'], $data['description'], $id);
            return $stmt->execute();
        }
        throw new \Exception("Error preparing statement");
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        throw new \Exception("Error preparing statement");
    }
}

?>