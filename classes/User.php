<?php
class User {
  const NOT_REG = 0;
  const NOT_ATTENDING = 1;
  const MABY = 2;
  const ATTENDING = 3;
  

  function __construct() {
    require_once(DOC_ROOT.'/settings.php');    
  }

  public function displayUsers($dbResult) {
    while ($row = mysql_fetch_assoc($dbResult)) {
      echo $row['userid'] . "\n";
      echo $row['name'] . "\n";
      echo $row['email'] . "\n";
      echo $row['date'] . "\n";
    }
  }


  public function getUsers(){
   $sql = 'select u.*, UNIX_TIMESTAMP(u.date) unixdate from user u ';
   $result=mysql_query($sql);
   return $result; 
  }


  public function getUser($id){
   $sql = 'SELECT u.*, UNIX_TIMESTAMP(u.date) unixdate  FROM user u where id = ' . $id;
   $result=mysql_query($sql);
   return $result;
  }


 public function getEmptyUser() {
    $row = array("id" => "new", "name" => 'förnamn', "lname" => 'efternamn', "email" => "email",
        "mobile" => "mobil", "phone" => "hemtelefon", "tagline" => "slogan", "betalt" => 0,
        "date" => date('Y-m-d H:i:s'), "comment" => "kommentar", "status" => 0, "unixdate" => time());
    return $row;
  }



  /**
   * Returns an array of players and comments for submitted status
   *     
   * @param int $status  Use User::ATTENDING, User::NOT_ATTENDING or User::MABY 
   * @return array
   */ 
  public static function getUsersByStatus($status){
    global $db;
    $sql = "select name, comment FROM user where status = $status";
    $resArray = $db->allValuesAsArray($sql);        
    return $resArray;
  }


  public static function getStatusCount($status){
    global $db;
    //$sql = "select count(status) as count from user group by status";
    $sql = "select count(status) as count from `user` where status = $status ";
    $resArray = $db->value($sql);
    return $resArray;
  }

  /**
   * Returns all the emailadresses as a comma separated string.
   * If true is passes then only a test emailadress is returned
   *
   * @global  $db
   * @param booblean $debug
   * @return string emails
   */
  public static function getAllEmailAdresses($debug=false) {
    if ($debug == true) {
      return "krillo@boyhappy.se";
    } else {
      global $db;
      $sql = "select email from user";
      $resArray = $db->valuesAsArray($sql);
      $emails = implode(',', $resArray);
      return $emails;
    }
  }


  /**
   * Sets all users to submitted status
   * 
   * @param int $status  Use User::NOT_ATTENDING, User::ATTENDING or User::MABY  
   */ 
  public static function setUsers($status) {
    global $db;
    $sql = "update user set status = $status, date = now()";
    $res = $db->query($sql);
  }

  /**
   * Sets all users to NOT_REG and their comments to blank
   *
   */
  public static function resetUsers() {
    global $db;
    $sql = "update user set status = ". NOT_REG .", date = now(), comment = '";
    $res = $db->query($sql);
  }

  /**
   * Sets a user to submitted status
   *
   * @param string $id
   * @param int $status  Use User:NOT_REG, User::NOT_ATTENDING, User::ATTENDING or User::MABY
   */
  public static function setUserStatus($id, $status){
    global $db;
    $sql = "update user set status = $status, date = now() where id = $id";
    $res = $db->query($sql);   
  }  

  /**
   * Set the comment for an user
   * 
   * @global <type> $db
   * @param <type> $id
   * @param <type> $comment 
   */
  public static function setUserComment($id, $comment) {
    global $db;
    $sql = "update user set comment = '$comment', date = now() where id = $id";
    $res = $db->query($sql);
  }

  
  public static function setUserParams($id, $name, $lname, $tagline, $email, $mobile, $phone){
    global $db;
    $sql = "update user set name = '$name', lname = '$lname', tagline = '$tagline', email = '$email', mobile = '$mobile', phone = '$phone' where id = $id";
    $res = $db->query($sql);
    return $res;
  }

  /**
   * create a new user, return the new users id
   *
   * @global  $db
   * @param string $name
   * @param string $lname
   * @param string $tagline
   * @param string $email
   * @param string $mobile
   * @param string $phone
   * @return int   $id  just created user id
   */
  public static function insertNewUser($name, $lname, $tagline, $email, $mobile, $phone){
    global $db;
    $sql = "insert into user set name = '$name', lname = '$lname', tagline = '$tagline', email = '$email', mobile = '$mobile', phone = '$phone' ";
    $res = $db->query($sql);
    $sql = "select max(id) id from user";
    $id = $db->query($sql);
    return $id;
  }



}
?>