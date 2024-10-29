<?php 
    session_start();
    require "../../config/config.php";

    if(isset($_GET['delete_id'])) {
        $del_id = $_GET['delete_id'];

        // Xóa tất cả các bài viết thuộc category này trước
        $deletePosts = $con->prepare("DELETE FROM posts WHERE category_id = :category_id");
        $deletePosts->execute([
            ':category_id' => $del_id
        ]);

        // Sau đó xóa category
        $deleteCategory = $con->prepare("DELETE FROM categories WHERE category_id = :id");
        $deleteCategory->execute([
            ':id' => $del_id
        ]);

        header('location: http://localhost/clean-blog/admin-panel/categories-admins/show-categories.php');
    }
?>