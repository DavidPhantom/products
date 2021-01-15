<?php

require_once ("connection.php");

$conn = checkMySQLconnection($servername, $username, $password);
 
//Установка кодировки
mysqli_set_charset($conn, "utf8");

//создаем новую базу данных
$sql = "CREATE DATABASE $db";
provideMySQLQuery($conn, $sql);

mysqli_close($conn);
?>