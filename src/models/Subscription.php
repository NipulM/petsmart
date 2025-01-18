<?php 

class Subscription {
    private $db;
    private $table = 'subscriptions';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
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

}

?>