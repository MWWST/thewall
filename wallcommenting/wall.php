<?php
	session_start(); 
		require('new-connection.php');  										// require database connection
		if (isset($_SESSION['first_name'])){ 								//make sure a user is logged in, probably should use userid?
			
		function commentsdisplay($mid) { 									//display comments function which is called within the display posts function
				$getcommentsquery= "SELECT users.first_name, users.last_name,messages.id as message_id,comments.id as comment_id,
				comments.messages_id as comment_message_id,comments.comment, date_format(comments.created_at,'%a %b %e %Y %r') 
				as formatted_date
				FROM comments 
				LEFT JOIN users on comments.users_id = users.id
				LEFT JOIN messages on comments.messages_id = messages.id";
				$comments = fetch_all($getcommentsquery);
				foreach ($comments as $key => $value) {   					// get each comment from the comment set
					if ($mid == $value['comment_message_id']){
					echo "<div id='comments'><i>".$value['comment']." Made by: 
					".$value['first_name']." ".$value['last_name']." ".$value['formatted_date']."</i><br></div>";
				} 															// if the message id is equal to he comment message id, pring the above items
			}
		}
		function displayposts(){
				$displayquery = "SELECT messages.id as message_id,messages.users_id as user_message_id, users.first_name, 
				users.last_name, messages.id, messages.message, 
				date_format(messages.created_at,'%a %b %e %Y %r') as formatted_msg_date, messages.created_at,NOW(),TIMEDIFF(NOW(),
				messages.created_at)/60 as timedifference
				FROM users 
				LEFT JOIN messages on users.id = messages.users_id
				ORDER BY messages.created_at DESC;";

				$messages = fetch_all($displayquery);
				// var_dump($messages); 
				foreach ($messages as $id =>$messageset) { 					// loop through each message set in the messages the array with our query data
					if (!empty($messageset['message'])){ 					// if the message is not empty, set the msg to message set id, set a msgdel id and session msgid
						$msgid = $messageset['id']; 						//msgid is passed via hidden input to process.php when adding a new comment
						$msgdelid = $messageset['id']; 						// msgdelid is passed via hidden input to process.php when deleting a post 
						echo "<b>".$messageset['first_name']." ".$messageset['last_name']." </b> ".$messageset['id']." "
						. "On ".$messageset['formatted_msg_date']." <br> ".$messageset['message']."  ";
									
						if ($_SESSION['user_id'] == $messageset['user_message_id'] && 
						$messageset['timedifference'] < 1) {  				// make sure user id of logged in user is same as message id and that the time since last post is less than one minute or whatever time we want to set
?> 								<form action='process.php' method='post'>   
								<input type='submit' value='Delete'>
								<input type="hidden" name="delete" value="<?=$msgdelid?>"/>
							</form>
<?php 						}
							echo "<br><br><b>Comments:</b><br>";  			 //if time is less than limit set, above the above form displays a delete button for the users post
							commentsdisplay($msgid);   						// display comments for each message, calls comments function see above
?>							<form action='process.php' method='post'>
						<textarea name='comment'></textarea>
						<input type='submit' value='Comment'>
						<input type="hidden" name="message" value="<?=$msgid?>"/>
						</form>
<?php  					 
}?> 							
<?php 
					}		
				}
			}
?>
<html>
	<head>
		<title>Welcome to the wall</title>
		<link rel="stylesheet" href="./css/skeleton.css">
		<style>
			#messages {
				border: 1px solid #CCCCCC;
				margin-bottom: 10px;
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

			#comments {
				margin-left: 20px;
			}
		</style>
	</head>
	<body>
		<div id="container" class="container">
			<div id="header" class="row">
				<div id="logo" class="one-half column"><h1>The Wall</h1><h5>Please write all over me!</h5></div>
				<div id="user"class="one-half column u-pull-right"> <?php if (isset($_SESSION['first_name'])) { echo "Hello"." ". $_SESSION['first_name']." " .
				" My Account | <a href='process.php'>Logout</a>";} ?> 
				</div>
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
					(displayposts());
				}
					?>
				</div>
			</div>
		</div>
	</body>
</html>