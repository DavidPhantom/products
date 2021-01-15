<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Продукты</title>
  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
</head>
<body>
<?php

require_once ("connection.php");
require_once ("c_table.php");

$conn = checkMySQLconnection($servername, $username, $password);

//Установка кодировки
mysqli_set_charset($conn, "utf8");

//соединяемся с базой данных goods
mysqli_select_db($conn, $db);

$num_products = 3;

$sql = 'SELECT  * FROM '.$table .' WHERE hidden = false ORDER BY date_create DESC LIMIT 0, '.$num_products;

if(($result = provideMySQLQuery($conn, $sql)) == TRUE)
{
    $htmlTable = new CTable();
	$intRow = 1;
	$intColumn = 11;
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
	$htmlTable->fillCell($hidden, $rowIndex, 10);


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
		$htmlTable->fillCell("<button name='plus' value='$id'>+</button>", $rowIndex, 6);
		$htmlTable->fillCell("<button name='minus' value='$id'>-</button>", $rowIndex, 7);
		$htmlTable->fillCell($row['date_create'], $rowIndex, 8);
		$htmlTable->fillCell("<button id='$rowIndex' value='$id'>Скрыть</button>", $rowIndex, 9);
		$htmlTable->fillCell($row['hidden'], $rowIndex, 10);
    }
	
    $htmlTable->printTable();
	
	echo "<button name='default'>По умолчанию</button>";
}

?>
<script>
function operations(value, numID, mess) {
	$.ajax({
		url: 'update_table.php',
		type: 'POST',
		data: { val: value, id: numID},
		success: function() {
			alert('OK - '+ mess);
			var quantity = Number($("p[class="+numID+"]").attr('value'));
			quantity += value;
			$( "p[class="+numID+"]").replaceWith("<p class="+numID+" value="+quantity+">"+quantity+"</p>");
			},
		error: function() {
			alert('Ошибка - '+ mess);
			}
	});
}

function return_to_default() {
	$.ajax({
		url: 'drop_table.php',
		type: 'GET',
		success: function() {
			alert('OK - Таблица удалена');   
		},
		error: function() {
			alert('Ошибка - Таблица не удалена');
		}
	});
	$.ajax({
		url: 'create_table.php',
		type: 'GET',
		success: function() {
			alert('OK - Таблица создана');   
		},
		error: function() {
			alert('Ошибка - Таблица не создана');
		}
	});
}

$( "button[id]" ).click(function() {
	var numRow = this.id;
	var numID = this.value;
	$( "tr:eq("+numRow+")").hide( "slow" );
	$.ajax({
        url: 'update_table.php',
		type: 'POST',
        data: { hidden: true, id: numID},
        success: function() {
            alert('OK - Строка скрыта');
        },
        error: function() {
            alert('Ошибка - Строка не скрыта');
        }
		});
});
$( "button[name]" ).click(function() {
	var mathOper = this.name;
	var numID = this.value;
	switch( mathOper ) {
                case 'plus' :
					operations(1, numID, 'Один товар прибавлен');
                    break;

                case 'minus' :
					operations(-1, numID, 'Один товар убавлен');
					break;

                case 'default' :
					return_to_default();
			};
});
</script>
</body>
</html>
