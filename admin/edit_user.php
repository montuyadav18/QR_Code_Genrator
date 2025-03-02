<?php
include '../db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    $sql_update = "UPDATE users SET full_name=?, email=?, role=? WHERE id=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $full_name, $email, $role, $user_id);

    if ($stmt_update->execute()) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error updating user!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Full Name:</label>
                <input type="text" name="full_name" value="<?= $user['full_name'] ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" value="<?= $user['email'] ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label>Role:</label>
                <select name="role" class="form-control">
                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</body>
</html>
