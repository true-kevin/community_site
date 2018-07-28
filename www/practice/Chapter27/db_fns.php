<?php

function db_connect() {
   $result = new mysqli('localhost', 'truekevin', 'zkvp24ek', 'truekevin');
   if (!$result) {
     throw new Exception('Could not connect to database server');
   } else {
     return $result;
   }
}

?>
