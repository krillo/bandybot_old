<?php

class Spot {
	
	protected $id;
	protected $price;
	protected $date;
	protected $orig_text;
	protected $orig_date;
	
	/**
	 * 
	 */
	function __construct() {
     require_once($_SERVER['DOCUMENT_ROOT'].'/../settings.php');
	}
	
	/**
	 * Returns the spot price in ore 
	 *
	 * @return string the spot price
	 */
	public function getSpotPrice(){
    $lines = file(SPOT_URL);
    $theLine = 0;
    foreach ($lines as $line_num => $line) {
      if(strrpos($line, "Exch.rate")){
        $spot =  $line; //htmlspecialchars($line);
        $theLine = $line_num + 3;
        break;
      }
    }
    $this->orig_date = htmlspecialchars($lines[$theLine]);    
    $this->orig_text = $lines[$theLine+1];
    echo $this->orig_text;
    $subject = $this->orig_text;
    $pattern = '/>.*?(\d*.?\d*).*</';
    preg_match($pattern, $subject, $matches);	
    $this->price = $matches[1]/10;	
    return	$this->price;	
	}


  public function writeToLogFile($input){
    $writeThis = date('Y-m-d') . '    '. $input;
    $myFile = DOC_ROOT . '/log/spot_price.txt';
    $fh = fopen($myFile, 'a') or die("can't open file");
    fwrite($fh, $writeThis . "\n");
    fclose($fh);
  }
	
  
  public function storeSpotPrice(){
    global $dbc;
    $this->orig_text =  str_replace(",", ".", $this->orig_text);
    $sql = "insert into spot (price, date, orig_text) values ('$this->price', ". date('Y-m-d') .", '$this->orig_text')";
    echo $sql;   
    mysql_query($sql) or die(mysql_error());  
  }
  
  
  
}

?>