<?php
session_start(); //start session

//error finding
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//include the database configuration file
require_once 'config.php';


//we need to input the username and password entered by the user and store it in $username and $password vairable.
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $username = $_POST['username'];
    $password = $_POST['password'];

//query to check if the username and password match.
    $sql1 = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql1);

    if(mysqli_num_rows($result)==1)
    {
        //authentication successful.
        $row = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $tempvariable=$_SESSION['user_id'];
        $sql2 = "SELECT * FROM students WHERE user_id = '$tempvariable'";
        $result2 = mysqli_query($conn, $sql2);
        $row2=mysqli_fetch_assoc($result2);
        $_SESSION['student_id'] = $row2['student_id'];

        if($_SESSION['role'] == 'student')
        {
            //redirect to student dashboard.
            header("location: index.php");
        }
        elseif($_SESSION['role'] == 'company')
        {
            //redirect to company dashboard
            header("location: company_dashboard.php");
        }
        elseif($_SESSION['role'] == 'admin')
        {
            //redirect to admin dashboard
            header("location: admin_dashboard.php");
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
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('grad0.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 150px; /* Adjust the value to center vertically */
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333333;
            margin-top: 0;
            text-align: center;
        }

        .error {
            color: #FF0000;
            text-align: center;
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <br><br><a href="register.php">Register as a student</a></p>
        <p><a href="registrationforcompany.php">Register as a company</a></p>
    </div>

    <script>
        // Add JavaScript effects here if needed
    </script>
</body>
</html>