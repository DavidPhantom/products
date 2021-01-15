<?php

require_once ("c_products.php");

CProducts::recreateTable($table, $servername, $username, $password, $db);

?>