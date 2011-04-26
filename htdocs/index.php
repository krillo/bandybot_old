<?php include 'header.php'; ?>
<?php
if (isset($_POST["status"]) && isset($_POST["id"])) {
  //echo $_POST["column"];
  //echo $_POST["id"];
  User::setUserStatus($_POST["id"], $_POST["status"]);
}
if (isset($_POST["comment"]) && isset($_POST["id"])) {
  //echo $_POST["comment"];
  //echo $_POST["id"];
  User::setUserComment($_POST["id"], $_POST["comment"]);
}

$attending = User::getStatusCount(User::ATTENDING);
$maby = User::getStatusCount(User::MABY);
?>

<div id="headnote">
  <h1>Registrera dig för innebandy v<?php echo date('W')?></h1>
</div>
<div class="clear"></div>

<div id="headnote-info">
  <?php echo $attending; ?> kommer 
</div>
<div class="clear"></div>

<table>
  <tr>
    <th ><a href="/players.php">Visitkort</a></th>
    <th >X</th>
    <th >Nej</th>
    <th >?</th>
    <th >Ja</th>
    <th ></th>
    <th >Kommentar</th>
    <th >Datum</th>
    <th >Betalt</th>
  </tr>

  <?php
  $users = new User;
  $result = $users->getUsers();
  while ($row = mysql_fetch_assoc($result)) {
    $today = date('Ymd');
    $date = date('Ymd', $row['unixdate']);
    $today == $date ? $date = '<span style="color:#3764DF;">idag '. date('H:i', $row['unixdate']) .'</span>' : $date = date('j/n H:i', $row['unixdate']);
  ?>
    <form action="" method="post">
      <tr>
        <td class="list"><a href="/players.php?id=<?php echo $row['id'] ?>"><?php echo $row['name'] ?></a></td>
        <td class="list"><input type="radio" name="status" value="0" <?php echo ($row['status'] == '0') ? 'checked' : ''; ?>/></td>
        <td class="list"><input type="radio" name="status" value="1" <?php echo ($row['status'] == '1') ? 'checked' : ''; ?> /></td>
        <td class="list"><input type="radio" name="status" value="2" <?php echo ($row['status'] == '2') ? 'checked' : ''; ?> /></td>
        <td class="list"><input type="radio" name="status" value="3" <?php echo ($row['status'] == '3') ? 'checked' : ''; ?> /></td>
        <td class="list"><input type="submit"  value=" Ok " /></td>
        <td class="list"><input type="text"  name="comment" value="<?php echo $row['comment'] ?>"  class="comment-box" /></td>
        <td class="list"><?php echo $date; ?></td>      
        <td class="list"><?php echo ($row['betalt'] == '1') ? 'Ja' : ''; ?></td>
      </tr>
      <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
    </form>
  <?php } ?>
  <!-- new user -->
  <form action="/edit_plyer.php" method="get">
    <tr>
      <td ><a href="/edit_player.php?id=new">Ny</a></td>
      <td ><input type="radio" name="status" value="0" disabled /></td>
      <td ><input type="radio" name="status" value="1" disabled /></td>
      <td ><input type="radio" name="status" value="2" disabled /></td>
      <td ><input type="radio" name="status" value="3" disabled /></td>
      <td ><input type="submit"  value=" Ok " disabled /></td>
      <td ><input type="text"  name="comment" value=""  class="comment-box" disabled /></td>
      <td > </td>    
      <td > </td>
    </tr>
  </form>
</table>

<?php include 'footer.php'; ?>
