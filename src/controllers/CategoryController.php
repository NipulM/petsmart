<?php

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function getAllCategories() {
        try {
            $categories = $this->categoryModel->getAll();
            return [
                "status" => "success",
                "data" => $categories
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function getCategoryById($id) {
        try {
            $category = $this->categoryModel->getById($id);
            if ($category) {
                return [
                    "status" => "success",
                    "data" => $category
                ];
            }
            return [
                "status" => "error",
                "message" => "Category not found"
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function createNewCategory($data) {
        try {
            $validation = $this->valdiateCategoryData($data);

            $category = $this->categoryModel->create($data);
            return [
                "status" => "success",
                "data" => $category
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    private function valdiateCategoryData($data) {
        $error = [];
        $isValid = true;

        if (!isset($data['name']) || empty($data['name']) || strlen($data['name']) < 3) {
            $isValid = false;
            $errors['name'] = "Name is required";
        }

        if (!isset($data['description']) || empty($data['description']) ||strlen($data['description']) < 10) {
            $isValid = false;
            $errors['description'] = "Description is required";
        }

        return [
            "isValid" => $isValid,
            "errors" => $errors
        ];
    }
}

?>