<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>QR Code Generator - Landing Page</title>
	<link rel="icon" type="image/x-icon" href="https://aureauae.com/testing/aiorganics/images/logo/favicon.png">
	<!-- Bootstrap 5 -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
	<!-- Font Awesome for Icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<!-- SweetAlert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<style>
		body {
			background: linear-gradient(-45deg, #6a11cb, #2575fc, #ff512f, #dd2476);
			background-size: 400% 400%;
			animation: gradientBG 10s ease infinite;
			color: white;
			font-family: "Poppins", sans-serif;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			text-align: center;
		}

		@keyframes gradientBG {
			0% {
				background-position: 0% 50%;
			}

			50% {
				background-position: 100% 50%;
			}

			100% {
				background-position: 0% 50%;
			}
		}

		.container-box {
			background: rgba(255, 255, 255, 0.2);
			padding: 40px;
			border-radius: 15px;
			backdrop-filter: blur(10px);
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
		}

		.btn-custom {
			background: #ff512f;
			color: white;
			transition: 0.3s;
		}

		.btn-custom:hover {
			background: #dd2476;
			transform: scale(1.05);
		}

		.modal-content {
			background: rgba(255, 255, 255, 0.9);
			border-radius: 10px;
		}
	</style>
</head>

<body>
	<div class="container-box">
		<h1>QR Code Generator</h1>
		<p>Sign up or log in to generate and manage your QR codes.</p>
		<button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</button>
		<button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
	</div>

	<!-- Sign Up Modal -->
	<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content p-4">
				<h3 id="signupModalLabel" class="text-center">Sign Up</h3>
				<form id="signupForm">
					<div class="mb-3">
						<input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name"
							autocomplete="name" required>
					</div>
					<div class="mb-3">
						<input type="text" class="form-control" id="username" name="username" placeholder="Username"
							autocomplete="username" required>
					</div>
					<div class="mb-3">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email"
							autocomplete="email" required>
					</div>
					<div class="mb-3">
						<input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number"
							pattern="[0-9]{10}" autocomplete="tel" required>
					</div>
					<div class="mb-3">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password"
							autocomplete="new-password" required>
					</div>
					<div class="mb-3">
						<input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
							placeholder="Confirm Password" autocomplete="new-password" required>
					</div>
					<button type="submit" class="btn btn-primary w-100">Sign Up</button>
				</form>
			</div>
		</div>
	</div>

	<!-- Login Modal -->
	<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content p-4">
				<h3 id="loginModalLabel" class="text-center">Login</h3>
				<form id="loginForm">
					<div class="mb-3">
						<input type="email" class="form-control" id="loginEmail" name="loginEmail" placeholder="Email"
							autocomplete="email" required>
					</div>
					<div class="mb-3">
						<input type="password" class="form-control" id="loginPassword" name="loginPassword"
							placeholder="Password" autocomplete="current-password" required>
					</div>
					<button type="submit" class="btn btn-primary w-100">Login</button>
				</form>
			</div>
		</div>
	</div>

	<script>
		document.getElementById("signupForm").addEventListener("submit", function (event) {
			event.preventDefault();
			let password = document.getElementById("password").value;
			let confirmPassword = document.getElementById("confirmPassword").value;
			let phone = document.getElementById("phone").value;

			if (password !== confirmPassword) {
				Swal.fire("Error", "Passwords do not match", "error");
				return;
			}
			if (!/^[0-9]{10}$/.test(phone)) {
				Swal.fire("Error", "Enter a valid 10-digit phone number", "error");
				return;
			}
			Swal.fire("Success", "Sign Up Successful!", "success");
		});

		document.getElementById("loginForm").addEventListener("submit", function (event) {
			event.preventDefault();
			let formData = new FormData(this);
			fetch("login.php", {
				method: "POST",
				body: formData
			})
				.then(response => response.text())
				.then(data => {
					if (data.trim() === "success") {
						Swal.fire({
							title: "Success!",
							text: "Login successful! Redirecting...",
							icon: "success",
							timer: 2000,
							showConfirmButton: false
						}).then(() => {
							window.location.href = "dashboard.php";
						});
					} else {
						Swal.fire("Error", data, "error");
					}
				})
				.catch(error => console.error("Error:", error));
		});
	</script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>





