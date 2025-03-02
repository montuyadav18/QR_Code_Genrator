<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["fullName"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);

    if (empty($full_name) || empty($username) || empty($email) || empty($phone) || empty($password)) {
        die("Error: All fields are required!");
    }

    // Hash password securely
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Check if username already exists
    $sql_check = "SELECT id FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    if (!$stmt_check) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // If username exists, update email and password
        $stmt_check->close();
        $sql_update = "UPDATE users SET email = ?, password_hash = ? WHERE username = ?";
        $stmt_update = $conn->prepare($sql_update);
        if (!$stmt_update) {
            die("Error preparing update statement: " . $conn->error);
        }
        $stmt_update->bind_param("sss", $email, $password_hash, $username);
        if ($stmt_update->execute()) {
            echo "User updated successfully!";
        } else {
            die("Error updating user: " . $stmt_update->error);
        }
        $stmt_update->close();
    } else {
        // If username does not exist, insert new user
        $stmt_check->close();
        $sql_insert = "INSERT INTO users (full_name, username, email, phone, password_hash, role) VALUES (?, ?, ?, ?, ?, 'user')";
        $stmt_insert = $conn->prepare($sql_insert);
        if (!$stmt_insert) {
            die("Error preparing insert statement: " . $conn->error);
        }
        $stmt_insert->bind_param("sssss", $full_name, $username, $email, $phone, $password_hash);
        if ($stmt_insert->execute()) {
            echo "Signup successful!";
        } else {
            die("Error inserting user: " . $stmt_insert->error);
        }
        $stmt_insert->close();
    }

    $conn->close();
}
?>
