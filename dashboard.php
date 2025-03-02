<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["email"])) {
    // Redirect to login page if session variables are not set
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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
            cursor: pointer;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        .table-container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4 class="text-center">User Panel</h4>
        <a onclick="showSection('profile')"><i class="fas fa-user"></i> Profile</a>
        <a onclick="showSection('generateQR')"><i class="fas fa-qrcode"></i> Generate QR Code</a>
        <a onclick="showSection('settings')"><i class="fas fa-cogs"></i> Settings</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <h2 class="text-center">User Dashboard</h2>

        <div id="profile" class="section">
            <h3>Profile Section</h3>
            <div class="container mt-5">
                <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
                <p>Email: <?php echo $_SESSION["email"]; ?></p>
            </div>
        </div>

        <div id="generateQR" class="section" style="display:none;">
            <h3 class="text-center">Generate Your QR Code</h3>
            <p class="text-center">Enter details to generate a QR code.</p>
            <form id="qrForm" class="w-50 mx-auto">
                <input type="text" class="form-control mb-3" id="company" placeholder="Company Name" required>
                <input type="url" class="form-control mb-3" id="website" placeholder="Website URL" required>
                <button type="submit" class="btn btn-primary">Generate QR Code</button>
            </form>
            <div id="qrcode" class="mt-3 text-center"></div>

            <div class="table-container">
                <h3 class="text-center">Generated QR Codes</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Website URL</th>
                            <th>QR Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="qrTableBody"></tbody>
                </table>
            </div>
        </div>

        <div id="settings" class="section" style="display:none;">
            <h3>Settings</h3>
            <p>Settings details go here.</p>
        </div>
    </div>

    <script>
        function showSection(section) {
            document.querySelectorAll('.section').forEach(el => el.style.display = 'none');
            document.getElementById(section).style.display = 'block';
        }

        document.addEventListener("DOMContentLoaded", loadStoredData);

        document.getElementById("qrForm").addEventListener("submit", function (event) {
            event.preventDefault();
            let company = document.getElementById("company").value.trim();
            let website = document.getElementById("website").value.trim();

            if (!company || !website) {
                alert("Please fill in all fields.");
                return;
            }

            let qr = new QRCode(document.createElement("div"), { text: website, width: 100, height: 100 });

            setTimeout(() => {
                let qrCanvas = qr._el.firstChild;
                let qrImage = qrCanvas.toDataURL("image/png");

                let newData = { company, website, qrImage };
                saveData(newData);
                addRowToTable(newData);

                document.getElementById("company").value = "";
                document.getElementById("website").value = "";
            }, 500);
        });

        function saveData(data) {
            let storedData = JSON.parse(localStorage.getItem("qrData")) || [];
            storedData.push(data);
            localStorage.setItem("qrData", JSON.stringify(storedData));
        }

        function loadStoredData() {
            let storedData = JSON.parse(localStorage.getItem("qrData")) || [];
            storedData.forEach(addRowToTable);
        }

        function addRowToTable(data) {
            let newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${data.company}</td>
                <td><a href="${data.website}" target="_blank">${data.website}</a></td>
                <td><img src="${data.qrImage}" width="100"></td>
                <td><button class="btn btn-danger btn-sm" onclick="deleteRow(this, '${data.website}')">Delete</button></td>
            `;
            document.getElementById("qrTableBody").appendChild(newRow);
        }

        function deleteRow(button, website) {
            let row = button.parentElement.parentElement;
            row.remove();

            let storedData = JSON.parse(localStorage.getItem("qrData")) || [];
            storedData = storedData.filter(item => item.website !== website);
            localStorage.setItem("qrData", JSON.stringify(storedData));
        }
    </script>
</body>

</html>
