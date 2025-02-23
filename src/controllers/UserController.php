<?php 

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function adminLogin($data) {
        try {
            if (empty($data['email']) || empty($data['password'])) {
                http_response_code(400);
                return [
                    "status" => "error",
                    "message" => "All fields are required"
                ];
            }
    
            $result = $this->userModel->adminLogin($data);
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

    public function validateToken($data) {
        try {
            $result = $this->userModel->validateToken($data);
            if ($result) {
                http_response_code(200);
                return [
                    "status" => "success",
                    "message" => "Token is valid"
                ];
            } else {
                http_response_code(401);
                return [
                    "status" => "error",
                    "message" => "Token is invalid"
                ];
            }
        } catch (\Exception $e) {
            http_response_code(500);
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function getAdminDashboardStats() {
        try {
            $stats = $this->userModel->getAdminDashboardStats();
            http_response_code(200);
            return [
                "status" => "success",
                "message" => "Stats retrieved successfully",
                "data" => $stats
            ];
        } catch (\Exception $e) {
            http_response_code(500);
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function updateUserProfile($data) {
        try {
            $validation = $this->validateUserFormData($data);
            if (!$validation['isValid']) {
                http_response_code(400);
                return [
                    "status" => "error",
                    "message" => "Validation failed",
                    "errors" => $validation['errors']
                ];
            }
    
            $result = $this->userModel->updateUserProfile($data);
            http_response_code(200);
            return [
                "status" => "success",
                "message" => "Profile updated successfully"
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

    public function validateUserFormData($data) {
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

        return [
            "isValid" => $isValid,
            "errors" => $errors
        ];
    }

    public function getUserProfile() {
        try {
            $profile = $this->userModel->getUserProfile();
            if ($profile) {
                // Remove sensitive information :) 
                unset($profile['password_hash']);
                
                http_response_code(200);
                return [
                    "status" => "success",
                    "message" => "Profile retrieved successfully",
                    "data" => $profile
                ];
            } else {
                http_response_code(404);
                return [
                    "status" => "error",
                    "message" => "Profile not found"
                ];
            }
        } catch (\Exception $e) {
            http_response_code(500);
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
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