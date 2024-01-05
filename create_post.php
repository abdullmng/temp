<?php 
require 'connections/db.php';
require 'includes/functions.php';

check_auth();
$user = auth_user();

$title = 'Create Post';
$msg = '';
$errors = [];

if (!empty($_POST)) {
    $ok = 1;
    validate(['title', 'content'], $errors, $ok);

    if ($ok == 1) {
        $post = [
            "user_id" => $user['id'],
            "title" => $db->real_escape_string($_POST["title"]),
            "content"=> $db->real_escape_string($_POST["content"])
        ];
        if (!empty($_FILES['image']['name']))
        {
            $folder = 'uploads/';
            $filename = $folder.$_FILES['image']['name'];

            if(move_uploaded_file($_FILES['image']['tmp_name'], $filename))
            {
                $post['image'] = $filename;
            }
        }
        insert($post, $db, 'posts');
        $msg = '<div class="alert alert-success">post created</div>';
        if ($db->error)
        {
            die($db->error);
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div class="mb-4">
                        <?php echo $msg ?>
                        <?php 
                            foreach ($errors as $error)
                            {
                                echo $error;
                            }
                        ?>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary">Create Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'?>