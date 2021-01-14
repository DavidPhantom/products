<?php

require_once ("connection.php");
require_once ("c_products.php");

$conn = checkMySQLconnection($servername, $username, $password);

//Установка кодировки
mysqli_set_charset($conn, "utf8");


//соединяемся с базой данных goods
mysqli_select_db($conn, $db);


if (isset($_POST['val']) && isset($_POST['id'])) {
$sql = "UPDATE $table SET product_quantity = product_quantity + ".$_POST['val']."  WHERE id = ".$_POST['id'];
}

if (isset($_POST['hidden']) && isset($_POST['id'])) {
$sql = "UPDATE $table SET hidden = ".$_POST['hidden']." WHERE id = ".$_POST['id'];
}

provideMySQLQuery($conn, $sql);

mysqli_close($conn);
?>