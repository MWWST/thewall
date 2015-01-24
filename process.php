<?php
session_start();
// var_dump($_POST);
require('new-connection.php');

	if (isset($_POST['reg']) && $_POST['reg'] == 'register') 
		{
		// echo "i am set";
		register_user($_POST); // use the ACTUAL post
		}

	elseif (isset($_POST['login']) && $_POST['login'] == 'log'){

		login($_POST);
	}

	else // malicious navigation to process.php OR someone is trying to log off!

		session_destroy();
		header('location: index.php');
		die();


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


?>

