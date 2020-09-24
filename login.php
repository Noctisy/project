<!-- Yusa Celiker -->
<!DOCTYPE html>
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
				<input type="text" name="pword" placeholder="Password" required/>
				<input type='submit' name='Submit' value='Submit' />
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
