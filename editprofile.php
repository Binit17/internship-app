<?php
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Fetch the student's information from the database
$student_id = $_SESSION['student_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $skills = $_POST['skills'];
    $department = $_POST['department'];
    $dob = $_POST['dob'];

    // Validate and update the student details in the database
    $sql = "UPDATE students SET 
            name = '$name', 
            email = '$email', 
            phone = '$phone', 
            gender = '$gender', 
            skills = '$skills', 
            department = '$department', 
            dob = '$dob' 
            WHERE student_id = '$student_id'";
    
    if (mysqli_query($conn, $sql)) {
        $message = "Profile details updated successfully.";
    } else {
        $error = "Error updating profile details: " . mysqli_error($conn);
    }

    // Upload Profile Picture and CV
    if ($_FILES['profile_picture']['name']) {
        // Process profile picture upload
        $profilePicture = $_FILES['profile_picture'];
        $profilePictureName = $profilePicture['name'];
        $profilePictureTmpName = $profilePicture['tmp_name'];
        $profilePictureError = $profilePicture['error'];

        // Validate and move the uploaded profile picture to a designated folder
        if ($profilePictureError === 0) {
            $profilePicturePath = 'uploads/profile_pictures/' . $profilePictureName;
            move_uploaded_file($profilePictureTmpName, $profilePicturePath);

            // Update the profile picture path in the database
            $sql = "UPDATE students SET profile_picture = '$profilePicturePath' WHERE student_id = '$student_id'";
            mysqli_query($conn, $sql);
        }
    }

    if ($_FILES['cv']['name']) {
        // Process CV upload
        $cv = $_FILES['cv'];
        $cvName = $cv['name'];
        $cvTmpName = $cv['tmp_name'];
        $cvError = $cv['error'];

        // Validate and move the uploaded CV to a designated folder
        if ($cvError === 0) {
            $cvPath = 'uploads/cv/' . $cvName;
            move_uploaded_file($cvTmpName, $cvPath);

            // Update the CV path in the database
            $sql = "UPDATE students SET cv = '$cvPath' WHERE student_id = '$student_id'";
            mysqli_query($conn, $sql);
        }
    }

    // Fetch the updated student's information from the database
    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($result);
} else {
    // Fetch the student's information from the database
    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Add your head content here, like title, CSS, etc. -->
</head>

<body>
    <header>
        <h1>Edit Profile</h1>
        <a href="student_dashboard.php">Back to Dashboard</a>
    </header>
  <!-- Your HTML form here to display the profile details and allow editing -->
  <form action="editprofile.php" method="post" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo $student['name']; ?>"><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo $student['email']; ?>"><br>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" id="phone" value="<?php echo $student['phone']; ?>"><br>

    <label for="gender">Gender:</label>
    <select name="gender" id="gender">
      <option value="male" <?php if ($student['gender'] === 'male') echo 'selected'; ?>>Male</option>
      <option value="female" <?php if ($student['gender'] === 'female') echo 'selected'; ?>>Female</option>
      <option value="other" <?php if ($student['gender'] === 'other') echo 'selected'; ?>>Other</option>
    </select><br>

    <label for="skills">Skills:</label>
    <textarea name="skills" id="skills"><?php echo $student['skills']; ?></textarea><br>

    <label for="department">Department:</label>
    <input type="text" name="department" id="department" value="<?php echo $student['department']; ?>"><br>

    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob" id="dob" value="<?php echo $student['dob']; ?>"><br>

    <label for="year_of_study">Year of Study:</label>
    <input type="text" name="year_of_study" id="year_of_study" value="<?php echo $student['year_of_study']; ?>"><br>

    <!-- Add form fields for profile picture and CV uploads -->
    <label for="profile_picture">Profile Picture:</label>
    <input type="file" name="profile_picture" id="profile_picture"><br>

    <label for="cv">CV:</label>
    <input type="file" name="cv" id="cv"><br>
    <!-- End of form fields for profile picture and CV uploads -->

    <input type="submit" value="Save Changes">
  </form>

  <!-- Display success message or error message, if any -->
  <?php if (isset($message)): ?>
    <p><?php echo $message; ?></p>
  <?php endif; ?>

  <?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
  <?php endif; ?>

</body>

</html>
