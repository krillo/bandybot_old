<!doctype html>
<html>

	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="boyhappy" />
    <title>Registrera innebandy - less</title>

		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

    <link rel="stylesheet" href="/css/lessframework.css"  type="text/css" media="all" />
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/../init.php'; ?>
	</head>
	<body lang="en">





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






    
	</body>
</html>