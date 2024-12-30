<?php 

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    public function getAll() {
        try {
            $result = $this->orderModel->getAll();
            return $result;
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
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

    public function updateOrderStatus($data) {
        try {
            $validation = $this->validateOrderStatusData($data);
            $result = $this->orderModel->updateOrderStatus($data);
            return $result;
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    private function validateOrderStatusData($data) {
        $errors = [];
        $isValid = true;

        if (!isset($data['order_id']) || empty($data['order_id'])) {
            $isValid = false;
            $errors['order_id'] = "Order ID is required";
        }

        if (!isset($data['status']) || empty($data['status'])) {
            $isValid = false;
            $errors['status'] = "Status is required";
        }

        return [
            "isValid" => $isValid,
            "errors" => $errors
        ];
    }
}

?>