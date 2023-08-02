<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = 'company'; // Set the role as 'company' for company registration

    // Additional attributes for company registration
    $company_name = $_POST['company_name'];
    $address = $_POST['address'];
    $contact_person = $_POST['contact_person'];
    $website = $_POST['website'];

    // Check if the username already exists in the database
    $checkQuery = "SELECT * FROM users WHERE username = ?";
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

        // Insert into Company table
        $companyQuery = "INSERT INTO company (user_id, name, address, contact_person, email, phone, website)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $companyStmt = $conn->prepare($companyQuery);
        $companyStmt->bind_param('issssss', $user_id, $name, $address, $contact_person, $email, $phone, $website);
        $companyStmt->execute();

        // Redirect to login page with success message
        header('Location: login.php?registration=success');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Registration</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <div class="container">
        <h2>Company Registration</h2>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
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

            <!-- Additional attributes for company registration -->
            <label for="company_name">Company Name:</label>
            <input type="text" id="company_name" name="company_name" required><br>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required><br>

            <label for="contact_person">Contact Person:</label>
            <input type="text" id="contact_person" name="contact_person" required><br>

            <label for="website">Website:</label>
            <input type="url" id="website" name="website" required><br>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>

    <!-- Add your JavaScript effects here if needed -->
</body>
</html>
