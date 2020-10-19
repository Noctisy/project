<!-- Yusa Celiker -->
<?php

// $host = '127.0.0.1';
// $db   = 'project1';
// $user = 'root';
// $pass = '';
// $charset = 'utf8mb4';

//class database aan gemaakt
class database{
  // class met allemaal private variables aangemaakt (property)
  private $host;
  private $db;
  private $user;
  private $pass;
  private $charset;
  private $pdo;

  public function __construct($host, $user, $pass, $db, $charset){
    $this->host = $host;
    $this->user = $user;
    $this->pass = $pass;
    $this->charset = $charset;

    try {
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        echo $e->getMessage();
        throw $e;
        // throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
  }

  private function create_or_update_account($email, $pass, $username){
    // todo: fixme: add usertype_id to the account table (bij de insert fk ref)
    // maak een sql statement (type string)
    $query = "INSERT INTO account
          (email, password, username)
          VALUES
          (:email, :password, :username)";

    // prepared statement -> statement zit een statement object in (nog geen data!)
    $statement = $this->pdo->prepare($query);

    // password hashen
    $hashed_password =  password_hash($pass, PASSWORD_DEFAULT);

    // execute de statement (deze maakt de db changes)
    $statement->execute(['email'=>$email, 'password'=>$hashed_password, 'username'=>$username]);

    // haalt de laatst toegevoegde id op uit de db
    $account_id = $this->pdo->lastInsertId();
    return $account_id;
  }

  private function create_or_update_persoon($uname, $fname, $mname, $lname, $account_id){
    // table person vullen
    $query = "INSERT INTO persoon
          (account_id, firstname, middlename, lastname)
          VALUES
          (:account_id, :firstname, :middlename, :lastname)";

    // returned een statmenet object
    $statement = $this->pdo->prepare($query);

    // execute prepared statement
    $statement->execute(['account_id'=>$account_id, 'firstname'=>$fname, 'middlename'=>$mname, 'lastname'=>$lname ]);

    $persoon_id = $this->pdo->lastInsertId();
    return $persoon_id;
  }

  public function create_or_update_user($uname, $fname, $mname, $lname, $pass, $email){

    try{
      // begin een database transaction
      $this->pdo->beginTransaction();

      $account_id = $this->create_or_update_account($email, $pass, $uname);

      $this->create_or_update_persoon($uname, $fname, $mname, $lname, $account_id);

      // commit
      $this->pdo->commit();

      header("location:login.php");
      exit();

    }catch(Exception $e){
      // undo db changes in geval van error
      $this->pdo->rollback();
      throw $e;
    }
  }

  public function authenticate_user($uname, $pass){
    // hoe logt te user in? email of username of allebei? = username
    // haal de user op uit account a.d.h.v. de username
    // als database match, dan haal je het password (query with pdo)
    // $hashed_password = password uit db (matchen met $pass)
    // alle alle data overeen komt, dan kun je redirecten naar een interface
    // stel geen match -> username and/or password incorrect message

    // echo hi $_SESSION['username']; htmlspecialchars()

    // maak een statement object op basis van de mysql query en sla deze op in $stmt
    $query = "SELECT password FROM account WHERE username = :username";
    $stmt = $this->pdo->prepare($query);

    // prepared statement object will be executed.
    $stmt->execute(['username' => $uname]); //-> araay
    $result = $stmt->fetch(); // returned een array

    // haalt de hashed password value op uit de db dataset
    $hashed_password = $result['password'];

    $authenticated_user = false;

    if ($uname && password_verify($pass, $hashed_password)){
      $authenticated_user = true;
        header('location: welcome.php'); // todo: fixme, create page
        exit();
    } else {
        echo "invalid username and/or password";
    }

    if($authenticated_user){
      // include date in title of log file -> error_log_8_10_2020.txt
      error_log("datetime, ip address, username - has succesfully logged in",3, error_log.txt);// login datetime, ip address, usernameaction and whether its succesfull
    }else{
      error_log("Invalid login",3);
    }


  //   try{
  //     // begin een database transaction
  //     $this->pdo->beginTransaction();
  //
  //     $this->create_or_update_account($uname, $pass);
  //
  //     // commit
  //     $this->pdo->commit();
  //     exit();
  //
  //   }catch(Exception $e){
  //     // undo db changes in geval van error
  //     $this->pdo->rollback();
  //     throw $e;
  //
  // }
}
}
 ?>
