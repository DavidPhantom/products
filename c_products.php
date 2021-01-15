<?php

require_once ("connection.php");

class CProducts
{
	public static function createSQLTable($table, $servername, $username, $password, $db, $conn)
    {
		$closeConn = FALSE;
		
		if (!(isset ($conn)))
		{
			$conn = checkMySQLconnection($servername, $username, $password);
 
			//Установка кодировки
			mysqli_set_charset($conn, "utf8");

			//соединяемся с базой данных goods
			mysqli_select_db($conn, $db);
			$closeConn = TRUE;
		}

        $sql = "CREATE TABLE ".$table." (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,product_id INT(5),
			product_name CHAR(60) CHARSET utf8,
			product_price FLOAT,
			product_article INT(5),
			product_quantity INT(6),
			date_create DATE,
			hidden BOOLEAN
			)";
		
		if(provideMySQLQuery($conn, $sql))
		{
			//заполним таблицу products
			$sql = "INSERT INTO ".$table." (product_id, product_name, product_price, product_article, product_quantity, date_create, hidden)
				VALUES (RAND()*(10000),'Рис', 49.9, RAND()*(10000), 2000, '2020.12.22', false),";
			$sql .= "(RAND()*(10000),'Овсянка', 23.9, RAND()*(10000), 1000, '2020.11.23', false),";
			$sql .= "(RAND()*(10000), 'Масло', 116.43, RAND()*(10000), 3500, '2020.12.25', false),";
			$sql .= "(RAND()*(10000), 'Молоко', 53.9, RAND()*(10000), 2500, '2020.12.26', false)";

			provideMySQLQuery($conn, $sql);
		}
		
		if ($closeConn == TRUE)
			mysqli_close($conn);
    }	
	
	public static function recreateSQLTable($table, $servername, $username, $password, $db)
	{
		$conn = checkMySQLconnection($servername, $username, $password);

		//Установка кодировки
		mysqli_set_charset($conn, "utf8");


		//соединяемся с базой данных goods
		mysqli_select_db($conn, $db);

		$sql = "DROP TABLE ".$table;
		
		provideMySQLQuery($conn, $sql);

		$sql = "CREATE TABLE ".$table." (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,product_id INT(5),
			product_name CHAR(60) CHARSET utf8,
			product_price FLOAT,
			product_article INT(5),
			product_quantity INT(6),
			date_create DATE,
			hidden BOOLEAN
			)";
		
		if(provideMySQLQuery($conn, $sql))
		{
			//заполним таблицу products
			$sql = "INSERT INTO ".$table." (product_id, product_name, product_price, product_article, product_quantity, date_create, hidden)
				VALUES (RAND()*(10000),'Рис', 49.9, RAND()*(10000), 2000, '2020.12.22', false),";
			$sql .= "(RAND()*(10000),'Овсянка', 23.9, RAND()*(10000), 1000, '2020.11.23', false),";
			$sql .= "(RAND()*(10000), 'Масло', 116.43, RAND()*(10000), 3500, '2020.12.25', false),";
			$sql .= "(RAND()*(10000), 'Молоко', 53.9, RAND()*(10000), 2500, '2020.12.26', false)";

			provideMySQLQuery($conn, $sql);
		}

		mysqli_close($conn);
	}
	
	public static function dropSQLTable($table, $servername, $username, $password, $db)
	{
		$conn = checkMySQLconnection($servername, $username, $password);

		//Установка кодировки
		mysqli_set_charset($conn, "utf8");


		//соединяемся с базой данных goods
		mysqli_select_db($conn, $db);

		$sql = "DROP TABLE ".$table;
		
		provideMySQLQuery($conn, $sql);

		mysqli_close($conn);
	}
	
	public static function updateSQLTable($table, $servername, $username, $password, $db)
	{
		$conn = checkMySQLconnection($servername, $username, $password);

		//Установка кодировки
		mysqli_set_charset($conn, "utf8");


		//соединяемся с базой данных goods
		mysqli_select_db($conn, $db);
		
		$sql = "";

		if (isset($_POST['val']) && isset($_POST['id'])) {
			$sql = "UPDATE ".$table." SET product_quantity = product_quantity + ".$_POST['val']."  WHERE id = ".$_POST['id'];
		}

		if (isset($_POST['hiddenBool']) && isset($_POST['id'])) {
			$sql = "UPDATE ".$table." SET hidden = ".$_POST['hiddenBool']." WHERE id = ".$_POST['id'];
		}

		provideMySQLQuery($conn, $sql);

		mysqli_close($conn);
	}
	
	public static function createDB($servername, $username, $password, $db, $conn)
	{
		$closeConn = FALSE;
		
		if (!(isset ($conn)))
		{
			$conn = checkMySQLconnection($servername, $username, $password);
		
			//Установка кодировки
			mysqli_set_charset($conn, "utf8");
			$closeConn = TRUE;
		}

		//создаем новую базу данных
		$sql = "CREATE DATABASE $db";
		provideMySQLQuery($conn, $sql);

		if ($closeConn == TRUE)
			mysqli_close($conn);
	}
	
	public static function dropDB($servername, $username, $password, $db)
	{
		$conn = checkMySQLconnection($servername, $username, $password);
 
		//Установка кодировки
		mysqli_set_charset($conn, "utf8");

		//создаем новую базу данных
		$sql = "DROP DATABASE $db";
		provideMySQLQuery($conn, $sql);

		mysqli_close($conn);
	}
	
}

?>