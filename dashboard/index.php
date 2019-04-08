<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit();
}
?>

<?php include 'header.php'; ?>


<div id="wrapper_content_loggedin">
	<div id="menu">
	<?php
		echo 'Logged in as ' . $_SESSION['name'] . '!';
	?>
		<div id="menu_logout">
			<a href="logout.php" class="logout-button">Logout</a>
		</div>
	</div>
	<div id="main_content">
		qdssdfd
	</div>
</div>

<?php include 'footer.php'; ?>