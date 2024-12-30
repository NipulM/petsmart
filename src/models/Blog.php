<?php 

class Blog {
    private $db;
    private $table = 'blogs';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->db->query($sql);

        $blogs = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $blogs[] = $row;
            }
        }
        return $blogs;
    }

    public function getLatestBlog() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT 1";
        $result = $this->db->query($sql);

        if ($result) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function getBlogById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE blog_id = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                return $result->fetch_assoc();
            }
        }
        return null;
    }

    public function save($data) {
        if (isset($data['blog_id']) && !empty($data['blog_id'])) {
            $sql = "UPDATE {$this->table} 
                    SET title = ?, 
                        content = ?, 
                        image_url = ?
                    WHERE blog_id = ?";
                    
            $stmt = $this->db->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param(
                    "sssi",
                    $data['title'],
                    $data['content'],
                    $data['image_url'],
                    $data['blog_id'] 
                );
                return $stmt->execute();
            }
        } 
        else {
            return $this->create($data);
        }
        
        throw new \Exception("Error preparing statement");
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (title, content, image_url) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $data['title'], $data['content'], $data['image_url']);
            $stmt->execute();
            return $stmt->insert_id;
        }
        return null;
    }
}

?>