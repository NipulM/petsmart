<?php 

class BlogController {
    private $blogModel;

    public function __construct() {
        $this->blogModel = new Blog();
    }

    public function getAllBlogs() {
        try {
            $blogs = $this->blogModel->getAll();
            return [
                "status" => "success",
                "data" => $blogs
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function getLatestBlog() {
        try {
            $blog = $this->blogModel->getLatestBlog();
            if ($blog) {
                return [
                    "status" => "success",
                    "data" => $blog
                ];
            }
            return [
                "status" => "error",
                "message" => "Blog not found"
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function getBlogById($id) {
        try {
            $blog = $this->blogModel->getBlogById($id);
            if ($blog) {
                return [
                    "status" => "success",
                    "data" => $blog
                ];
            }
            return [
                "status" => "error",
                "message" => "Blog not found"
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    public function saveBlog($data) {
        try {
            $validation = $this->validateBlogData($data);
            if (!$validation['isValid']) {
                return [
                    "status" => "error",
                    "message" => "Validation failed",
                    "errors" => $validation['errors']
                ];
            }
            
            $newBlog = $this->blogModel->save($data);
            return [
                "status" => "success",
                "data" => $newBlog
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    private function validateBlogData($data) {
        $errors = [];
        $isValid = true;

        if (!isset($data['title']) || strlen($data['title']) < 5) {
            $isValid = false;
            $errors['title'] = "Title must be at least 5 characters long";
        }

        if (!isset($data['content']) || strlen($data['content']) < 10) {
            $isValid = false;
            $errors['content'] = "Content must be at least 10 characters long";
        }

        if (!isset($data['image_url'])) {
            $isValid = false;
            $errors['content'] = "Image URL is required";
        }

        return [
            "isValid" => $isValid,
            "errors" => $errors
        ];
    }
}

?>