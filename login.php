<?php
session_start(); //start session
//include the database configuration file
require_once 'config.php';


//we need to input the username and password entered by the user and store it in $username and $password vairable.
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $username = $_POST['username'];
    $password = $_POST['password'];

//query to check if the username and password match.
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)==1)
    {
        //authentication successful.
        $row = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        if($_SESSION['role'] == 'student')
        {
            //redirect to student dashboard.
            header("location: index.php");
        }
        elseif($_SESSION['role'] == 'admin')
        {
            //redirect to admin dashboard
            header("location: admin.php");
        }
    }
    else
    {
        //invalid credentials
        $error = "invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>
<body>
<h2>Login</h2>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</body>
</html>
