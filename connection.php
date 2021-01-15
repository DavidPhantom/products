<?php

function checkMySQLconnection($host, $user, $password)
{
	$link = mysqli_connect($host, $user, $password)
		or die("Ошибка " . mysqli_error($link));
	
	
    print("Соединение установлено успешно</br>");
	
    return $link;
}

function provideMySQLQuery($mysqlconn, $sql)
{
	$res = mysqli_query($mysqlconn, $sql);
	
    if ($res === FALSE) 
       echo "Ошибка запроса: ".$sql." </br> Описание ошибки - ". mysqli_error($mysqlconn) ."</br>";
    
    return $res;
}

$servername = "localhost";
$username = "root";
$password = "";
$db = "goods";
$table = "products";

?>