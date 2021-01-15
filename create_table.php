<?php

require_once ("connection.php");
require_once ("c_products.php");

$conn = checkMySQLconnection($servername, $username, $password);
 
//Установка кодировки
mysqli_set_charset($conn, "utf8");

//соединяемся с базой данных goods
mysqli_select_db($conn, $db);

//создаем таблицу products:  с полями id, product_id, product_name, product_price, product_article, product_quantity, date_create
$sqlTable = new CProducts();
$sql = $sqlTable->createSQLTable($table);

if(provideMySQLQuery($conn, $sql))
{
    //заполним таблицу products
    $sql = "INSERT INTO $table (product_id, product_name, product_price, product_article, product_quantity, date_create, hidden)
    VALUES (RAND()*(10000),'Рис', 49.9, RAND()*(10000), 2000, '2020.12.22', false),";
    $sql .= "(RAND()*(10000),'Овсянка', 23.9, RAND()*(10000), 1000, '2020.11.23', false),";
    $sql .= "(RAND()*(10000), 'Масло', 116.43, RAND()*(10000), 3500, '2020.12.25', false),";
    $sql .= "(RAND()*(10000), 'Молоко', 53.9, RAND()*(10000), 2500, '2020.12.26', false)";

    provideMySQLQuery($conn, $sql);
}

mysqli_close($conn);
?>