<?php 
require 'connections/db.php';
include 'includes/functions.php';

$title = 'Register';
include 'includes/header.php';

$msg = '';
$errors = [];
$ok = 1;
if (!empty($_POST))
{
    if (empty($_POST['name']))
    {
        $errors[] = '<div class="alert alert-danger">The name field is required</div>';
        $ok=0;
    }
    if (empty($_POST['email']))
    {
        $errors[] = '<div class="alert alert-danger">The email field is required</div>';
        $ok=0;
    }
    if (empty($_POST['password']))
    {
        $errors[] = '<div class="alert alert-danger">The password field is required</div>';
        $ok=0;
    }

    if ($ok)
    {
        $user = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        $check = $db->query("SELECT * FROM users WHERE email='".$db->real_escape_string($_POST['email'])."'");
        if (!$check->num_rows)
        {
            insert($user, $db, 'users');
            if ($db->error)
            {
                die($db->error);
            }
            else
            {
                $msg = '<div class="alert alert-success">Registeration successful</div>';
            }
        }
        else {
            $errors[] = '<div class="alert alert-danger">Email already taken</div>';
        }
    }
}
?>

<div class="container">
    <div class="row justify-content-center mt-5 mt-lg-5">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">
                        Register
                    </h4>
                    <form action="" method="post">
                        <div class="mb-4">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <?php 
                            foreach ($errors as $error)
                            {
                                echo $error;
                            }
                            echo $msg;
                        ?>
                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary w-100 mb-2">Register</button>
                            <p class="text-center">
                                <a href="login.php">Already have an account? Login here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include 'includes/footer.php';
?>