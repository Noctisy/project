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

  public function insert($uname, $fname, $mname, $lname, $pass, $email){

    try{
      // begin een database transaction
      $this->pdo->beginTransaction();

      // maak een sql statement (type string)
      $query = "INSERT INTO account
            (email, password)
            VALUES
            (:email, :password)";

      // prepared statement -> statement zit een statement object in (nog geen data!)
      $statement = $this->pdo->prepare($query);

      // password hashen
      $hashed_password =  password_hash($pass, PASSWORD_DEFAULT);

      // execute de statement (deze maakt de db changes)
      $statement->execute(['email'=>$email, 'password'=>$pass]);

      // haalt de laatst toegevoegde id op uit de db
      $account_id = $this->pdo->lastInsertId();

      // table person vullen
      $query = "INSERT INTO persoon
            (account_id, firstname, middlename, lastname)
            VALUES
            (:account_id, :firstname, :middlename, :lastname)";

      // returned een statmenet object
      $statement = $this->pdo->prepare($query);

      // execute prepared statement
      $statement->execute(['account_id'=>$account_id, 'firstname'=>$fname, 'middlename'=>$mname, 'lastname'=>$lname ]);

      // commit
      $this->pdo->commit();
    }catch(Exception $e){
      // undo db changes in geval van error
      $this->pdo->rollback();
      throw $e;
    }
  }
};
 ?>
