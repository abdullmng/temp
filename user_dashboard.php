<?php 
require 'connections/db.php';
require 'includes/functions.php';

check_auth();
$user = auth_user();

$title = 'Dashboard';

$sql_posts = "SELECT * FROM posts WHERE user_id='".$user['id']."'";
$result = $db->query($sql_posts);
$count = $result->num_rows;
$posts = $result->fetch_all(MYSQLI_ASSOC);

include 'includes/header.php';
?>
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <a href="create_post.php" class="btn btn-primary">New Post</a>
                </div>
                <?php 
                    if ($count > 0)
                    {
                ?>
                <ul class="list-group">
                    <?php 
                        foreach ( $posts as $post ) {
                    ?>
                    <li class="list-group-item">
                        <a href="post.php?post_id=<?php echo $post['id']?>"><?php echo $post['title']?></a>
                    </li>
                    <?php }?>
                </ul>
                <?php }else {?>
                    <div class="alert alert-info">No posts yet.</div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'?>