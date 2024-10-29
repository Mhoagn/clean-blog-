<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
if(isset($_GET['pro_id'])) {
    $user_id = filter_input(INPUT_GET, 'pro_id', FILTER_SANITIZE_NUMBER_INT);
    
    // Query user information
    $user_query = $con->prepare("
        SELECT email, username, created_at
        FROM users 
        WHERE id = :user_id
    ");
    $user_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $user_query->execute();
    $user = $user_query->fetch(PDO::FETCH_OBJ);

    if (!$user) {
        echo "User not found";
        exit;
    }

    
    $count_query = $con->prepare("
        SELECT COUNT(*) as total_posts
        FROM posts
        WHERE user_id = :user_id
    ");
    $count_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $count_query->execute();
    $total_posts = $count_query->fetchColumn();

    // Get 3 most recent posts
    $posts_query = $con->prepare("
        SELECT id, title, subtitle, created_at as post_created_at
        FROM posts
        WHERE user_id = :user_id
        ORDER BY created_at DESC
        LIMIT 3
    ");
    $posts_query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $posts_query->execute();
    $posts = $posts_query->fetchAll(PDO::FETCH_OBJ);

} else {
    echo "No user ID provided";
    exit;
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h1 class="mb-0">User Profile</h1>
                </div>
                <div class="card-body">
                    <h2 class="card-title"><?php echo "<strong>Name:</strong> " . htmlspecialchars($user->username); ?></h2>
                    <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
                    <p class="card-text"><strong>Created on: </strong> <?php echo date('m/d/Y', strtotime($user->created_at)); ?></p>
                    <p class="card-text"><strong>Total posts: </strong> <?php echo $total_posts; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
        <h2>Recent Posts</h2>
        <?php foreach($posts as $post) : ?> 
            <div class="post-preview">
                <a href="http://localhost/clean-blog/posts/post.php?post_id=<?php echo htmlspecialchars($post->id); ?>">
                    <h2 class="post-title">
                        <?php echo htmlspecialchars($post->title); ?>
                    </h2>
                    <h3 class="post-subtitle">
                        <?php echo htmlspecialchars($post->subtitle); ?>
                    </h3>
                </a>
                <p class="post-meta">
                Posted by  
                    <a href="#!"><?php echo htmlspecialchars($user->username); ?></a>
                    <?php echo date('m/d/Y', strtotime($post->post_created_at)); ?>
                </p>
            </div>
            <hr class="my-4" />
        <?php endforeach; ?>
    </div>
</div>

<?php require "../includes/footer.php"; ?>