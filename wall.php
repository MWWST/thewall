<?php
session_start();
require('new-connection.php');
function displayposts(){
		$displayquery = "SELECT messages.id,users.first_name, users.last_name, messages.message, messages.created_at
		FROM users LEFT JOIN messages on users.id = messages.users_id;";
		$messages = fetch_all($displayquery);
		foreach ($messages as $id =>$messageset) {
			// foreach ($messageset as $message) {
				$msgid = $messageset['id'];
				echo $messageset['id'],$messageset['first_name']." ".$messageset['last_name']." ".$messageset['created_at']."<br>".$messageset['message']."<br>".
				"<form action='process.php' method='post'>
				<textarea name='comment'></textarea>
				<input type='submit' value='Comment'>
				<input type='hidden' name='comment' value ='$msgid'>
				</form>";

			}
		// var_dump($messages);
		var_dump($messageset);
		}

	
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
		<form action="process.php" method ="post">
		<textarea name="message"></textarea>
		</div>
		<div class= "u-pull-right">
		
		<input type="submit" value="Add Post">
		<input type ="hidden" name ="msgpost" value="newpost">
		</form>
		</div>
		<div id="returnmsg">
			<?php 
			displayposts();
			?>
		</div>
	</div>
</div>

</body>
</html>