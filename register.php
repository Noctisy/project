<!-- Yusa Celiker -->

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
        <input type="text" name="uname" placeholder="Voornaam" required/>
      	<input type="text" name="mname" placeholder="Middelnaam" required/>
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
