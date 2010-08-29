<?php
  require_once 'settings.php';

  function __autoload($class_name) {
    require_once DOC_ROOT."/classes/$class_name.php";
  }

  $db =& new Db;
  $dbc = $db->connect();

  If(!$twitterCacheArray){
    $twitterCacheArray = Twitter::getInitialTwitterStatus();
  }
?>