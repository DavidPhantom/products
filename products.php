<?php

require_once ("connection.php");
require_once ("c_products.php");


function sort_date($a_new, $b_new) {

	$a_new = strtotime($a_new["date_create"]);
	$b_new = strtotime($b_new["date_create"]);

	return $b_new - $a_new;
}

$conn = checkMySQLconnection($servername, $username, $password);

//Установка кодировки
mysqli_set_charset($conn, "utf8");

//соединяемся с базой данных goods
mysqli_select_db($conn, $db);

$sql = 'SELECT * FROM '.$table;

if(($result = provideMySQLQuery($conn, $sql)) == TRUE)
{
    $htmlTable = new CProducts();
	$intRow = 1;
	$intColumn = 8;
    $htmlTable->setTableSize($intRow, $intColumn);
	
	$id = "ID";
    $product_id = "PRODUCT_ID";
    $product_name = "PRODUCT_NAME";
    $product_price = "PRODUCT_PRICE";
	$product_article = "PRODUCT_ARTICLE";
    $product_quantity = "PRODUCT_QUANTITY";
    $date_create = "DATE_CREATE";
    
    $rowIndex = 0;
    $htmlTable->fillCell($id, $rowIndex, 0);
    $htmlTable->fillCell($product_id, $rowIndex, 1);
    $htmlTable->fillCell($product_name, $rowIndex, 2);
	$htmlTable->fillCell($product_price, $rowIndex, 3);
	$htmlTable->fillCell($product_article, $rowIndex, 4);
	$htmlTable->fillCell($product_quantity, $rowIndex, 5);
	$htmlTable->fillCell($date_create, $rowIndex, 6);
	$htmlTable->fillCell('Скрыть', $rowIndex, 7);

	$stack = array();
    while ($row = mysqli_fetch_array($result)) 
    {
		array_push($stack, $row);	
    }
	
	usort($stack, "sort_date");
	
	$num_products = 3;
	
	foreach($stack as $row)
    {
		$htmlTable->pushRowAfterIndex($rowIndex);
        $rowIndex++;
        $htmlTable->fillCell($row['id'], $rowIndex, 0);
        $htmlTable->fillCell($row['product_id'], $rowIndex, 1);
		$htmlTable->fillCell($row['product_name'], $rowIndex, 2);
		$htmlTable->fillCell($row['product_price'], $rowIndex, 3);
		$htmlTable->fillCell($row['product_article'], $rowIndex, 4);
		$htmlTable->fillCell($row['product_quantity'], $rowIndex, 5);
		$htmlTable->fillCell($row['date_create'], $rowIndex, 6);
		$htmlTable->fillCell("<input type='submit' value='Скрыть'>", $rowIndex, 7);
		
		if ($num_products == $rowIndex)
			break;	
    }
    
    $htmlTable->printTable();
}

?>