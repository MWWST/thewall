<?php
	session_start();
		require('new-connection.php');
			if (isset($_SESSION['first_name'])){
				
			function commentsdisplay() {
					$getcommentsquery= "SELECT messages.id as message_id,comments.id as comment_id,comments.messages_id as comment_message_id,comments.comment, comments.created_at
					FROM comments 
					LEFT JOIN messages on comments.messages_id = messages.id";
					$comments = fetch_all($getcommentsquery);
					
				// foreach ($comments as $comment) {
				// 	// var_dump ($comment);
				// 	if ($comment['message_id'] == $comment['comment_message_id']){
					var_dump($comments);
				// 	}
				}
			}

			function displayposts(){
					$displayquery = "SELECT messages.id as message_id,messages.users_id, users.first_name, users.last_name, messages.id, messages.message, 
					messages.created_at
					FROM users 
					LEFT JOIN messages on users.id = messages.users_id;";
					$messages = fetch_all($displayquery);
					var_dump($messages);
					commentsdisplay();

					// var_dump($messages);
					// var_dump($messages);
					// var_dump($messages); 

					// $getcommentsquery= "SELECT users.first_name, users.last_name,messages.id as message_id,comments.id as comment_id,comments.messages_id as comment_message_id,comments.comment, comments.created_at
					// FROM comments 
					// LEFT JOIN users on comments.users_id = users.id
					// LEFT JOIN messages on comments.messages_id = messages.id";
					// $comments = fetch_all($getcommentsquery);


					// var_dump($messages);
					

					// foreach ($messages as $key => $value) {
					// 	var_dump($value);
					// 	var_dump($value['comment']);
						// var_dump($value['message']);
						// var_dump($value['message_id']);

						// foreach ($value as $message) {
						// 	var_dump($message);
						// }
						
						// foreach ($comments as $comment) {
						// 	var_dump($comment['comment']);
						// }
						// var_dump($comments);
					// }
					

							
						// foreach ($messageset as $message) {
						// 	echo $message ."<br>";
						// }
// 						if (!empty($messageset['message'])){
// 							$msgid = $messageset['id'];
// 							$_SESSION['msgid'] = $msgid;
// 							echo "Message ID". " " . $messageset['id']." ".$messageset['first_name']."  ".$messageset['last_name'].
// 							" ".$messageset['created_at']."<br><b>Post:  </b>".$messageset['message']."<br><br>";
					
							
// 							// commentsdisplay($msgid);
// } ?>
				 
						
							<!-- <form action='process.php' method='post'>
							<textarea name='comment'></textarea>
							<input type='submit' value='Comment'>
							<input type="hidden" name="message" value="<?=$msgid?>"/>
							</form> -->

							 <?php 
							// foreach ($comments as $comment) {
							// $commentid = $comment['comment_message_id'];
							// if ($commentid == $msgid) {
							//  $comment['comment']."<br><br>";
						}
					

			// function displaycomments() {
			// 	$displaycommentquery = "SELECT users.first_name, users.last_name, comments.comment, comments.created_at
			// 	FROM users LEFT JOIN comments on users.id = comments.users_id
			// 	LEFT JOIN messagages on messages.id = comments.messages_id
			// 	WHERE messages.id = comments.messages_id;";
			// 	$comments = fetch_all($displaycommentquery);
			// 	foreach ($comments as $id =>$commentset) {
			// 	echo $commentset['first_name']." ".$commentset['last_name'].
			// 		" ".$commentset['created_at']."<br>".$commentset['comment']."<br>";
			// 	}


				
		
		// else { echo "not logged in"; }
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

	textarea: {
		width:950px;
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
		<div id="user"class="one-half column u-pull-right"> <?php if (isset($_SESSION['first_name'])) { echo "Hello"." ". $_SESSION['first_name']." " .
		" My Account | <a href='process.php'>Logout</a>";} ?> </div>
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
		<div id="returnmsg" class="ten column">
			<?php  if (isset($_SESSION['first_name'])){
			foreach 
			displayposts();

		}
			?>
		</div>
	</div>
</div>

</body>
</html>