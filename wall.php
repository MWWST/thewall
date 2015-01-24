<?php
session_start();
require('new-connection.php');
?>

<html>
<head>
	<title>Welcome to the wall</title>
	<link rel="stylesheet" href="./css/skeleton.css">
	<style>
	#messages {
		border: 1px solid #000000;
	}

	form {
		padding-top: 10px;
	}

	#user {
		text-align: right;
	}
	</style>
</head>
<body>
<div id="container" class="container">
	<div id="header" class="row">
		<div id="logo" class="one-half column"><h1>The Wall</h1></div>
		<div id="user"class="one-half column u-pull-right"> <?="Hello"." ". $_SESSION['first_name']." ";
	echo " | My Account | <a href='process.php'>Logout</a>";?></div>
	</div>
	<div id="messagescont" class="row">
		<div id="messages" class="ten column">
		Messages go here
		</div>
		<div class= "u-pull-right">
		<form action="process.php" method ="post">
		<input type="submit" value="Add Post">
		<input type ="hidden" name ="post" value="newpost">
		</form>
		</div>
	</div>
</div>

</body>
</html>