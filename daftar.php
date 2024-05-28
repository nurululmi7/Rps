<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projek_web";

    // Create connection
    $conn = new mysqli($servername, $username,$email, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . " (Error Code: " . $conn->connect_errno . ")");
    }
    echo "Connected successfully";

    // Sanitize and retrieve the input
    $nama_lengkap = $conn->real_escape_string($_POST['nama_lengkap']);
    $user_name = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password with bcrypt

    // Check if username or email already exists
    $check_user = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$email'");
    if ($check_user->num_rows > 0) {
        echo "Username or email already exists.";
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (nama_lengkap, username, email, password) VALUES ('$nama_lengkap', '$username', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            echo "Registrasi berhasil!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
