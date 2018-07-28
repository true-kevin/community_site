<?php
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/db_fnc.php');

session_start();

if(isset($_GET['txt']))
{
	$db = db_connect();
	$pre = $db->prepare("insert into chat values('', ?, ?, now())");
	$pre->bind_param('ss',$user, $text);
	$user = $_GET['user'];
	$text = $_GET['txt'];
	$pre->execute();
	$db->close();
}

$first_join = 0;
if(empty($_SESSION['chat_pk']))
{
	$qr = "select * from chat order by pk desc limit 0, 1";
	$first_join = 1;
}
else
{
	$qr = "select * from chat where pk > ".$_SESSION['chat_pk'];
}

$db = db_connect();

$result = $db->query($qr);

$data_str = '';
while($row = $result->fetch_assoc())
{
	$data_str .= 
		'<span class="small" style="color:">'.$row['date'].'</span><br/><span style="color:#2E8B57">'.htmlspecialchars($row['user']).'</span>: '. htmlspecialchars($row['content']).'<br/>';
	$_SESSION['chat_pk'] = $row['pk'];
}

$db->close();

$result_arr = array($data_str);
$result_arr = json_encode ($result_arr);

if(!$first_join)
{
	echo $result_arr;
}
?>