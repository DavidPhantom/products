<?php

require_once ("c_products.php");
require_once ("c_table.php");

$conn = checkMySQLconnection($servername, $username, $password);

//Установка кодировки
mysqli_set_charset($conn, "utf8");

//соединяемся с базой данных goods
if (mysqli_select_db($conn, $db) == FALSE)
{
	CProducts::createDB($servername, $username, $password, $db, $conn);
	mysqli_select_db($conn, $db);
}

$num_products = 3;

$sql = 'SELECT  * FROM '.$table .' WHERE hidden = false ORDER BY date_create DESC LIMIT 0, '.$num_products;

$result = provideMySQLQuery($conn, $sql);

if($result == FALSE)
{
	CProducts::createSQLTable($table, $servername, $username, $password, $db, $conn);
	$result = provideMySQLQuery($conn, $sql);
}

$htmlTable = new CTable();
$intRow = 1;
$intColumn = 10;
$htmlTable->setTableSize($intRow, $intColumn);
	
$id = "ID";
$product_id = "PRODUCT_ID";
$product_name = "PRODUCT_NAME";
$product_price = "PRODUCT_PRICE";
$product_article = "PRODUCT_ARTICLE";
$product_quantity = "PRODUCT_QUANTITY";
$plus_quantity = "+";
$minus_quantity = "-";
$date_create = "DATE_CREATE";
$hidden = "HIDDEN";
    
$rowIndex = 0;
$htmlTable->fillCell($id, $rowIndex, 0);
$htmlTable->fillCell($product_id, $rowIndex, 1);
$htmlTable->fillCell($product_name, $rowIndex, 2);
$htmlTable->fillCell($product_price, $rowIndex, 3);
$htmlTable->fillCell($product_article, $rowIndex, 4);
$htmlTable->fillCell($product_quantity, $rowIndex, 5);
$htmlTable->fillCell($plus_quantity, $rowIndex, 6);
$htmlTable->fillCell($minus_quantity, $rowIndex, 7);
$htmlTable->fillCell($date_create, $rowIndex, 8);
$htmlTable->fillCell('Скрыть', $rowIndex, 9);


while ($row = mysqli_fetch_array($result)) 
{
	$htmlTable->pushRowAfterIndex($rowIndex);
	$rowIndex++;
	$id = $row['id'];
	$htmlTable->fillCell($id, $rowIndex, 0);
	$htmlTable->fillCell($row['product_id'], $rowIndex, 1);
	$htmlTable->fillCell($row['product_name'], $rowIndex, 2);
	$htmlTable->fillCell($row['product_price'], $rowIndex, 3);
	$htmlTable->fillCell($row['product_article'], $rowIndex, 4);
	$htmlTable->fillCell("<p class='$id' value='".$row['product_quantity']."'>".$row['product_quantity']."</p>", $rowIndex, 5);
	$htmlTable->fillCell("<button name='plusProductItemBtn' value='$id'>+</button>", $rowIndex, 6);
	$htmlTable->fillCell("<button name='minusProductItemBtn' value='$id'>-</button>", $rowIndex, 7);
	$htmlTable->fillCell($row['date_create'], $rowIndex, 8);
	$htmlTable->fillCell("<button id='$rowIndex' name='hiddenProductItemBtn' value='$id'>Скрыть</button>", $rowIndex, 9);
}
	
$htmlTable->printTable();
	
echo "<button name='returnDefaultStateTableBtn'>Первоначальная версия таблицы</button>";

?>

