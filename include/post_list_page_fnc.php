<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/share_output_fnc.php');
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_output_fnc.php');

function display_post_detail($request, $post_header, $post_body, $h1, $current_tab, $page_title)
{

	$y_num = 10; // 한페이지 표시 레코드 수

	if(empty($request['pg']))
	{
		$pg = 1;
	}
	else
	{
		$pg = $request['pg'];
	}

	// 검색 타입, 검색어 둘 중 하나만 없어도 둘다 없는 것으로 본다.
	$search_get = '';
	if(!isset($request['search_type']) || !isset($request['search_query']))
	{
		$search_type = null;
		$search_query = null;
	}
	else
	{
		$search_type = trim($request['search_type']);
		$search_query = trim($request['search_query']);
		$search_get = '&search_type='.$search_type.'&search_query='.htmlspecialchars($search_query);

		$sel1 = $sel2 = $sel3 = $sel4 = '';
		$tmp = 'sel'.$search_type; // selected1~4까지 가변 변수 이름을 만들어준다.
		$$tmp = 'selected'; // 가변 변수에 'selected' 문자열을 넣어준다.
	}

	//print_r($request);
	display_header($page_title, $current_tab);

	?>

	<h1 class="text-center" style="margin-bottom:40px;margin-top:60px;"><a href="post_list.php?pg=1" style="text-decoration:none;color:white;background:#337ab7;padding:5px;border-radius:5px;"><?echo $h1;?><span class="glyphicon glyphicon-apple"></a></h1>

	<div class="container-fluid page_container" style="max-width:1000px;">

		<?display_post_list($pg, $y_num, $post_header, $post_body, $search_type, $search_query); //리스트 출력?>
		
		<div class="row text-right">
			<a style="margin-right:25px;" href="post_input.php?pg=<?echo $pg.$search_get;?>" class="btn btn-primary" role="button">글 쓰기</a>
		</div>

		<?echo display_pagination($pg, 10, $y_num, 'l_page', $post_header, $post_body, $search_type, $search_query); // 10개짜리 페이지네이션 출력?>
		<?echo display_pagination($pg, 5, $y_num, 's_page', $post_header, $post_body, $search_type, $search_query); // 5개짜리 페이지네이션 출력?>
		
		<form action="post_list.php" method="get" accept-charset="utf-8" style="position:relative;margin-bottom:50px;">
			<select name="search_type" class="form-control" style="width:110px;position:absolute;right:209px;top:0px;">
				<option value="1" <?echo $sel1;?>>제목+내용</option>
				<option value="2" <?echo $sel2;?>>제목</option>
				<option value="3" <?echo $sel3;?>>내용</option>
				<option value="4" <?echo $sel4;?>>글쓴이</option>
			</select>
			<input type="text" class="form-control" name="search_query" value="<?echo htmlspecialchars($search_query);?>" style="width:150px;position:absolute;right:54px;top:0px;">
			<input type="submit" value="검색"  class="btn btn-primary" style="position:absolute;right:-4px;top:0px;">
		</form>
		
	</div>


<?
	display_footer();

}
?>