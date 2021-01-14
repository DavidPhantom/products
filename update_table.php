<?php

require_once ("connection.php");

$conn = checkMySQLconnection($servername, $username, $password);

//Установка кодировки
mysqli_set_charset($conn, "utf8");


//соединяемся с базой данных goods
mysqli_select_db($conn, $db);


$sql = "UPDATE $table SET date_create='2020.12.28' WHERE id=4";

provideMySQLQuery($conn, $sql);

mysqli_close($conn);
?>