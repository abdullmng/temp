<?php 

function insert(array $data, $db, $table)
{
    $columns = "";
    $values = "";
    $x = 1;
    $count = count($data);
    foreach ($data as $key => $value)
    {
        $escaped_value = $db->real_escape_string($value);
        if ($x < $count)
        {
            $columns .= "`$key`,";
            $values .= "'$escaped_value',";
        }
        else  
        {
            $columns .= "`$key`";
            $values .= "'$escaped_value'";
        }

        $x++;
    }

    $sql = "INSERT INTO `$table` ($columns)VALUE($values)";

    return $db->query($sql);
}

function redirect($url)
{
    return header('location:'. $url);
}

function check_auth()
{
    if (!isset($_SESSION['user']) || $_SESSION['user'] == NULL)
    {
        return redirect('login.php');
    }
}

function logout()
{
    unset($_SESSION['user']);
    $_SESSION['user'] = null;
    return redirect('login.php');
}

function auth_user()
{
    return $_SESSION['user'];
}

function validate($fields, &$errors, &$ok)
{
    foreach($fields as $field)
    {
        if (empty($_POST[$field]))
        {
            $errors[] = '<div class="alert alert-danger">the '.$field.' field is required</div>';
            $ok = 0;
        }
    }
}