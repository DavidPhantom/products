<?php

require_once ("connection.php");

$conn = checkMySQLconnection($servername, $username, $password);

//Установка кодировки
mysqli_set_charset($conn, "utf8");


//соединяемся с базой данных goods
mysqli_select_db($conn, $db);


$sql = "DROP TABLE $table";

provideMySQLQuery($conn, $sql);

mysqli_close($conn);
?>