<?php

class Twitter {
	private $username;
	private $password;
	private $twitterCacheArray;
	//private $theSql = "select id, name from user where status = '" . User::ATTENDING . "' order by id asc ";
	
	
	/**
	 * 
	 */
	function __construct() {
	  require_once(DOC_ROOT.'/settings.php');
	  $this->username = TW_USER;
    $this->password = TW_PASS;
	}
	
	public function toString(){
	 return "Class Twitter";
	}
	
	/**
	 * Set the twitter cache
	 * @return sql result
	 */
	public static function getInitialTwitterStatus(){
		global $db;
    $sql = "select id, name from user where status = '".User::ATTENDING."' order by id asc";
    return $db->allValuesAsArray($sql);
  }
	

  
  /**
   * if no cache file exists create it 
   * return the cache file 
   */
  public static function checkForUpdates(){
    $updated = false;
    global $db;
    $currentStatus = $db->allValuesAsArray("select id, name from user where status = '".User::ATTENDING."' order by id asc");
    $jCurrent = json_encode($currentStatus);
            
    if(file_exists("twitterCache.txt")){
      $fh = fopen("twitterCache.txt", "r") or die("cant open file");
      $jCache = file_get_contents("twitterCache.txt");
      fclose($fh);
      if($jCurrent == $jCache){
        $updated = false;  
        return $updated;
      } 
    }
    $fh = fopen("twitterCache.txt", 'w') or die("can't open file");
    fwrite($fh, $jCurrent);
    fclose($fh);
    //chmod("twitterCache.txt", '774'); 
    $updated = true;       
    return $updated;
  }
  
  
  
  
  /**
   * Creates 
   */ 
  public function createMessage(){
    global $db;
    $sql = "select count(id) count from user where status = '".User::ATTENDING."'";
    $nbrComming = $db->value($sql);
    $sql = "select name from user where status = '".User::ATTENDING."' order by order_id asc";
    $namesComing = $db->valuesAsArray($sql);

    $sql = "select count(id) count from user where status = '".User::MABY."'";
    $nbrMaby = $db->value($sql);
    $sql = "select name from user where status = '".User::MABY."' order by order_id asc";
    $namesMaby = $db->valuesAsArray($sql);
       
    $msg = "$nbrComming kommer  " . implode(', ', $namesComing) . '.';
    if($nbrMaby>0){
      $msg .= "  $nbrMaby kanske  " . implode(', ', $namesMaby);
    } 
    return $msg; 
  }
  
	/**
	 * Submit a string as a status update
	 *
	 * @param string $status
	 * @return unknown
	 */
  public function update($status){ 
    $status = urlencode(stripslashes(urldecode($status)));
    if (strlen($status) > 140){ 
      $status = substr($status, 0, 139);
    }
    if ($status){
      $tweetUrl = 'http://www.twitter.com/statuses/update.xml';
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, "$tweetUrl");
      curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, "status=$status");
      curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");

      $result = curl_exec($curl);
      $resultArray = curl_getinfo($curl);

      if ($resultArray['http_code'] == 200){
        return 'Tweet Posted';
      }else{
        return 'Could not post Tweet to Twitter right now. Try again later.';
      }
      curl_close($curl);
    }
  }

  
}
?>