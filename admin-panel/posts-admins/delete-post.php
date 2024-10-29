<?php 
    session_start();
    require "../../config/config.php";

    if(isset($_GET['del_post_id'])) {
        $del_id = $_GET['del_post_id'];

        $deletePosts = $con->prepare("DELETE FROM posts WHERE id = :post_id");
        $deletePosts->execute([
            ':post_id' => $del_id
        ]);

        header('location: http://localhost/clean-blog/admin-panel/posts-admins/show-posts.php');
    }
?>