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
}

?>