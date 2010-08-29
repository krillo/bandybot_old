#!/usr/bin/php
<?php
  require_once("/usr/local/boyhappy.se/bandybot/init.php");
  $t = new Twitter(); 
  //echo $t->toString();   
   if($t->checkForUpdates()){
    $res = $t->update($t->createMessage());
    echo $res;  
  }    
?>
