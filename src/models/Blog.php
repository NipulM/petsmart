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
}

?>