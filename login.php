<?php

session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["loginEmail"];
    $password = $_POST["loginPassword"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password_hash"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $row["email"];

            echo "success";
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with this email!";
    }
}

?>