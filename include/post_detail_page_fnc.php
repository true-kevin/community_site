<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/db_fnc.php');
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/share_output_fnc.php');
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_output_fnc.php');


function display_post_detail($request, $session, $post_header, $post_body, $post_comment, $current_tab, $page_title)
{

	if(!isset($request['post_id']))
	{
		header('Location: post_list.php');
		exit;
	}
	else
	{
		if(isset($request['pg']))
		{
			$pg = $request['pg']; //목록으로 돌아갈 페이지
		}
		else
		{
			$pg = 1;
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
		}

		$id = intval($request['post_id']);
		$db = db_connect();
		$qr="select * from ".$post_body." where post_id = ".$id;
		@ $result = $db->query($qr);
		if($result->num_rows != 1)
		{
			header('Location: post_list.php');
			exit;
		}
		else
		{
			$body_row = $result->fetch_array(); // 내용 출력
			
			// 태그 사용이 금지된 글만 htmlspecialchars를 해준다.
			if($body_row['is_tag'] == 0)
			{
				$content = (htmlspecialchars($body_row['post_content']));
			}
			else
			{
				$content = $body_row['post_content'];
			}


			if($body_row['align'] == 1)
			{
				$align_center='text-align:center;';
			}
			else
			{
				$align_center='';
			}


			$qr="select * from ".$post_header." where post_id = ".$id;
			@ $result = $db->query($qr);
			if($result->num_rows != 1)
			{
				header('Location: post_list.php');
				exit;
			}
			else
			{
				$header_row = $result->fetch_array();
				$title = (htmlspecialchars($header_row['post_title']));
				$user = (htmlspecialchars($header_row['post_user']));
				$date = $header_row['post_date'];
				$user_id = $header_row['user_id'];
				$views = $header_row['views'];
			}

			// 조회수 추가
			$qr="update ".$post_header." set views = (views+1) where post_id = ".$id;
			$db->query($qr);
		}

	}

	// 회원 글에 유저 마크를 해준다.
	$user_mark = '';
	if(!empty($user_id))
	{
		$user_mark = '<span title="회원" class="glyphicon glyphicon-user" style="color:#FFA07A;"></span> ';
	}

	// 검색된 부분을 하일라이트 해준다.
	$search_query = htmlspecialchars($search_query);
	if($search_type == 1)
	{
		// title과 content는 위에서 이미 htmlspecialchars가 되어 있다. 또한 이 경우는 slashes함수가 필요 없다.
		$title = str_replace($search_query, '<mark>'.$search_query.'</mark>', $title);
		$content = nl2br(str_replace($search_query, '<mark>'.$search_query.'</mark>', $content));
	}
	elseif($search_type == 2) // 제목만 하일라이트
	{
		$title = str_replace($search_query, '<mark>'.$search_query.'</mark>', $title);
		$content = nl2br($content);
	}
	elseif($search_type == 3) // 내용만 하일라이트
	{
		$content = nl2br(str_replace($search_query, '<mark>'.$search_query.'</mark>', $content));
	}
	else
	{
		$content = nl2br($content);
	}

	display_header($page_title, $current_tab);
	?>
<style>
img {max-width:100%};
iframe {max-width:100%};
</style>
	<div class="container-fluid page_container" style="max-width: 1000px;">
		<div class="row" style="margin-top:20px">
			<div>
				<span style="font-size:12px; margin-left: 10px; background:#337ab7; color:white; padding:2px; border-radius:3px;"><?echo $id;?></span>
				<span class="small" style="margin-left:10px;"><?echo $date;?></span>
				<span style="color:#2E8B57; margin-left:10px;"><?echo $user_mark.$user;?></span>
			</div>
			<div style="font-weight:bold; color:#337ab7; text-align:center; font-size: 17px;"><?echo $title;?></div>
		</div>
		
		<hr/>

		<div style="min-height:200px;font-size:15px;<?echo $align_center;?>"><?echo $content; //내용 출력?></div>

		<hr/>
		
		
		<? 
		// 비회원글의 삭제, 수정 버튼
		if(empty($user_id))
		{
			$del_modi_button = '
				<a class="btn btn-primary" onclick="show_form(\'post_delete\');">삭제</a>
				<button type="button" class="btn btn-primary" onclick="show_form(\'post_modify\');">수정</button>';
		}
		else
		{
			// 로그인 회원 본인의 삭제 수정 버튼
			if(isset($session['user']) && $session['user']['id'] == $user_id)
			{
				$del_modi_button = '
					<a class="btn btn-primary" onclick="delete_confirm(\'post_delete\');">삭제</a>
					<a href="post_modify.php?pg='.$pg.'&post_id='.$id.$search_get.'" class="btn btn-primary">수정</a>';
			}
			// 다른 회원의 삭제 수정 버튼은 표시 안한다.
			else
			{
				$del_modi_button = '';
			}
		}
		?>
		<div class="row text-right">
			<div class="btn-group" style="margin: 0px 20px 5px 0px;">
				<?echo $del_modi_button;?>
				<button type="button" class="btn btn-primary" onclick="show_form('comment_form');">댓글 쓰기</button>
				<a href="post_list.php?pg=<?echo $pg.$search_get;?>" class="btn btn-primary">목록으로</a>
			</div>
		</div>

		<?//포스트 지우기 타입 3?>
		<form id="post_delete" action="post_process.php?pg=<?echo $pg;?>&post_id=<?echo $id.$search_get;?>" method="post" accept-charset="utf-8" style="position:relative;">
			<input type="hidden" name="type" value="3">
			<?if(empty($user_id)) // 비회원 글일 때만 비밀번호 인풋이 필요하다.
			{
			?>
			<input style="position:absolute; right:110px; width:150px" class="form-control" maxlength="10" type="password" name="pwd" placeholder="비밀번호 입력">
			<button style="position:absolute; right:5px; width:100px" type="submit" class="btn btn-default">지우기</button>
			<?
			}
			?>
		</form>

		<?//포스트 수정 타입 4 사실 수정 페이지에서 다시 타입값을 보내기 때문에 여기서 보내는 건 무의미함?>
		<form id="post_modify" action="post_modify.php?pg=<?echo $pg;?>&post_id=<?echo $id.$search_get;?>" method="post" accept-charset="utf-8" style="position:relative;">
			<input type="hidden" name="type" value="4">
			<?if(empty($user_id)) // 비회원 글일 때만 비밀번호 인풋이 필요하다.
			{
			?>
			<input style="position:absolute; right:110px; width:150px" class="form-control" type="password"  maxlength="10" name="pwd" placeholder="비밀번호 입력">
			<button style="position:absolute; right:5px; width:100px" type="submit" class="btn btn-default">수정</button>
			<?
			}
			?>
		</form>
		
		<?//코멘트 작성 타입 2?>
		<form id="comment_form" action="post_process.php?pg=<?echo $pg;?>&post_id=<?echo $id.$search_get;?>" method="post" accept-charset="utf-8" style="position:relative;">
			<div class="form-group text-right">
				<input type="hidden" name="type" value="2">
				<input type="hidden" name="rand" value="<?echo mt_rand().'2'; //인서트할 땐 랜덤값 + type값을 보내준다.?>"> 
				<textarea id="comment_text" class="form-control" rows="4" name="comment" placeholder="댓글 입력"></textarea>
				<button style="margin:3px 0px 24px 0px;" type="submit" class="btn btn-default">댓글 작성</button>
			</div>
			<?if(!isset($session['user']))
			{
			?>
			<div class="form-group text-right" style="position:absolute; top:96px;">
				<input class="form-control" type="text" style="max-width:200px;margin-bottom:2px;" name="user" maxlength="10" placeholder="이름: (10자 이내)">
				<input class="form-control" type="password" style="max-width:200px" name="pwd" maxlength="10" placeholder="비밀번호: (10자 이내)">
			</div>
			<?
			}
			?>
		</form>

		<?display_comment($id, $pg, $post_comment, $post_header);//댓글 출력?> 


	</div>
<?
	display_footer();

}
?>