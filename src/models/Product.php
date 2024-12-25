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

    public function filterByCategoryAndOrPriceRange($category = null, $minPrice = null, $maxPrice = null) {

        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $types = "";
        $params = [];

        if ($category && $category !== 'default') {
            $sql .= " AND category_id = ?";
            $types .= "s";
            $params[] = $category;
        }
        
        // Add price range filter if provided
        if ($minPrice !== null) {
            $sql .= " AND price >= ?";
            $types .= "d";
            $params[] = $minPrice;
        }
        
        if ($maxPrice !== null  ) {
            $sql .= " AND price <= ?";
            $types .= "d";
            $params[] = $maxPrice;
        }

        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            
            return $products;
        }
        
        throw new \Exception("Error preparing statement");
    }
}

?>