<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px;
            display: block;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <a href="#"><i class="fas fa-home"></i> Dashboard</a>
        <a href="#"><i class="fas fa-users"></i> Users</a>
        <a href="#"><i class="fas fa-cogs"></i> Settings</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    
    <div class="content">
        <h2 class="text-center">Admin Dashboard</h2>
        <table class="table table-striped table-hover mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';
                $sql = "SELECT id, full_name, username, email, phone, role FROM users";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['full_name']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['role']}</td>
                                <td>
                                    <a href='edit_user.php?id={$row['id']}' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a>
                                    <button class='btn btn-danger btn-sm' onclick='confirmDelete({$row['id']})'><i class='fas fa-trash'></i> Delete</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `delete_user.php?id=${userId}`;
                }
            });
        }
    </script>
</body>
</html>
