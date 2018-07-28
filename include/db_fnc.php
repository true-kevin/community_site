<?php

function db_connect()
{
	$result = new mysqli('localhost', 'truekevin', 'zkvp24ek', 'truekevin');
	if (!$result)
	{
		return false;
	}
	return $result;
}

?>
