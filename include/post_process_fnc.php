<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/db_fnc.php');
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/alert_fnc.php');
session_start();


function post_procedure($request, &$session, $post_header, $post_body, $post_comment)
{
	if(!isset($request['type']))
	{
		header('Location: post_list.php');
		exit;
	}
	else
	{
		foreach($request as $v)
		{
			if(empty($v) || trim($v) == '')
			{
				display_alert_back('모든 내용을 입력하세요.', '에러 페이지');
				exit;
			}
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
			$search_get = '&search_type='.$search_type.'&search_query='.$search_query;
		}

		if($request['type'] == 1) // 새 글쓰기
		{
			
			/* 이미지 태그만 썼는지 확인을 위한 부분 */
			/*
			if(isset($request['is_tag']) && $request['is_tag'] = 'on')
			{
				$check_con = $request['content'];
				// 이미지 태그를 찾아서 모두 빈 문자열로 치환한다.
				preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/", $request['content'], $img_arr);
				for($i=0; $i < sizeof($img_arr[0]); $i++)
				{
					$check_con = str_replace($img_arr[0][$i], "", $check_con);
				}
				// 이미지 태그를 치환한 뒤에도 태그가 남아 있는지 확인한다.
				preg_match("/[<][^>]*[>]/", $check_con, $tag_arr);
				if(!empty($tag_arr[0]) && $session['user']['id'] != 'truekevin') // 관리자만 허용
				{
					display_alert_back('허용되지 않는 태그를 사용하였습니다.', '에러 페이지');
					exit;
				}
				else // 이미지 태그만 사용한 경우
				{
					for($i=0; $i < sizeof($img_arr[0]); $i++)
					{
						$request['content'] = str_replace($img_arr[0][$i], '<img style="max-width:100%;display:block;margin:auto;" src="'.$img_arr[1][$i].'">', $request['content']);
					}
					$is_tag = 1;
				}
			}
			else
			{
				$is_tag = 0;
			}

			// 가운데 정렬
			if(isset($request['align_center']) && $request['is_tag'] = 'on')
			{
				$align = 1;
			}
			else
			{
				$align = 0;
			}
			*/

			$is_tag = 1;
			$align = 0;

			$user = addslashes(trim($request['user']));
			$pwd = $request['pwd'];
			$title = addslashes(trim($request['title']));
			$content = addslashes($request['content']);

			if($session['insert_rand'] == $request['rand'])
			{
				// 쓰기 버튼 연속으로 클릭한 경우다. 인서트 여러번 안되게 막아준다.
				header('Location: post_detail.php?post_id='.$id);
				exit; 
			}
			
			$db = db_connect();
			if(!isset($session['user']))
			{
				$qr = "insert into ".$post_header." (post_title, post_user, post_password, post_date) values
				(
					'$title', '$user', '".sha1($pwd)."', now()
				)";
			}
			else
			{
				$qr = "insert into ".$post_header." (post_title, post_user, post_date, user_id) values
				(
					'$title', '".$session['user']['nickname']."', now(), '".$session['user']['id']."'
				)";
			}
			if(!$db-> query($qr))
			{
				display_alert_back('글쓰기 실패', '에러 페이지');
				exit;
			}
			else
			{
				$id = $db->insert_id; // ".$post_header."에 인서트한 id를 반환한다.

				$qr = "insert into ".$post_body." (post_id, post_content, is_tag, align) value (".$id.", '".$content."', '".$is_tag."', '".$align."')";
				
				if(!$db-> query($qr))
				{
					display_alert_back('글쓰기 실패', '에러 페이지');
					exit;
				}
				// 글쓰기가 성공한 시점
				$session['insert_rand'] = $request['rand'];
				header('Location: post_detail.php?post_id='.$id);
			}
		}
		elseif($request['type'] == 2) // 댓글 쓰기
		{
			$user = addslashes(trim($request['user']));
			$pwd = $request['pwd'];
			$content = addslashes($request['comment']);
			$id = intval($request['post_id']);
			$pg = $request['pg'];

			if($session['insert_rand'] == $request['rand'])
			{
				// 댓글 쓰기 버튼 연속으로 클릭한 경우다. 인서트 여러번 안되게 막아준다.
				header('Location: post_detail.php?pg='.$pg.'&post_id='.$id.$search_get);
				exit;
			}
			
			$db = db_connect();
			
			if(!isset($session['user']))
			{
				$qr = "insert into ".$post_comment." (comment_user, comment_password, comment_date, comment_parent, comment_content) values
				(
					'$user', '".sha1($pwd)."', now(), '$id', '$content'
				)";
			}
			else
			{
				$qr = "insert into ".$post_comment." (comment_user, comment_date, comment_parent, comment_content, user_id) values
				(
					'".$session['user']['nickname']."', now(), '$id', '$content', '".$session['user']['id']."'
				)";
			}

			if(!$db-> query($qr))
			{
				display_alert_back('댓글 쓰기 실패', '에러 페이지');
				exit;
			}
			else
			{
				// 댓글 쓰기가 성공한 시점
				$session['insert_rand'] = $request['rand'];
				header('Location: post_detail.php?pg='.$pg.'&post_id='.$id.$search_get);
			}
			
		}
		elseif($request['type'] == 3) // 포스트 지우기
		{
			$id = intval($request['post_id']);
			$pg = $request['pg'];

			$db = db_connect();
			if(isset($request['pwd']))
			{
				$pwd = $request['pwd'];
				$qr = "select count(*) from ".$post_header." where post_id = $id and post_password = '".sha1($pwd)."'";
				$msg = '비밀번호가 틀렸습니다.';
			}
			else
			{
				if(isset($session['user']))
				{
					$qr = "select count(*) from ".$post_header." where post_id = $id and user_id = '".$session['user']['id']."'";
					$msg = '잘못된 접근입니다.';
				}
				else
				{
					display_alert_back('잘못된 접근입니다.', '에러 페이지');
					exit;
				}
			}
			if(!$result = $db-> query($qr))
			{
				display_alert_back('게시글 지우기 실패', '에러 페이지');
				exit;
			}
			else
			{
				$row = $result->fetch_row();
				if($row[0] != 1)
				{
					display_alert_back($msg, '에러 페이지');
					exit;
				}
				else
				{
					$qr = "delete from ".$post_body." where post_id = $id";
					$db-> query($qr);
					$qr = "delete from ".$post_header." where post_id = $id";
					$db-> query($qr);
					$qr = "delete from ".$post_comment." where comment_parent = $id";
					$db-> query($qr);
					header('Location: post_list.php?pg='.$pg.$search_get);
				}
			}
		}
		elseif($request['type'] == 4) // 포스트 수정하기
		{
			/* 이미지 태그만 썼는지 확인을 위한 부분 */
			/*
			if(isset($request['is_tag']) && $request['is_tag'] = 'on')
			{
				$check_con = $request['content'];
				// 이미지 태그를 찾아서 모두 빈 문자열로 치환한다.
				preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/", $request['content'], $img_arr);
				for($i=0; $i < sizeof($img_arr[0]); $i++)
				{
					$check_con = str_replace($img_arr[0][$i], "", $check_con);
				}
				// 이미지 태그를 치환한 뒤에도 태그가 남아 있는지 확인한다.
				preg_match("/[<][^>]*[>]/", $check_con, $tag_arr);
				if(!empty($tag_arr[0]) && $session['user']['id'] != 'truekevin') // 관리자만 허용
				{
					display_alert_back('허용되지 않는 태그를 사용하였습니다.', '에러 페이지');
					exit;
				}
				else // 이미지 태그만 사용한 경우
				{
					for($i=0; $i < sizeof($img_arr[0]); $i++)
					{
						$request['content'] = str_replace($img_arr[0][$i], '<img style="max-width:100%;display:block;margin:auto;" src="'.$img_arr[1][$i].'">', $request['content']);
					}
					$is_tag = 1;
				}
			}
			else
			{
				$is_tag = 0;
			}

			// 가운데 정렬
			if(isset($request['align_center']) && $request['is_tag'] = 'on')
			{
				$align = 1;
			}
			else
			{
				
			}
			*/

			$align = 0;
			$is_tag = 1;

			$pg = $request['pg'];
			$title = addslashes(trim($request['title']));
			$content = addslashes($request['content']);
			$id = intval($request['post_id']);
			
			$db = db_connect();
			if(isset($request['pwd']))
			{
				$pwd = $request['pwd'];
				$qr = "update ".$post_header." set post_title = '$title', post_date = now() where post_id = $id and post_password = '".sha1($pwd)."'";
			}
			else
			{
				if(isset($session['user']))
				{
					$qr = "update ".$post_header." set post_title = '$title', post_date = now() where post_id = $id and user_id = '".$session['user']['id']."'";
				}
				else
				{
					display_alert_back('잘못된 접근입니다.', '에러 페이지');
					exit;
				}
			}
			$db->query($qr);
			if($db->affected_rows != 1)
			{
				display_alert_back('잘못된 접근입니다.', '에러 페이지');
				exit;
			}
			else
			{
				$qr = "update ".$post_body." set post_content = '$content', is_tag = '".$is_tag."', align = '".$align."' where post_id = $id";
				$db->query($qr);

				header('Location: post_detail.php?pg='.$pg.'&post_id='.$id.$search_get);
			}
		}
		elseif($request['type'] == 5) // 댓글 지우기
		{
			$co_id = intval($request['co_id']);
			$post_id = intval($request['post_id']);
			$pg = $request['pg'];

			$db = db_connect();
			if(isset($request['pwd']))
			{
				$pwd = $request['pwd'];
				$qr = "select count(*) from ".$post_comment." where comment_id = $co_id and comment_password = '".sha1($pwd)."'";
				$msg = '비밀번호가 틀렸습니다.';
			}
			else
			{
				if(isset($session['user']))
				{
					$qr = "select count(*) from ".$post_comment." where comment_id = $co_id and user_id = '".$session['user']['id']."'";
					$msg = '잘못된 접근입니다.';
				}
				else
				{
					display_alert_back('잘못된 접근입니다.', '에러 페이지');
					exit;
				}
			}
			if(!$result = $db-> query($qr))
			{
				display_alert_back('댓글 지우기 실패', '에러 페이지');
				exit;
			}
			else
			{
				$row = $result->fetch_row();
				if($row[0] != 1)
				{
					display_alert_back($msg, '에러 페이지');
					exit;
				}
				else
				{
					$qr = "delete from ".$post_comment." where comment_id = $co_id";
					$db-> query($qr);
					header('Location: post_detail.php?pg='.$pg.'&post_id='.$post_id.$search_get);
				}
			}
		}
		elseif($request['type'] == 6) // 댓글 수정하기
		{
			$pg = $request['pg'];
			$content = addslashes($request['content']);
			$co_id = intval($request['co_id']);
			$id = intval($request['post_id']);

			if(isset($request['pwd']))
			{
				$pwd = $request['pwd'];
				$qr = "update ".$post_comment." set 
				comment_content = '$content', comment_date = now() where comment_id = $co_id and comment_password = '".sha1($pwd)."'";
				$msg = '비밀번호가 틀렸습니다.';
			}
			else
			{
				if(isset($session['user']))
				{
					$qr = "update ".$post_comment." set 
					comment_content = '$content', comment_date = now() where comment_id = $co_id and user_id = '".$session['user']['id']."'";
					$msg = '잘못된 접근입니다.';
				}
				else
				{
					display_alert_back('잘못된 접근입니다.', '에러 페이지');
					exit;
				}
			}
			$db = db_connect();
			$db->query($qr);
			if($db->affected_rows != 1)
			{
				display_alert_back('비밀번호가 틀렸습니다.', '에러 페이지');
				exit;
			}
			else
			{
				header('Location: post_detail.php?pg='.$pg.'&post_id='.$id.'#co_li_'.$co_id.$search_get);
			}
		}
		else
		{
			header('Location: post_list.php');
		}
	}
}

?>