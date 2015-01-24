<?php
session_start();
?>

<html>
<head>
	<title>The Wall Login</title>
	<link rel="stylesheet" href="./css/skeleton.css">
</head>
<body>

<div id="login" class="one-third column">
		<h3>Login</h3>
		<form action="process.php" method="post">
		Email Address<input type="text" name ="email"><br>
		Password<input type="password" name ="password"><br>
		<input type ="submit" value ="login">
		<input type ="hidden"  name="login" value="log">
	</form>
</div>

<div id="register" class="two-thirds column">
		<?php

	if (isset($_SESSION['errors']))
	{
		foreach ($_SESSION['errors'] as $error) 
		{
			echo "<p class='error'>{$error}</p>";
			// var_dump($_SESSION);
		}
		unset($_SESSION['errors']);
	}
	if (isset($_SESSION['success_message'])){
		echo "<p class='success'>{$_SESSION['success_message']}</p>";
		unset($_SESSION['success_message']);
	}

	?>
	<h3>Register</h3>
	<form action="process.php" method="post">
		First Name<input type="text" name ="first_name"><br>
		Last Name<input type="text" name ="last_name"><br>
		Email Address<input type="text" name ="email"><br>
		Password<input type="password" name ="password"><br>
		Confirm Password<input type="password" name ="password_confirm"><br>
		<input type="submit" value="register">
		<input type="hidden" name="reg" value="register">
	</form>
</div>

</body>
</html>