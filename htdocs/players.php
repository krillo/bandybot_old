<?php include 'header.php'; ?>

<?php
$user = new User;
if (isset($_REQUEST["id"])) {
  $id = $_REQUEST["id"];
  $result = $user->getUser($id);
} else {
  $id = 'all';
  $result = $user->getUsers();
}
?>


<div id="headnote" >
  <h1 class="xtra-margin">Alla visitkort</h1>
</div>
<div class="clear"></div>

<div id="headnote-info" class="xtra-margin">
  <a href="/index.php" >registreringssidan</a> <?php echo ($id != 'all') ? '<a href="/players.php" >alla visitkort</a>' : ''; ?>
</div>
<div class="clear"></div>


<?php
while ($row = mysql_fetch_assoc($result)) {
?>

  <div class="card" >
    <h2>Tisdagsbandy</h2>
    <div class="clear"></div>

    <div class="person" >
      <span class="name">
      <?php echo $row['name'] ?> <?php echo $row['lname'] ?> <br/>
    </span>
    <span class="title"><?php echo $row['tagline'] ?></span>
  </div>
  <div class="clear"></div>

  <div class="data">
    <div style="float:left;" id="email-box">
      <?php echo $row['email'] ?>
    </div>
    <div class="clear"></div>
    <div style="float:left;">
      <?php echo $row['mobile'] ?><br/>
      <?php echo $row['phone'] ?>
    </div>
    <div style="float:right;margin-top: 20px;">
      <form action="/edit_player.php" method="get">
        <input type="submit"  value="Redigera" style="float:right;"/>
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
      </form>
    </div>
  </div>
</div>

<?php
    }
    include 'footer.php';
?>