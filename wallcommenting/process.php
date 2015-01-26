<?php
	session_start();
	
	require('new-connection.php');

// -----FORM VALIDATIONS FROM ALL PAGES, IF LEGIT CALL THE APPROPRIATE FUNCTION, ELSE DESTROY SESSION AND GO TO HOME---// 

		if (isset($_POST['reg']) && $_POST['reg'] == 'register') 
			{
			register_user($_POST); // use the ACTUAL post
			}

		elseif (isset($_POST['login']) && $_POST['login'] == 'log'){
			login($_POST);
		}

		elseif (isset($_POST['msgpost']) && $_POST['msgpost'] == 'newpost'){
			newpost($_POST);
			
		}

		elseif (isset($_POST['message']) && $_POST['message'] == $_POST['message']) {
			addcomment($_POST);

		}

		elseif (isset($_POST['delete']) && $_POST['delete'] == $_POST['delete']) {
			deletemessage($_POST);
			echo "successfully deleted";
			var_dump($_POST);
			
		}

		else {// malicious navigation to process.php OR someone is trying to log off!
			header('location: index.php');
			session_destroy();
			(die);
	}

// --------------USER REGISTRATION FORM VALIDATIONS-------------------- // 
		function register_user($post){
		
		$_SESSION['errors'] = array(); 	//define session errors array

			if (empty($post['first_name'])) 
			{
				$_SESSION['errors'][] = "You must enter your first name to register";
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

			if(count($_SESSION['errors'])>0) 
				{
					header('location:index.php');
					die();
				}

			else {

				$escaped_first_name = escape_this_string($post['first_name']);
				$escaped_last_name = escape_this_string($post['last_name']);
				$escaped_password = escape_this_string($post['password']);
				$escaped_email = escape_this_string($post['email']);

				$query = "INSERT INTO users (first_name, last_name, password, email, created_at, updated_at)
				VALUES ('{$escaped_first_name}','{$escaped_last_name}','{$escaped_password}','{$escaped_email}',
					NOW(),NOW())";

				run_mysql_query($query);
				$_SESSION['success_message'] = "User succesffuly created";
				header('location:index.php');
				die();

			}

		}
// --------------USER LOGIN FORM VALIDATIONS-------------------- // 
		function login($post) {

			$_SESSION['errors'] = array(); 
			$escaped_email = escape_this_string($post['email']);
			$escaped_password =escape_this_string($post['password']);

			$query = "SELECT * FROM users WHERE users.password ='{$escaped_password}' 
				 AND users.email ='{$escaped_email}'";

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
			 	$_SESSION['errors'][] = "Username and password not found";
			 	header('location: index.php');
				die();
			}

		}
// --------------NEW POST FUNCTION-------------------- // 
		function newpost($post) {

			$escape_session_id = escape_this_string($_SESSION['user_id']);  //mysqli escaping
			$escape_message = escape_this_string($post['message']);
			$postquery = "INSERT INTO messages (users_id, message, created_at, updated_at)  
			VALUES ('{$escape_session_id}','{$escape_message}',NOW(),NOW());";
			run_mysql_query($postquery);
			header('location: wall.php');
			die();

		}

// --------------ADD COMMENT FUNCTION-------------------- // 
		function addcomment($post){
			
			$escaped_comment = escape_this_string($post['comment']); //mysqli escaping
			$escaped_message = escape_this_string($post['message']);
			$escape_session_id = escape_this_string($_SESSION['user_id']);
			$commentquery = "INSERT INTO comments (comment, messages_id, users_id, created_at,updated_at)
			VALUES ('{$escaped_comment}','{$escaped_message}','{$escape_session_id}',NOW(),NOW())";
			run_mysql_query($commentquery);
			header('location: wall.php');
			die();
		}

// --------------DELETE MESSAGE FUNCTION-------------------- // 
		function deletemessage($post) {
			$escaped_post = escape_this_string($post['delete']);
			$commentdeletequery = "DELETE FROM comments WHERE comments.messages_id = {$escaped_post} ;";
			run_mysql_query($commentdeletequery);
			$postdeletequery = "DELETE FROM messages WHERE id = {$escaped_post} ;";
			run_mysql_query($postdeletequery);
			header('location: wall.php');
			die();
		}
?>

