<html>
<head>
  <title>Browse Directories</title>
</head>
<body>
<h1>Browsing</h1>
<?php

echo '<xmp>';

foreach ($_SERVER as $k=>$v)
{
	echo $k.'=> '.$v."\n";
}

echo '</xmp>';

//phpinfo();


  $dir = dir("/home/hosting_users/truekevin/uploads/");

  echo "<p>Handle is $dir->handle</p>";
  echo "<p>Upload directory is $dir->path</p>";
  echo '<p>Directory Listing:</p><ul>';
  
  while(false !== ($file = $dir->read()))
    //strip out the two entries of . and ..
  	if($file != "." && $file != "..")
  	{
		echo '<a href="filedetails.php?file='.$file.'">'.$file.'</a><br>';
  	}
  echo '</ul>';
  $dir->close();
?>
</body>
</html>
