<!-- Yusa Celiker -->
<?php

include 'database.php';

$db = new database('localhost', 'root', '', 'project1', 'utf8');


//if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $username = $_POST['uname'];
  $firstname = $_POST['fname'];
  $middlename = $_POST['mname'];
  $lastname = $_POST['lname'];
  $password =$_POST['pwd'];
  $email = $_POST['email'];

  $db->insert($username, $firstname, $middlename, $lastname, $password, $email);
//}


 ?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Registratie scherm</title>
  </head>

  <body>
  	<form method="post" action='register.php' method='post' accept-charset='UTF-8'>
      <fieldset >
        <legend>Registratie</legend>
        <input type="text" name="uname" placeholder="Gebruikersnaam" required/>
        <input type="text" name="fname" placeholder="Voornaam" required/>
      	<input type="text" name="mname" placeholder="Middelnaam" />
      	<input type="text" name="lname" placeholder="Achternaam" required/><br/>
        <input type="email" name="email" placeholder="E-mail" required/>
        <input type="password" name="pwd" placeholder="Wachtwoord" required/>
        <input type="password" name="repeatpwd" placeholder="Herhaal wachtwoord" required/>
        <input type="submit" value"Sign up!"/>
      </fieldset>
      <a href="login.php">Ik heb al een account. Login!</a>
    </form>
  </body>
</html>
