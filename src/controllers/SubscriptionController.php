<?php 

class SubscriptionController {
    private $subscriptionModel;

    public function __construct() {
        $this->subscriptionModel = new Subscription();
    }

    public function getAllSubscriptions() {
        try {
            $subscriptions = $this->subscriptionModel->getAll();
            return [
                "status" => "success",
                "data" => $subscriptions
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function getAll() {
        try {
            $subscriptions = $this->subscriptionModel->getAllSubscriptionBoxes();
            return [
                "status" => "success",
                "data" => $subscriptions
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function getUserSubscriptionBoxes() {
        try {
            $subscriptionBoxes = $this->subscriptionModel->getUserSubscriptionBoxes();
            return [
                "status" => "success",
                "data" => $subscriptionBoxes
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function saveSubscriptionBox($data) {
        $validation = $this->validateSubscriptionBox($data);
        if (!$validation['isValid']) {
            return [
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validation['errors']
            ];
        }

        try {
            $subscription = $this->subscriptionModel->saveSubscription($data);
            return [
                "status" => "success",
                "data" => $subscription
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    private function validateSubscriptionBox($data) {
        echo "Validating subscription box"; 
        $requiredFields = [
            'user_id',
            'subscription_id',
            'total_amount',
            'order_items',
            'customer_name'
        ];
    
        $errors = [];
    
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return [
                    "status" => "error",
                    "message" => "Missing required field: {$field}"
                ];
            }

        }
    
        return [
            'isValid' => empty($errors),
            'errors' => $errors
        ];
    }
}

?>