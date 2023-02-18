<?php
/**
 * @package levack-php-classes
 * @subpackage ssh_conn
 * @desc Provides methods for utilizing ssh within php scripts.
 *       
 *       This is the ssh.php file. It will provide methods for
 *       utilizing ssh within php scripts.
 * 
 * @author Dan Levack <dlevack@yahoo.com>
 * @version 1.0
 */
class ssh_conn {

  /**
   * @var string $HOST Host to connect to
   * @access public
   */
  public $HOST;

  /**
   * @var string $USER User to use when connecting
   * @access public
   */
  public $USER;

  /**
   * @var string $KEY Key to use when connecting
   * @access public
   */
  public $KEY;

  /**
   * @var string $OPTIONS Options to use when connecting
   * @access public
   */
  public $OPTIONS;

  /**
   * @method __construct
   * @desc Conctructor method, called when class is called.
   *
   *       The constructor will set the HOST, USER, KEY and OPTIONS variables
   *
   * @access public
   * @param string $host    Host to connect to
   * @param string $user    User to use when connecting
   * @param string $key     Key to use when connecting
   * @param int    $timeout Timeout For connection
   */
  public function __construct($host    = '',
			                  $user    = '',
			                  $key     = '',
			                  $timeout = 2) {
    $this->set_host($host);
    $this->set_user($user);
    $this->set_key($key);
    $this->set_timeout($timeout);
    return;
  }

  /**
   * @method cmd
   * @desc Returns the output of the command as an array.
   *
   * @access public
   * @param  string $cmd    Command to be run
   * @return array  $return Array of output from command
   */
  public function cmd($cmd = '') {
    // Start building SSH command and add timeout option
    $command = 'ssh '.$this->OPTIONS.' ';
    
    // Check to see if we were provided an SSH key and if so use it
    if ($this->KEY <> '') {
      $command .= '-i '.$this->KEY.' ';
    }
    
    // Check to see if we were provided a user of the connection
    // and if so use it
    if ($this->USER <> '') {
      $command .= $this->USER.'@';
    }
    
    // Add the host to the command
    $command .= $this->HOST." '";
    
    // Add the command we want to run to the command
    $command .= $cmd;
    
    // Redirect STDOUT to STDIN so that any errors will be returned
    // in the array
    $command .= "' 2>&1";
    
    $return   = array();
    
    // Run the command and set its output in the $return array
    exec($command,
	     $return);
    
    return($return);
  }

  /**
   * @method set_host
   * @desc Set the value of the host to SSH to.
   *
   * @access public
   * @param string $host Host to SSH to
   */
  public function set_host($host = '') {
    $this->HOST = $host;
    return;
  }

  /**
   * @method set_user
   * @desc Set the value of the user to use for the SSH connection.
   *
   * @access public
   * @param string $user User to use when connecting
   */
  public function set_user($user = '') {
    $this->USER = $user;
    return;
  }

  /**
   * @method set_key
   * @desc Set the value of the SSH key to use for the SSH connection.
   *
   * @access public
   * @param string $key SSH key to use when connecting
   */
  public function set_key($key = '') {
    $this->KEY = $key;
    return;
  }

  /**
   * @method set_timeout
   * @desc Set the value of the timeout to use for the SSH connection.
   *
   * @access public
   * @param int $timeout Timeout value to use when connecting
   */
  public function set_timeout($timeout = 2) {
    $this->OPTIONS = '-o ConnectTimeout='.$timeout;
    return;
  }
}
?>