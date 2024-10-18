<?php
include 'connect.php';

if (isset($_POST['signUp'])) {
    // Sanitize and validate inputs
    $firstName = htmlspecialchars(trim($_POST['fName']), ENT_QUOTES, 'UTF-8');
    $lastName = htmlspecialchars(trim($_POST['lName']), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Not sanitizing password to avoid removing special characters

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user
        $insertQuery = $conn->prepare("INSERT INTO user (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
        $insertQuery->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

        if ($insertQuery->execute() === TRUE) {
            header("Refresh: 3; URL=index.php"); // Delay of 3 seconds
            echo '<script>alert("Registration successful. Redirecting...");</script>';
            exit();
        } else {
            echo "Error: " . $conn->error;
        }

        $insertQuery->close();
    }

    $checkEmail->close();
}

if (isset($_POST['signIn'])) {
    // Sanitize and validate inputs
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Not sanitizing password to avoid removing special characters

    // Get the user from the database
    $sql = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['email'] = $row['email'];
            header("Refresh: 2; URL=homepage.php"); // Delay of 3 seconds
            echo '<script>alert("Login successful. Redirecting...");</script>';
            exit();
        } else {
            // Display an alert for incorrect credentials
            echo '<script>alert("Incorrect Email or Password");</script>';
            header("Refresh: 1; URL=index.php"); // Delay of 3 seconds
            exit();
        }
    } else {
        // Display an alert for not found credentials
        echo '<script>alert("Not Found, Incorrect Email or Password");</script>';
        header("Refresh: 1; URL=index.php"); // Delay of 3 seconds
        exit();
    }
    // $sql -> close();
}

$conn->close();
?>
