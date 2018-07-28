<?
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

function steal($start, $end)
{
	$result_arr = array();
	$num = 0;
	
	for($i = $start; $i <= $end; $i++)
	{
		// 줄넘김 제거
		$con = get_content('http://www.gasengi.com/main/board.php?bo_table=humor03&wr_id='.$i);
		$con = str_replace("\n", "", $con);
		$con = str_replace("\r", "", $con);
		$origin = $con; // 줄넘김 된 변수 제목, 내용에 공통적으로 사용함

		// 내용 뽑아 내기
		preg_match("/<!-- 내용 출력 -->.*<!-- 테러 태그 방지용 -->/i", $origin, $arr);
		if(!isset($arr[0]))
		{
			continue;
		}
		if(preg_match("/gasengi\.com/i", $arr[0]))
		{
			continue;
		}
		$num++;

		$con = $arr[0];
		$con = str_replace('<!-- 내용 출력 -->		<br><div id="writeContents" style="word-break:break-all;">', "", $con);
		$con = str_replace('</div>                        <!-- 테러 태그 방지용 -->', "", $con);
		$con = str_replace("name='target_resize_image[]' onclick='image_window(this)' style='cursor:pointer;' ", "", $con);
		$result_arr[$num]['conetent'] = $con;

		// 제목 뽑아 내기
		$result = preg_match('/<div style="color:#505050; font-size:13px; font-weight:bold; word-break:break-all;">.*<td align="right" style="padding:5px 6px;text-align:right;" width="120"/i', $origin, $arr);
		$con = $arr[0];
		$con = strip_tags($con);
		$result_arr[$num]['title'] = $con;

		// 변수 모두 지우기
		unset($con, $result, $origin, $arr);
	}
	return $result_arr;
}

/*
$result = steal(795592, (795592+100));
echo '<xmp>';
print_r($result);
echo '</xmp>';
*/


?>
