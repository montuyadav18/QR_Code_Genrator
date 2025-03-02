<?php
include '../db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error deleting user!";
    }
}
?>
