<?php
	session_start();
		// Change this to your connection info.
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = 'root';
		$DATABASE_NAME = 'cat_docqueue';
		// Try and connect using the info above.
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		if ( mysqli_connect_errno() ) {
			// If there is an error with the connection, stop the script and display the error.
			die ('Failed to connect to MySQL: ' . mysqli_connect_error());
		}		
		// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
		if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
			$stmt->bind_param('s', $_POST['username']);
			$stmt->execute();
			// Store the result so we can check if the account exists in the database.
			$stmt->store_result();
				if ($stmt->num_rows > 0) {
				$stmt->bind_result($id, $password);
				$stmt->fetch();
				// Account exists, now we verify the password.
				// Note: remember to use password_hash in your registration file to store the hashed passwords.
				if ($_POST['password'] === $password) {
					// Verification success! User has loggedin!
					// Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $_POST['username'];
					$_SESSION['id'] = $id;
					header('Location: index.php');
				} else {
					echo "<script type='text/javascript'>";
					echo "alert('Press Enter or OK to go to the login screen.');";
					echo "</script>";
				}
			} else {
				echo "<script type='text/javascript'>";
				echo "alert('Press Enter or OK to go to the login screen.');";
				echo "</script>";
			}
			$stmt->close();
		}
?>

<?php include 'header.php'; ?>

<div id="wrapper_login">
	<div id="login_title">
		<div class="login-title">
			Login
		</div>
	</div>
	<div id="login_field">
			<form action="login.php" method="post">
				<input type="text" id="login_username" name="username" placeholder="Username" value="<?php echo $username; ?>" />
				<br>
				<input type="password" id="login_password" name="password" placeholder="Password" />
				<br>
				<input type="submit" id="button_submit" value="Login" />
			</form>
	</div>
</div>

<?php include 'footer.php'; ?>