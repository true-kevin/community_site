<?php

//create short variable names
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$feedback = trim($_POST['feedback']);


if(ereg('^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $email))
	echo '정상적인 이메일이다';
else
	echo '잘못된 이메일이다';
	exit;


//set up some static information
$toaddress = "zpqlssot@naver.com";

$subject = "Feedback from web site";

$mailcontent = "Customer name: ".$name."\n".
			   "Customer email: ".$email."\n".
               "Customer comments:\n".$feedback."\n";

$fromaddress = "From: webserver@example.com";

//invoke mail() function to send mail
mail($toaddress, $subject, $mailcontent, $fromaddress);

?>
<html>
<head>
<title>Bob's Auto Parts - Feedback Submitted</title>
</head>
<body>
<h1>Feedback submitted</h1>
<p>Your feedback (shown below) has been sent.</p>
<p>
<?

echo nl2br(addslashes($feedback))."\n<br/>";
echo nl2br(stripslashes(addslashes($feedback)))."\n<br/>";
echo !get_magic_quotes_gpc();


?> </p>
</body>
</html>
