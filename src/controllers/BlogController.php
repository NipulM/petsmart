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
}

?>