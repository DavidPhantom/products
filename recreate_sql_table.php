<?php

require_once ("c_products.php");

CProducts::recreateSQLTable($table, $servername, $username, $password, $db);

?>