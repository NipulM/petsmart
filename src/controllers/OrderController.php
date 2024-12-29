<?php 

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    public function getUserOrders() {
        try {
            $result = $this->orderModel->getUserOrders();
            return $result;
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function placeOrder($data) {
        try {
            $result = $this->orderModel->placeOrder($data);
            return $result;
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }
}

?>