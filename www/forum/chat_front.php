<!DOCTYPE html>
<html>
<body>

<h1>Getting server updates</h1>
<div id="result"></div>

<script>
var source = new EventSource("chat_back.php");
source.onmessage = function(event) 
{
	document.getElementById("result").innerHTML += event.data + "<br>";
};

</script>

</body>
</html>


