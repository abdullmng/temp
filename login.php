<?php 
   require 'connections/db.php';
    require "includes/functions.php";
   $title = 'Login';
   
   $msg = '';
   $errors = [];
   $ok = 1;

    if (!empty($_POST))
    {
        if (empty($_POST['email']))
        {
            array_push($errors, '<div class="alert alert-danger">The email field is required</div>');
            $ok = 0;
        }

        if (empty($_POST['password']))
        {
            array_push($errors, '<div class="alert alert-danger">The password field is required</div>');
            $ok = 0;
        }

        if ($ok == 1)
        {
            $email = $db->real_escape_string($_POST['email']);
            $password = $db->real_escape_string($_POST['password']);

            $sql = "SELECT * FROM users WHERE `email`='$email'";
            $result = $db->query($sql);
            $num_rows = $result->num_rows;
            $user = $result->fetch_assoc();     

            if ($num_rows > 0)
            {
                if (password_verify($password, $user['password']))
                {
                    $msg = '<div class="alert alert-success">Login success</div>';
                    $_SESSION['user'] = $user;
                    redirect('user_dashboard.php');
                }
                else
                {
                    array_push($errors, '<div class="alert alert-danger">Incorrect email or password</div>');
                }
            }
            else
            {
                array_push($errors, '<div class="alert alert-danger">Incorrect email or password</div>');
            }
        }
    }
    
    include 'includes/header.php';
?>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center">Login</h4>
                        <form method="post">
                            <div class="mb-4">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
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
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                                <p class="text-center">
                                    <a href="register.php">Don't have an account? register</a>
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