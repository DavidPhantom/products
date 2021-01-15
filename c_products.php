<?php

class CProducts
{
	public function createSQLTable($table)
    {
        $this->sql = "CREATE TABLE ".$table." (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,product_id INT(5),
		product_name CHAR(60) CHARSET utf8,
		product_price FLOAT,
		product_article INT(5),
		product_quantity INT(6),
		date_create DATE,
		hidden BOOLEAN
		)";
		return $this->sql;
    }	
	
	private $sql;
}

?>