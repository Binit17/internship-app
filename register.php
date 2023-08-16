<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $skills = $_POST['skills'];
    $department = $_POST['department'];
    $dob = $_POST['dob'];
    $status = $_POST['status'];
    $year_of_study = $_POST['year_of_study'];
    $role = $_POST['role'];

    // Check if the username already exists in the database
    $checkQuery = "SELECT * FROM users WHERE username = (?)";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param('s', $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $error = "Username already exists. Please choose a different username.";
    } else {
        // Insert into Users table
        $userQuery = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $userStmt = $conn->prepare($userQuery);
        $userStmt->bind_param('sss', $username, $password, $role);
        $userStmt->execute();

        // Get the generated user_id
        $user_id = $userStmt->insert_id;

        // Insert into Students table
        $studentQuery = "INSERT INTO students (user_id, name, email, phone, gender, skills, department, dob, status, year_of_study)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $studentStmt = $conn->prepare($studentQuery);
        $studentStmt->bind_param('isssssssss', $user_id, $name, $email, $phone, $gender, $skills, $department, $dob, $status, $year_of_study);
        $studentStmt->execute();

        // Redirect to login page with success message
        header('Location: login.php?registration=success');
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        #registration {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="tel"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select {
            height: 38px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p.error {
            color: #e74c3c;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div id="registration">
        <h2>Register</h2>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <label for="skills">Skills:</label>
            <textarea id="skills" name="skills" required></textarea>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>

            <label for="year_of_study">Year of Study:</label>
            <input type="text" id="year_of_study" name="year_of_study" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="student">Student</option>
                <option value="admin">Administrator</option>
            </select>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
