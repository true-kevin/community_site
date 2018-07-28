<html>
<head>
  <title>Stock Quote from NASDAQ</title>
</head>
<body>
<?php

function get_content($url) {
$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)';
$curlsession = curl_init ();
curl_setopt ($curlsession, CURLOPT_URL, $url);
curl_setopt ($curlsession, CURLOPT_HEADER, 0);
curl_setopt ($curlsession, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($curlsession, CURLOPT_POST, 0);
curl_setopt ($curlsession, CURLOPT_USERAGENT, $agent);
curl_setopt ($curlsession, CURLOPT_REFERER, "");
curl_setopt ($curlsession, CURLOPT_TIMEOUT, 3);
$buffer = curl_exec ($curlsession);
$cinfo = curl_getinfo($curlsession);
curl_close($curlsession);
if ($cinfo['http_code'] != 200)
{
return "";
}
return $buffer;
}
$contents= get_content("http://search.daum.net/search?w=tot&DA=Z8T&q=%EA%B4%91%EB%AA%85%EC%8B%9C%20%EA%B4%91%EB%AA%856%EB%8F%99%20%EB%82%A0%EC%94%A8&rtmaxcoll=Z8T");


$contents = str_replace("\n", '', $contents); 

//echo $contents;


preg_match('/<div class="cont_today">.*--> <div class="cont_tomorrow" style="display:none"> <div class="info_tomorrow fst">/i', $contents, $result);

$contents = strip_tags($result[0]);

echo $contents;

  
?>
</body>
</html>
