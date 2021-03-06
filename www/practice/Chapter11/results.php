<html>
<head>
  <title>Book-O-Rama Search Results</title>
</head>
<body>
<h1>Book-O-Rama Search Results</h1>
<?php
  // create short variable names
  $searchtype=$_POST['searchtype'];
  $searchterm=trim($_POST['searchterm']);

  if (!$searchtype || !$searchterm) {
     echo 'You have not entered search details.  Please go back and try again.';
     exit;
  }

  if (!get_magic_quotes_gpc()){
    $searchtype = addslashes($searchtype);
    $searchterm = addslashes($searchterm);
  }

  @$db = new mysqli('localhost', 'truekevin', 'zkvp24ek');
  $db->select_db('truekevin');

  if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }

  $query = "select * from books where ".$searchtype." like '%".$searchterm."%'";
  $result = $db->query($query);

  $num_results = $result->num_rows;

  echo "<p>Number of books found: ".$num_results."</p>";

  for ($i=0; $i <$num_results; $i++) {
     $row = $result->fetch_array();
     echo "<p><strong>".($i+1).". Title: ";
     echo htmlspecialchars(stripslashes($row[0]));
     echo "</strong><br />Author: ";
     echo stripslashes($row[1]);
     echo "<br />ISBN: ";
     echo stripslashes($row[2]);
     echo "<br />Price: ";
     echo stripslashes($row[3]);
     echo "</p>";
  }

  $result->free();
  $db->close();

?>
</body>
</html>
