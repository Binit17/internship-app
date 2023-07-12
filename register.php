
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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('grad0.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 20px;
        }
        
        h2 {
            margin-bottom: 20px;
        }

        form {
            width: 400px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="tel"],
        textarea,
        select {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Register</h2>
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
</body>
</html>





























<!-- 
     <!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333333;
            margin-top: 0;
            text-align: center;
        }

        form {
            animation: fade-in 0.5s ease;
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333333;
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
            border: 1px solid #dddddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .dob-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dob-container select {
            flex: 1;
            margin-right: 10px;
        }

        .dob-container label {
            margin: 0;
        }

        .dob-container select,
        .dob-container input[type="number"] {
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }

        .dob-container input[type="number"] {
            width: 70px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
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

            <div class="dob-container">
                <label for="dob-day">Date of Birth:</label>
                <div>
                    <input type="number" id="dob-day" name="dob-day" min="1" max="31" required>
                    <select id="dob-month" name="dob-month" required>
                        <option value="">Month</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <input type="number" id="dob-year" name="dob-year" min="1900" max="2023" required>
                </div>
            </div>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="available">student</option>
                <option value="unavailable">admin</option>
            </select>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="available">Male</option>
                <option value="unavailable">Female</option>
                <option value="unavailable">Others</option>
            </select>


            <label for="skills">skills:</label>
            <input type="text" id="skills" name="skills" required>



            <input type="submit" value="Register">
        </form>
    </div>

    <script>
        // Add animations or interactivity using JavaScript if desired
    </script>
</body>
</html> --> --> -->
