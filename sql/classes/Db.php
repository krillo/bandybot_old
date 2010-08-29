<?php

class Db {
  private $connection;
	
  function __construct() {
    require_once(DOC_ROOT.'/settings.php');  
  }
	
  function connect(){
    $this->connection = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("DB Connection failed - Db.php");
    mysql_select_db(DB_NAME);
    return $this->connection; 	
  }
  
  /**
   * executes query
   *
   * @param string $sql
   */
  public function query($sql)
  {
  	/*
    $sqlDebug = defined("DEBUG") && DEBUG && isset($_GET["sql_debug"]);
    $sql = $sql;
    if ($sqlDebug) {
            $stats = new Stats();
    }
*/
    //$this->querycount++;
    $res = mysql_query($sql, $this->connection); //or $this->error(mysql_error() , $sql);

    /*
    if ($sqlDebug) {
            $stats->storeDifference();
            echo "\n<!--\n";
      echo "Query #$this->querycount: $sql\n";
      echo "Memory used: $stats->memUsedFmted bytes\n";
            echo "Time spent: $stats->timeSpent seconds\n";
            echo "-->\n";
    }
    */
    return $res;
  }    
    

  
  public function valuesAsAssoc($sql)
  { 
    $res = $this->query($sql);
    return mysql_fetch_assoc($res);
  }

  	
  	
  /**
   * Returns an array of data
   *
   * @param string $sql
   * @return array
   */
  public function valuesAsArray($sql)
  { 

    $res = $this->query($sql);
    $result = array();
    while ($data = mysql_fetch_array($res, MYSQL_NUM)) {
      $result[] = $data[0];
    }
    unset($data);
    return $result;
  }


  /**
   * Returns an 2d assoc array with result.
   * Adds id as key if it exists in the result
   *
   * @param stirng $sql
   * @return 2d assoc array
   */
  public function allValuesAsArray($sql)
  {
    $res = $this->query($sql);
    $result = array();
    while ($data = mysql_fetch_assoc($res)) {
      foreach ($data as $field => $value) {
        $data[$field] = stripslashes($value);
      }
      if (isset($data['id'])) {
        $result[$data['id']] = $data;
      } else {
        $result[] = $data;
      }
    }
    unset($data);
    return $result;
  }  
  
  /**
   * execute an query with no result
   */
  public function nonquery($sql){ 
    $this->query($sql);
    return mysql_affected_rows($this->connection);
  }
    
  /**
   * returns only the first value
   */  
  public function value($sql){ 
    $data = mysql_fetch_array($this->query($sql) , MYSQL_NUM);
    return $data[0];
  }
  
  
  /**
   * returns only the first row
   */    
  public function row($sql){ 
    return mysql_fetch_assoc($this->query($sql));
  }  
	
}
?>
