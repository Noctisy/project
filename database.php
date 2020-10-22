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
  private $database;
  private $user;
  private $pass;
  private $charset;
  private $pdo;

  const ADMIN = 1; // moet overeen komen met values in de db!
  const USER = 2;

  public function __construct($host, $user, $pass, $database, $charset){
    $this->host = $host;
    $this->user = $user;
    $this->pass = $pass;
    $this->database = $database;
    $this->charset = $charset;

    try {
        $dsn = "mysql:host=$host;dbname=$database;charset=$charset";
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

  private function create_or_update_account($username, $email, $pass){
    // todo: fixme: add usertype_id to the account table (bij de insert fk ref)
    // maak een sql statement (type string)
    $query = "INSERT INTO account
          (id, type_id, username, email, password, created_at, updated_at )
          VALUES
          (NULL, :type_id, :username, :email, :password, :created_at, :updated_at)";

    // prepared statement -> statement zit een statement object in (nog geen data!)
    $statement = $this->pdo->prepare($query);

    // password hashen
    $hashed_password =  password_hash($pass, PASSWORD_DEFAULT);

    // huidige datetime ophalen in php, en deze meegeven aan de assoc array in de execute
    $created_at = date('Y-m-d H:i:s');
     $updated_at = date('Y-m-d H:i:s');

    // execute de statement (deze maakt de db changes)
    $statement->execute([
    'type_id'=>self::USER,
    'username'=>$username,
    'email'=>$email,
    'password'=>$hashed_password,
    'created_at'=>$created_at,
    'updated_at'=>$updated_at
  ]);

    // haalt de laatst toegevoegde id op uit de db
    $account_id = $this->pdo->lastInsertId();
    return $account_id;
  }


  private function create_or_update_persoon($fname, $mname, $lname, $account_id){
    // table person vullen
    $query = "INSERT INTO person
          (id, account_id, first_name, middle_name, last_name, created_at, updated_at)
          VALUES
          (NULL, :account_id, :fname, :mname, :lname, :created_at, :updated_at)";

    // returned een statmenet object
    $statement = $this->pdo->prepare($query);

    $created_at = $updated_at = date('Y-m-d H:i:s');

    // execute prepared statement
    $statement->execute([
    'account_id'=>$account_id,
    'fname'=>$fname,
    'mname'=>$mname,
    'lname'=>$lname,
    'created_at'=>$created_at,
    'updated_at'=>$updated_at
  ]);
}

  public function create_or_update_user($uname, $fname, $mname, $lname, $pass, $email){

    try{
      // begin een database transaction
      $this->pdo->beginTransaction();

      $account_id = $this->create_or_update_account($uname, $email, $pass);

      $this->create_or_update_persoon($fname, $mname, $lname, $account_id);

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
