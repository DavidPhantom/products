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
require_once ("c_products.php");

$conn = checkMySQLconnection($servername, $username, $password);

//Установка кодировки
mysqli_set_charset($conn, "utf8");

//соединяемся с базой данных goods
mysqli_select_db($conn, $db);

$num_products = 3;

$sql = 'SELECT  * FROM '.$table .' WHERE hidden = false ORDER BY date_create DESC LIMIT 0, '.$num_products;

if(($result = provideMySQLQuery($conn, $sql)) == TRUE)
{
    $htmlTable = new CProducts();
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
        $htmlTable->fillCell($row['id'], $rowIndex, 0);
        $htmlTable->fillCell($row['product_id'], $rowIndex, 1);
		$htmlTable->fillCell($row['product_name'], $rowIndex, 2);
		$htmlTable->fillCell($row['product_price'], $rowIndex, 3);
		$htmlTable->fillCell($row['product_article'], $rowIndex, 4);
		$htmlTable->fillCell($row['product_quantity'], $rowIndex, 5);
		$num = $row['id'];
		$htmlTable->fillCell("<button name='plus' value='$num'>+</button>", $rowIndex, 6);
		$htmlTable->fillCell("<button name='minus' value='$num'>-</button>", $rowIndex, 7);
		$htmlTable->fillCell($row['date_create'], $rowIndex, 8);
		$htmlTable->fillCell("<button id='$rowIndex' value='$num'>Скрыть</button>", $rowIndex, 9);
		$htmlTable->fillCell($row['hidden'], $rowIndex, 10);
    }
	
    $htmlTable->printTable();
	
	echo "<button name='default_val'>По умолчанию</button>";
}

?>
<script>
$( "button[id]" ).click(function() {
	var clickId = this.id;
	var clickValue = this.value;
	$( "tr:eq("+clickId+")").hide( "slow" );
	$.ajax({
        url: 'update_table.php',
		type: 'POST',
        data: { hidden: true, id: clickValue},
        success: function() {
            alert('ok');
        },
        error: function() {
            alert('error');
        }
		});
});
$( "button[name]" ).click(function() {
	var clickName = this.name;
	var clickValue = this.value;
	switch( clickName ) {
                case 'plus' :
                   $.ajax({
					url: 'update_table.php',
					type: 'POST',
					data: { val: 1, id: clickValue},
					success: function() {
						alert('plus ok');
						location.reload();   
					},
					error: function() {
						alert('plus error');
					}
					});
                    break;

                case 'minus' :
                    $.ajax({
					url: 'update_table.php',
					type: 'POST',
					data: { val: -1, id: clickValue},
					success: function() {
						alert('minus ok');
						location.reload();   
					},
					error: function() {
						alert('minus error');
					}
					});
					break;

                case 'default_val' :
                   $.ajax({
					url: 'drop_table.php',
					type: 'GET',
					success: function() {
						alert('drop_table ok');   
					},
					error: function() {
						alert('drop_table error');
					}
				});
				$.ajax({
					url: 'create_table.php',
					type: 'GET',
					success: function() {
						alert('create_table ok');
						location.reload();   
					},
					error: function() {
						alert('create_table error');
					}
				});
			};
});
</script>
</body>
</html>