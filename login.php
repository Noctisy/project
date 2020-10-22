<!-- Yusa Celiker -->
<?php

include 'database.php';
include 'helperfunctions.php';

  // maak een array met alle name attributes
  $fields = [
    	"uname",
      "pword"
  ];

$obj = new HelperFunctions();
$no_error = $obj->has_provided_input_for_required_fields($fields);

  // in case of field values, proceed, execute insert
if($no_error){
  $username = $_POST['uname'];
  $password = $_POST['pword'];

  $db = new database('localhost', 'root', '', 'project1', 'utf8');
  $db->authenticate_user($username, $password);
}


 ?>


<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>login pagina</title>
	</head>
	<body>
		<form id='login' action='login.php' method='post' accept-charset='UTF-8'>
			<fieldset >
				<legend>Login</legend>
				<input type="text" name="uname" placeholder="Username" required/>
				<input type="password" name="pword" placeholder="Password" required/>
        <input type='submit' name="submit" value='submit' />
			</fieldset>

		  	<p>
		  		Not a member? <a href="register.php">Sign Up</a>
		  	</p>
		  	<p>
		  		Reset Password? <a href="reset.php">Reset</a>
		  	</p>
		</form>
	</body>
</html>
