<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/db_fnc.php');

 // 현재 페이지 번호, 한 페이지에 게시물 갯 수, 포스트 헤더 테이블 명, 포스트 바디 테이블명 검색어 타입, 검색어
function display_post_list($current_page, $y_num, $post_header, $post_body, $search_type=null, $search_query=null, $path='')
{
	if(empty($current_page))
	{
		$current_page = 1;
	}

	/* 검색어 쿼리 만들기 시작*/
	// 검색 타입, 검색어 둘 중 하나만 없어도 둘다 없는 것으로 본다.
	$where_qr = ''; //sql where문
	$search_get = ''; //검색어 get 쿼리

	// 혹시 모르니 한번 더 트림 해준다.
	$search_type = trim($search_type);
	$search_query= trim($search_query);

	if(!empty($search_type) && !empty($search_query))
	{
		// 일단 검색어 get 쿼리를 만들어준다. 검색 타입이 맞지 않으면 default에서 비워준다.
		$search_get = '&search_type='.$search_type.'&search_query='.htmlspecialchars($search_query);

		$search_query = addslashes($search_query); // sql에 들어갈 검색어는 애드슬래쉬 해준다.

		switch($search_type)
		{
			case '1': // 제목+내용
				$where_qr = " 
				and 
				(
					post_title like '%".$search_query."%' 
					or post_id in 
					(
						select post_id from ".$post_body." where post_content like '%".$search_query."%'
					)
				)";
				break;
			case '2': // 제목
				$where_qr = " and post_title like '%".$search_query."%'";
				break;
			case '3': // 내용
				$where_qr = " and post_id in (select post_id from ".$post_body." where post_content like '%".$search_query."%')";
				break;
			case '4': // 글쓴이
				$where_qr = " and post_user = '".$search_query."'";
				break;
			default: // 맞는 검색 타입 없으면 검색어 get 쿼리를 비워준다.
				$search_get = '';
		}
	}
	/* 검색어 쿼리 만들기 종료*/


	$list = '<li class="list-group-item text-center">이 페이지엔 표시할 게시물이 없습니다.</li>'; // 게시물이 없을 때 표시할 문자열
	if($current_page != 0 && $y_num !=0)
	{
		$end = $current_page * $y_num - 1; 
		$start = $end - $y_num + 1;

		$db = db_connect();
		$qr = "select * from ".$post_header." where 1".$where_qr." order by post_id desc limit ".$start.", ".$y_num; // 쿼리에는 end값이 안들어 간다.
		@ $result = $db-> query($qr);
		if($result->num_rows)
		{
			$list = ''; // 자료가 있으므로 문자열 다시 비워 준다.
			while($row = $result->fetch_array())
			{
				// 회원 글에 유저 마크를 해준다.
				$member_mark = '';
				if(!empty($row['user_id']))
				{
					$member_mark = '<span title="회원" class="glyphicon glyphicon-user" style="color:#FFA07A;"></span> ';
				}
				

				// 검색된 부분을 하일라이트 해준다.
				$post_title = htmlspecialchars($row['post_title']);
				if($search_type == 1 || $search_type == 2)
				{
					/*
					fetch된 결과는 자동으로 stripslashes가 되는 것으로 보여진다.
					따라서 위에서 addslashes 된 변수 $search_query를 stripslashes 해준 후 대입해야 절차가 맞다. 여기서는
					*/
					$search_query = htmlspecialchars(stripslashes($search_query));
					$post_title = str_replace($search_query, '<mark>'.$search_query.'</mark>', $post_title);
				}

				// 댓글 수 표시
				$re_num = '';
				if($row['re_num'] != 0)
				{
					$re_num = '<span style="font-size:12px;color:#5bc0de">['.$row['re_num'].']</span>';
				}
				
				$list .= '
				<li class="list-group-item row" style="height:55px; padding-top:5px;">
					<span title="조회수" class="badge" style="border:1px solid;background:none;color:gray;">'.$row['views'].'</span>
					<div class="li_header" style="max-width:900px; margin:0 auto;">
						<span style="font-size:12px; margin-right: 10px; background:#337ab7; color:white; padding:2px; border-radius:3px;">'.$row['post_id'].'</span>
						<span style="font-size:12px; margin-right: 10px;">'.$row['post_date'].'</span>
						<span style="font-size:14px; color:#2E8B57">'.$member_mark.htmlspecialchars($row['post_user']).'</span>
					</div>
					<div class="li_title">
						'.$re_num.'
						<a style="font-size: 17px;" href="'.$path.'post_detail.php?pg='.$current_page.'&post_id='.$row['post_id'].$search_get.'">'.$post_title.'</a>
					</div>
				</li>';
			}
		}
	}
	$list = '
	<ul class="list-group">
		'.$list.'
	</ul>';
	echo $list;
}

//현재 페이지, 페이지네이션 수, 한 페이지에 게시물 수, 페이지네이션 id(css 적용 용도), 포스트 헤더tb명, 포스트 바디tb명, 검색 타입, 검색어
function display_pagination($current_page, $x_num, $y_num, $id, $post_header, $post_body, $search_type=null, $search_query=null)
{
	
	/* 검색어 쿼리 만들기 시작*/
	// 검색 타입, 검색어 둘 중 하나만 없어도 둘다 없는 것으로 본다.
	$where_qr = '';
	$search_get = '';

	// 혹시 모르니 한번 더 트림 해준다.
	$search_type = trim($search_type);
	$search_query= trim($search_query);

	if(!empty($search_type) && !empty($search_query))
	{
		// 일단 검색어 get 쿼리를 만들어준다. 검색 타입이 맞지 않으면 default에서 비워준다.
		$search_get = '&search_type='.$search_type.'&search_query='.htmlspecialchars($search_query);

		$search_query = addslashes($search_query); // sql에 들어갈 검색어는 애드슬래쉬 해준다.

		switch($search_type)
		{
			case '1': // 제목+내용
				$where_qr = " 
				and 
				(
					post_title like '%".$search_query."%' 
					or post_id in 
					(
						select post_id from ".$post_body." where post_content like '%".$search_query."%'
					)
				)";
				break;
			case '2': // 제목
				$where_qr = " and post_title like '%".$search_query."%'";
				break;
			case '3': // 내용
				$where_qr = " and post_id in (select post_id from ".$post_body." where post_content like '%".$search_query."%')";
				break;
			case '4': // 글쓴이
				$where_qr = " and post_user = '".$search_query."'";
				break;
			default: // 맞는 검색 타입 없으면 검색어 get 쿼리를 비워준다.
				$search_get = '';
		}
	}
	/* 검색어 쿼리 만들기 종료*/

	$db = db_connect();
	$qr = "select count(*) from ".$post_header." where 1 ".$where_qr;
	$result = $db-> query($qr);
	$row = $result-> fetch_row();
	$total = $row[0]; // 총 레코드 수

	if($total == 0) // $total값이 0이면 빈 문자열을 출력하고 함수를 종료한다.
	{
		return '<br/>';
	}

	$max_page = ceil($total / $y_num);
	$end_max_page = ceil($max_page / $x_num) * $x_num; // start_max_page를 구하기 위한 변수다. 실제로는 max_page를 기준으로 한다.
	$start_max_page = $end_max_page - $x_num + 1;
	
	// 최대 페이지보다 현재 페이지가 큰 경우 최대 페이지가 현재 페이지가 된다.
	$over_page = 0; // 오버페이지의 액티브를 막기 위한 플래그 변수
	if($current_page > $max_page)
	{
		$current_page = $max_page;
		$over_page = 1;
	}
	// 현재 페이지가 0보다 작거나 같으면 1이 된다.
	if($current_page <= 0)
	{
		$current_page = 1;
	}
	
	$end_page = ceil($current_page / $x_num) * $x_num;
	$start_page = $end_page - $x_num + 1;
	
	if($end_page > $max_page)
	{
		$end_page = $max_page;
	}
	
	// 모바일에서는 처음, 끝 버튼 표시하기엔 너무 좁아서 l_page일 때만 표시한다.
	if($id == 'l_page')
	{
		$previous = '
		<li><a href="post_list.php?pg=1'.$search_get.'"><span class="glyphicon glyphicon-backward"></span></a></li>
		<li><a href="post_list.php?pg='.($start_page-1).$search_get.'"><span class="glyphicon glyphicon-chevron-left"></span></a></li>';
		$next = '
		<li><a href="post_list.php?pg='.($end_page+1).$search_get.'"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
		<li><a href="post_list.php?pg='.($max_page).$search_get.'"><span class="glyphicon glyphicon-forward"></span></a></li>';
	}
	else
	{
		$previous = '<li><a href="post_list.php?pg='.($start_page-1).$search_get.'"><span class="glyphicon glyphicon-chevron-left"></span></a></li>';
		$next = '<li><a href="post_list.php?pg='.($end_page+1).$search_get.'"><span class="glyphicon glyphicon-chevron-right"></span></a></li>';
	}

	if($start_page == 1){ $previous = ''; } // 이전 페이지 없음
	if($start_page == $start_max_page){ $next = ''; } // 다음 페이지 없음

	//echo "current_page = $current_page, end_page = $end_page, start_page = $start_page, max_page = $max_page, end_max_page = $end_max_page, start_max_page = $start_max_page";

	$li = '';
	$active = '';

	for($i = $start_page; $i <= $end_page; $i++)
	{
		if($i == $current_page && $over_page == 0) //존재하는 것 이상의 페이지 값이 강제로 들어올 때는 액티브 하지 않는다.
		{
			$active = ' class="active"';
		}
		else
		{
			$active = '';
		}
		$li .= '<li'.$active.'><a href="post_list.php?pg='.$i.$search_get.'">'.$i.'</a></li>';
	}

	$display='
	<div id="'.$id.'" class="row">
		<div class="col-xs-12 text-center">
			<ul class="pagination">
				'.$previous.$li.$next.'
			</ul>
		</div>
	</div>';
	echo $display;
}

// 부모 id, 현재 페이지, comment 테이블 명, header 테이블명(댓글 수를 업데이트 해주기 위해 받는다.)
function display_comment($parent_id, $pg, $post_comment, $post_header)
{
	$db = db_connect();
	$qr = "select * from ".$post_comment." where comment_parent = ".$parent_id." order by comment_id desc";
	$result = $db->query($qr);
	
	$li = '';
	$comment_num = '';
	
	$num_rows = $result->num_rows;
	
	if($num_rows != 0)
	{
		$comment_num = '<div style="margin:15px 0px 5px 5px;">댓글: '.$num_rows.'개</div>';
	}

	while($row = $result-> fetch_array())
	{
		// 비회원 코멘트
		if(empty($row['user_id']))
		{
			$li .= '
			<li id="co_li_'.$row['comment_id'].'" class="list-group-item">
				<div style="position:relative;">
					<div class="small" style="padding-right:70px;">'.$row['comment_date'].'</div>
					<div style="color:#2E8B57; padding-right:70px;">'.htmlspecialchars($row['comment_user']).'</div>
					<div class="btn-group" style="position:absolute; right:0px; top:0px;">
						<button onclick="show_form2(\''.$row['comment_id'].'\');" title="삭제" type="button" class="btn btn-primary" style="height:27px;padding:5px 10px 5px 10px;"><span class="glyphicon glyphicon-remove"></span></button>
						<button onclick="show_form3(\''.$row['comment_id'].'\');" title="수정" type="button" class="btn btn-primary" style="height:27px;padding:5px 10px 5px 10px;"><span class="glyphicon glyphicon-pencil"></span></button>
					</div>
					<form id="co_del_form_'.$row['comment_id'].'" action="post_process.php?pg='.$pg.'&post_id='.$parent_id.'" method="post" accept-charset="utf-8" style="position:relative;display:none;">
						<input type="hidden" name="type" value="5">
						<input type="hidden" name="co_id" value="'.$row['comment_id'].'">
						<input id="co_del_input_'.$row['comment_id'].'" style="position:absolute; top:-5px; right:105px; width:150px" class="form-control" type="password" maxlength="10" name="pwd" placeholder="비밀번호 입력">
						<button style="position:absolute; top:-5px; right:0px; width:100px" type="submit" class="btn btn-default">삭제</button>
					</form>
				</div>
				<div id="co_con_'.$row['comment_id'].'" style="font-size:15px;">'.nl2br(htmlspecialchars($row['comment_content'])).'</div>
				<form id="co_modi_'.$row['comment_id'].'" style="position:relative;display:none;" action="post_process.php?pg='.$pg.'&post_id='.$parent_id.'" method="post" accept-charset="utf-8">
					<input type="hidden" name="type" value="6">
					<input type="hidden" name="co_id" value="'.$row['comment_id'].'">
					<textarea id="co_text_'.$row['comment_id'].'" name="content" style="height:130px; margin-bottom:37px; background:#F0F8FF;" class="form-control">'.htmlspecialchars($row['comment_content']).'</textarea>
					<input type="password" maxlength="10" name="pwd" placeholder="비밀번호 입력" class="form-control" style="position:absolute; top:134px; right:105px; width:150px">
					<button style="position:absolute; top:134px; right:0px; width:100px" type="submit" class="btn btn-default">댓글 수정</button>
				</form>
			</li>';
		}
		else
		{
			// 회원 코멘트
			// 로그인 회원 본인의 코멘트
			if(isset($_SESSION['user']) && $_SESSION['user']['id'] == $row['user_id'])
			{
				$li .= '
				<li id="co_li_'.$row['comment_id'].'" class="list-group-item">
					<div style="position:relative;">
						<div class="small" style="padding-right:70px;">'.$row['comment_date'].'</div>
						<div style="color:#2E8B57; padding-right:70px;"><span title="회원" class="glyphicon glyphicon-user" style="color:#FFA07A;"></span> '.htmlspecialchars($row['comment_user']).'</div>
						<div class="btn-group" style="position:absolute; right:0px; top:0px;">
							<button onclick="delete_confirm2(\''.$row['comment_id'].'\');" title="삭제" type="button" class="btn btn-primary" style="height:27px;padding:5px 10px 5px 10px;"><span class="glyphicon glyphicon-remove"></span></button>
							<button onclick="show_form3(\''.$row['comment_id'].'\');" title="수정" type="button" class="btn btn-primary" style="height:27px;padding:5px 10px 5px 10px;"><span class="glyphicon glyphicon-pencil"></span></button>
						</div>
						<form id="co_del_form_'.$row['comment_id'].'" action="post_process.php?pg='.$pg.'&post_id='.$parent_id.'" method="post" accept-charset="utf-8" style="position:relative;display:none;">
							<input type="hidden" name="type" value="5">
							<input type="hidden" name="co_id" value="'.$row['comment_id'].'">
						</form>
					</div>
					<div id="co_con_'.$row['comment_id'].'" style="font-size:15px;">'.nl2br(htmlspecialchars($row['comment_content'])).'</div>
					<form id="co_modi_'.$row['comment_id'].'" style="position:relative;display:none;" action="post_process.php?pg='.$pg.'&post_id='.$parent_id.'" method="post" accept-charset="utf-8">
						<input type="hidden" name="type" value="6">
						<input type="hidden" name="co_id" value="'.$row['comment_id'].'">
						<textarea id="co_text_'.$row['comment_id'].'" name="content" style="height:130px; margin-bottom:37px; background:#F0F8FF;" class="form-control">'.htmlspecialchars($row['comment_content']).'</textarea>
						<button style="position:absolute; top:134px; right:0px; width:100px" type="submit" class="btn btn-default">댓글 수정</button>
					</form>
				</li>';
			}
			// 다른 회원의 코멘트
			else
			{
				$li .= '
				<li id="co_li_'.$row['comment_id'].'" class="list-group-item">
					<div style="position:relative;">
						<div class="small" style="padding-right:70px;">'.$row['comment_date'].'</div>
						<div style="color:#2E8B57; padding-right:70px;"><span title="회원" class="glyphicon glyphicon-user" style="color:#FFA07A;"></span> '.htmlspecialchars($row['comment_user']).'</div>
					</div>
					<div id="co_con_'.$row['comment_id'].'" style="font-size:15px;">'.nl2br(htmlspecialchars($row['comment_content'])).'</div>
				</li>';
			}
		}
	}
	$display = '
	'.$comment_num.'
	<ul class="list-group">
		'.$li.'
	</ul>';

	// 댓글 수를 post_header에 업데이트 해준다.
	$qr = "update ".$post_header." set re_num = ".$num_rows." where post_id = ".$parent_id;
	$db->query($qr);

	echo $display;
}
?>