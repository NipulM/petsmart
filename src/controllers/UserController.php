<?php 

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function loginUser($data) {
        try {
            if (empty($data['email']) || empty($data['password'])) {
                http_response_code(400);
                return [
                    "status" => "error",
                    "message" => "All fields are required"
                ];
            }
    
            $result = $this->userModel->login($data);
            http_response_code(200);
            return [
                "status" => "success",
                "message" => "Login successful",
                "data" => $result
            ];
        } catch (\Exception $e) {
            if ($e->getMessage() === "Invalid email or password") {
                http_response_code(401);
            } else {
                http_response_code(500); 
            }
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function registerUser($data) {
        try {
            $validation = $this->validateUserData($data);
            if (!$validation['isValid']) {
                http_response_code(400);
                return [
                    "status" => "error",
                    "message" => "Validation failed",
                    "errors" => $validation['errors']
                ];
            }
    
            $result = $this->userModel->register($data);
            http_response_code(201);
            return [
                "status" => "success",
                "message" => "User registered successfully"
            ];
        } catch (\Exception $e) {
            if ($e->getMessage() === "User with this email already exists") {
                http_response_code(409);
            } else {
                http_response_code(500); 
            }
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }
    

    public function validateUserData($data) {
        $errors = [];
        $isValid = true;

        if (!isset($data['name']) || empty($data['name'])) {
            $errors['name'] = "name is required";
            $isValid = false;
        }

        if (!isset($data['email']) || empty($data['email'])) {
            $errors['email'] = "Email is required";
            $isValid = false;
        }

        if (!isset($data['password']) || empty($data['password'])) {
            $errors['password'] = "Password is required";
            $isValid = false;
        }

        return [
            "isValid" => $isValid,
            "errors" => $errors
        ];
    }
}

?>