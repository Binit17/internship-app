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
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br>

        <label for="skills">Skills:</label>
        <textarea id="skills" name="skills" required></textarea><br>

        <label for="department">Department:</label>
        <input type="text" id="department" name="department" required><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
        </select><br>

        <label for="year_of_study">Year of Study:</label>
        <input type="text" id="year_of_study" name="year_of_study" required><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="student">Student</option>
            <option value="admin">Administrator</option>
        </select><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
