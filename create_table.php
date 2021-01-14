<?php

require_once ("connection.php");

$conn = checkMySQLconnection($servername, $username, $password);
 

//Установка кодировки
mysqli_set_charset($conn, "utf8");

//создаем новую базу данных
$sql = "CREATE DATABASE $db";
provideMySQLQuery($conn, $sql);

//соединяемся с базой данных goods
mysqli_select_db($conn, $db);

//создаем таблицу products:  с полями id, product_id, product_name, product_price, product_article, product_quantity, date_create
$sql = "CREATE TABLE $table (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	product_id INT(5),
    product_name CHAR(60) CHARSET utf8,
    product_price FLOAT,
	product_article INT(5),
	product_quantity INT(6),
	date_create DATE
    )";

if(provideMySQLQuery($conn, $sql))
{
    //заполним таблицу products
    $sql = "INSERT INTO $table (product_id, product_name, product_price, product_article, product_quantity, date_create)
    VALUES (RAND()*(10000),'Рис', 49.9, RAND()*(10000), 2000, '2020.12.22'),";
    $sql .= "(RAND()*(10000),'Овсянка', 23.9, RAND()*(10000), 1000, '2020.11.23'),";
    $sql .= "(RAND()*(10000), 'Масло', 116.43, RAND()*(10000), 3500, '2020.12.25'),";
    $sql .= "(RAND()*(10000), 'Молоко', 53.9, RAND()*(10000), 2500, '2020.12.26')";

    provideMySQLQuery($conn, $sql);
}

mysqli_close($conn);
?>