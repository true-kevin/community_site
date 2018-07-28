<? 
// 자바스크립트로 알림창을 띄우면 이전 페이지로 보낸다.
function display_alert_back($message, $title)
{
	echo '
<!DOCTYPE html><html lang="ko">
<head>
	<title>True Kevin | '.$title.'</title>
	<meta charset="utf-8">
	<script>alert("'.$message.'");history.back();</script>
</head>
<body>
	<h1>'.$message.'</h1>
</body>
</html>';
}

// 알림창을 띄우고 url페이지로 보낸다.
function display_alert_location($message, $title, $url)
{
	echo '
<!DOCTYPE html><html lang="ko">
<head>
	<title>True Kevin | '.$title.'</title>
	<meta charset="utf-8">
	<script>alert("'.$message.'");location.replace(\''.$url.'\');</script>
</head>
<body>
	<h1>'.$message.'</h1>
</body>
</html>';
}
?>