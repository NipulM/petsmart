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
}

?>