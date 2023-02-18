<?php
/**
 * @package levack-php-classes
 * @subpackage mysql_db
 * @desc Provides access to MySQL databases.
 *       
 *       This is the msysl_db class file. It will provide a simplified means
 *       of connecting to and using a MySQL server.
 * 
 * @author Dan Levack <dlevack@yahoo.com>
 * @version 1.0
 */
class mysql_db {
  
  /**
   * @var string $HOST MySQL host
   */
  public $HOST = 'localhost';
  
  /**
   * @var string $USER User to connect to database
   */
  public $USER = 'root';
  
  /**
   * @var string $PASS Password to connect to database
   */
  public $PASS = '';
  
  /**
   * @var string $NAME Name of database to connect to
   */
  public $NAME = 'mysql';
  
  /**
   * @var handler $CONN Dattabase connection handler
   */
  public $CONN;
  
  /**
   * @method __construct
   * @desc Conctructor method, called when class is called.
   *       
   *       The constructor will set the HOST, USER, PASS, and NAME variables
   *       and then establish a connection to the database.
   * 
   * @param string $host Host to connect to
   * @param string $user User to use to connect
   * @param string $pass Password to use to connect
   * @param string $name Name of database to connect to
   */
  public function __construct($host = 'localhost',
			                  $user = 'root',
			                  $pass = '',
			                  $name = 'mysql') {
    $this->HOST = $host;
    $this->USER = $user;
    $this->PASS = $pass;
    
    $this->connect();
    $this->set_db($name);
    return;
  }
  
  /**
   * @method connect
   * @desc Connect to the MySQL database server.
   * 
   * @return bool Returns TRUE if connected FALSE if failed
   */
  public function connect() {
    $failed = 0;
    $this->CONN = @mysql_connect($this->HOST,
                                 $this->USER,
                                 $this->PASS) or $failed = 1;
    if ($failed == 0) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
  
  /**
   * @method set_db
   * @desc Sets the $NAME and selects that database for the connection.
   *
   * @param string $name Name of dabatabe to select
   */
  public function set_db($name = '') {
    if ($name <> '') {
      $this->NAME = $name;
      @mysql_select_db($this->NAME);
    }
    return;
  }
  
  /**
   * @method run_query
   * @desc Run the query provided and return result
   * 
   * @param $query - Query to be run
   * @return $result - Result returned from database
   */
  public function run_query($query = '') {
    if ($query <> '') {
      $result = @mysql_query($query);
      unset($query);
      return($result);
    } else {
      return;
    }
  }
  
  /**
   * @method db_exists
   * @desc Reports whether or not the database exists.
   * 
   * @param  string $db_name Name of database to check
   * @return bool            TRUE if database exists FALSE if not
   */
  public function db_exists($db_name = '') {
    if ($db_name <> '') {
      $query  = 'show databases';
      $result = $this->run_query($query);
      unset($query);
      $found = 0;
      while ($row = @mysql_fetch_assoc($result)) {
	    if ($row['Database'] == $db_name) {
	      $found++;
	    }
      }
      unset($result);
      if ($found > 0) {
	    unset($found);
	    return TRUE;
      } else {
	    unset($found);
	    return FALSE;
      }
    }
    return FALSE;
  }
  
  /**
   * @method drop
   * @desc Drop the requested database.
   * 
   * @param  string $db_name Name of database to drop
   * @return bool            TRUE if databse succesfully droped FALSE if not
   */
  public function drop($db_name = '') {
    if ($db_name <> '' and
	$db_name <> 'mysql') {
      $query = 'drop database '.$db_name;
      $this->run_query($query);
      unset($query);
      if ($this->db_exists($db_name)) {
	    return FALSE;
      } else {
	    return TRUE;
      }
    }
    return FALSE;
  }
  
  /**
   * @method create
   * @desc Create the requested database.
   *
   * @param  string $db_name Name of database to create
   * @return bool            TRUE if databse succesfully created FALSE if not
   */
  public function create($db_name = '') {
    if ($this->db_exists($db_name)) {
      return FALSE;
    } elseif ($db_name == '') {
      return FALSE;
    } else {
      $query = 'create database '.$db_name;
      $this->run_query($query);
      unset($query);
      if ($this->db_exists($db_name)) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
  }
  
  /**
   * @method __destruct
   * @desc Deconstructor method, called when class is closed.
   *
   * The destructor will close the MySQL connection.
   */
  public function __destruct() {
    @mysql_close($this->CONN);
    return;
  }
}
?>