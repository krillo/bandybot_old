<?php include '../header.php'; ?>

Tjoho index.php <br /> 

<?php
foreach ($_GET as $key => $value) {
    echo $key . " = " . $value;
}
?>

<?php include '../footer.php'; ?>