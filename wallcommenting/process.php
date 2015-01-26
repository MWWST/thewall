<?php
session_start();
// var_dump($_POST);
require('new-connection.php');
// var_dump($_POST['$msgid']);

	if (isset($_POST['reg']) && $_POST['reg'] == 'register') 
		{
		// echo "i am set";
		register_user($_POST); // use the ACTUAL post
		}

	elseif (isset($_POST['login']) && $_POST['login'] == 'log'){

		login($_POST);
	}

	elseif (isset($_POST['msgpost']) && $_POST['msgpost'] == 'newpost'){

		newpost($_POST);
		
	}

	elseif (isset($_POST['message']) && $_POST['message'] == $_POST['message']) {
		// var_dump($_POST['message']);
		// var_dump($_POST['comment']);
		// var_dump($_POST);
		// echo "got it";
		addcomment($_POST);

	}

	elseif (isset($_POST['delete']) && $_POST['delete'] == $_POST['delete']) {
		deletemessage($_POST);
		echo "successfully deleted";
		var_dump($_POST);
		
	}

	else {// malicious navigation to process.php OR someone is trying to log off!
		// echo "comment_delte not working";
		// var_dump($_POST);
		// displaycomments();
		// var_dump($_POST['message']);
		header('location: index.php');
		session_destroy();
		(die);
		
		// die();
}

	function register_user($post){
	
	$_SESSION['errors'] = array(); 	//define session errors array

		if (empty($post['first_name'])) 
		{
			$_SESSION['errors'][] = "You must enter your first name to register";
					// var_dump($_SESSION['errors']);
		}	
		
		if (empty($post['last_name'])) 
		{
			$_SESSION['errors'][] = "You must enter your last name to register";
		}	

		if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['errors'][] = "You must enter a valid email to register";
		}	

		if (empty($post['password'])) 
		{
			$_SESSION['errors'][] = "You must enter your password to register";
		}	

		// var_dump($_SESSION['errors']);

		if(count($_SESSION['errors'])>0) // if any errors
			{
				header('location:index.php');
				die();
			}

		else {

			$query = "INSERT INTO users (first_name, last_name, password, email, created_at, updated_at)
			VALUES ('{$post['first_name']}','{$post['last_name']}','{$post['password']}','{$post['email']}',
				NOW(),NOW())";

			// var_dump($query);	

			run_mysql_query($query);
			$_SESSION['success_message'] = "User succesffuly created";
			header('location:index.php');
			die();


		}

	}

	function login($post) {

		$query = "SELECT * FROM users WHERE users.password ='{$post['password']}' 
			 AND users.email ='{$post['email']}'";

	 	$user = fetch_all($query);

		if (count($user)>0)
		{
			$_SESSION['user_id'] = $user[0]['id'];
			$_SESSION['first_name'] = $user[0]['first_name'];
			$_SESSION['logged_in'] = TRUE;
			header('location: wall.php');
			die();
		}
		else
		 {
		 	$_SESSION['errors'] = "Username and password not Found";
		 	header('location: index.php');
			die();
		}

	}

	function newpost($post) {

		$postquery = "INSERT INTO messages (users_id, message, created_at, updated_at)
		VALUES ('{$_SESSION['user_id']}','{$post['message']}',NOW(),NOW())";
		run_mysql_query($postquery);
		header('location: wall.php');
		die();

	}

	function displayposts(){
		$displayquery = "SELECT users.first_name, users.last_name, messages.message, messages.created_at
		FROM users LEFT JOIN messages on users.id = messages.users_id;";
		$messages = fetch_all($displayquery);
		// var_dump($messages);
		}

	function addcomment($post){
		$commentquery = "INSERT INTO comments (comment, messages_id, users_id, created_at,updated_at)
		VALUES ('{$post['comment']}','{$post['message']}','{$_SESSION['user_id']}',NOW(),NOW())";
		// var_dump($commentquery);
		run_mysql_query($commentquery);
		// echo "successfully added to db";
		header('location: wall.php');
		die();
	}

	function deletemessage($post) {
		$commentdeletequery = "DELETE FROM comments WHERE comments.messages_id = {$post['delete']} ;";
		run_mysql_query($commentdeletequery);
		// var_dump($commentdeletequery);
		$postdeletequery = "DELETE FROM messages WHERE id = {$post['delete']} ;";
		// echo "success";
		run_mysql_query($postdeletequery);
		header('location: wall.php');
		die();
	}

	

	


?>

