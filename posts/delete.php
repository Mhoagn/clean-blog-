<?php 
    session_start();
?>

<?php require "../config/config.php"; ?>



<?php

    if(isset($_GET['del_id'])) {
        $del_id = $_GET['del_id'];

        $row = $con->prepare("SELECT * FROM posts p
        WHERE p.id = '$del_id'");
        $row->execute();

        $post = $row->fetch(PDO::FETCH_OBJ);

        if($post->user_id != $_SESSION['id']){
            $_SESSION['error'] = "Bạn không có quyền xóa bài viết này!";
            header("Location: ../index.php");
            exit();
        }
        else {
            unlink("images/" . $post->img . "");

            $delete = $con->prepare("DELETE FROM posts WHERE id = :id");

            $delete->execute([
                ':id' => $del_id
            ]);

            header('location: http://localhost/clean-blog/index.php');
        }

    }

?>