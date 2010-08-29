<?php include 'header.php'; ?>


<div id="headnote" >
	<h1 class="xtra-margin">Redigera ditt visitkort</h1>
</div>
<div class="clear"></div>

<div id="headnote-info" class="xtra-margin">
  <a href="/index.php" >registreringssidan</a>  <a href="/players.php" >alla visitkort</a>
</div>
<div class="clear"></div>

<?php
$user = new User;
if (isset($_REQUEST["id"])) {
  $id = $_REQUEST["id"];
  if ($id == 'new') {
    $row = $user->getEmptyUser();
  } else {
    $result = $user->getUser($id);
    $row = mysql_fetch_assoc($result);
  }
}

$save = $_POST["save"];
if (isset($_POST["id"]) && $save == 'spara') {
  $id = $_REQUEST["id"];
  $name = $_POST["name"];
  $lname = $_POST["lname"];
  $tagline =  $_POST["tagline"];
  $email = $_POST["email"];
  $mobile = $_POST["mobile"];
  $phone =  $_POST["phone"];

  if($id == 'new'){
    $id = User::insertNewUser($name, $lname, $tagline, $email, $mobile, $phone);
  }else{
    User::setUserParams($id, $name, $lname, $tagline, $email, $mobile, $phone);
  }
  $result = $user->getUser($id);
  $row = mysql_fetch_assoc($result);
}
?>


    <form action="" method="post">
    <div class="card" >
      <h2>Tisdagsbandy</h2>
      <div class="clear"></div>
      <div class="" >
        <span class="name">
          <input type="text" name="name" value="<?php echo $row['name'] ?>" /> <input type="text" name="lname" value="<?php echo $row['lname'] ?>" /> <br/>
        </span>
        <span class="title"><input type="text" name="tagline" value="<?php echo $row['tagline'] ?>" /></span>
      </div>  
      <div class="clear"></div>

      <div class="data">
        <div style="float:left;">
          <input type="text" name="email" value="<?php echo $row['email'] ?>" id="email-box" />
        </div>
      <div class="clear"></div>
        <div style="float:left;">
          <input type="text" name="mobile" value="<?php echo $row['mobile'] ?>" /><br/>
          <input type="text" name="phone" value="<?php echo $row['phone'] ?>" />
        </div>
        <div style="float:right;margin-top: 20px;">
        <input type="submit" name="save" value="spara" style="float:right;"/>
        </div>
      </div>
    </div>
    <input type="hidden" name="id" value="<?php echo $id ?>" />
  </form>


<?php include 'footer.php'; ?>
