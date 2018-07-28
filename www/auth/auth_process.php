<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/db_fnc.php');
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/alert_fnc.php');
session_start();

if(!isset($_REQUEST['type']))
{
	header('Location: /');
}
else
{
	if($_POST['type'] != 10) // 회원정보 수정 때만 통과함
	{
		foreach($_POST as $v)
		{
			if(empty($v) || trim($v) == '')
			{
				display_alert_back('모든 내용을 입력하세요.', '에러 페이지');
				exit;
			}
		}
	}
	if($_POST['type'] == 7) // 회원 가입
	{
		$user_id = $_POST['user_id']; // id는 소문자로만 받는다.
		$user_nick = $_POST['user_nick']; // 닉네임은 대, 소문자 다 받지만 중복은 안된다. 예) Abcdd == abCdD 두개 같은 걸로 간주
		$user_email = $_POST['user_email']; // email은 소문자로 받는다.
		$user_pwd1 = $_POST['user_pwd1'];
		$user_pwd2 = $_POST['user_pwd2'];
		$db = db_connect();

		// id 유효성 검사
		if(!preg_match("/^[a-zA-Z0-9\-\_]{5,20}$/", $user_id))
		{
			display_alert_back('ID 형식이 맞지 않습니다.', '에러 페이지');
			exit;
		}
		else
		{
			$qr = "select * from pro_user where id = '".strtolower($user_id)."'";
			$result = $db->query($qr);
			if($result->num_rows != 0)
			{
				display_alert_back($user_id.'은(는) 이미 사용중인 ID입니다.', '에러 페이지');
				exit;
			}
		}

		// 닉네임 유효성 검사 시작
		// '한글, 영문, 숫자, _, -'로만 되어 있는지 확인
		if(!preg_match("/^[ㄱ-ㅎ가-힣ㅏ-ㅣa-zA-Z0-9\-\_]+$/", $user_nick))
		{
			display_alert_back('닉네임 형식이 맞지 않습니다.', '에러 페이지');
			exit;
		}
		// 한글 문자열 세기, 한글은 한 글자당 길이가 3이다.
		preg_match_all("/[ㄱ-ㅎ가-힣ㅏ-ㅣ]{3,3}/", $user_nick, $arr);
		$han_len = sizeof($arr[0])*2; // 2를 곱해준다. 한글은 10자까지고 영문은 20자까지기 때문에 계산 해준 것임
		// 영문 문자열 세기
		preg_match_all("/[a-zA-Z0-9\-\_]{1,1}/", $user_nick, $arr);
		$eng_len = sizeof($arr[0]);
		if(($han_len+$eng_len) > 20 || ($han_len+$eng_len) < 4)
		{
			display_alert_back('닉네임은 한글 2자, 영문 또는 숫자 4자 이상 입력하세요.', '에러 페이지');
			exit;
		}
		else
		{
			// 비교할 땐 둘다 소문자로 하고 삽입할 땐 그대로 넣음
			$qr = "select * from pro_user where LOWER(nickname) = '".strtolower($user_nick)."'"; 
			$result = $db->query($qr);
			if($result->num_rows != 0)
			{
				display_alert_back($user_nick.'은(는) 이미 사용중인 닉네임입니다.', '에러 페이지');
				exit;
			}
		}
		
		// email 유효성 검사
		if(!preg_match("/^[a-zA-Z0-9\-\_]+@[a-zA-Z0-9\-\_]+\.[a-zA-Z]+$/", $user_email))
		{
			display_alert_back('이메일 형식이 맞지 않습니다.', '에러 페이지');
			exit;
		}
		else
		{
			// email은 소문자로 저장하기 때문에 소문자로 비교해준다.
			$qr = "select * from pro_user where email = '".strtolower($user_email)."'"; 
			$result = $db->query($qr);
			if($result->num_rows != 0)
			{
				display_alert_back($user_email.'은(는) 이미 가입된 email주소입니다.', '에러 페이지');
				exit;
			}
		}
		// 비밀번호 유효성 검사
		if(!preg_match("/^[^\s]{5,16}$/", $user_pwd1))
		{
			display_alert_back('비밀번호는 5~16자로 공백이 포함되면 안됩니다.', '에러 페이지');
			exit;
		}
		if($user_pwd1 != $user_pwd2)
		{
			display_alert_back('비밀번호가 일치하지 않습니다.', '에러 페이지');
			exit;
		}

		$user_pwd1 = sha1($user_pwd1);
		$user_id = strtolower($user_id); // id를 소문자로 바꿔서 넣어준다.(닉네임은 그대로)
		$user_email = strtolower($user_email); // email도 소문자로 바꿔서 넣어준다.

		$qr = "insert into pro_user (id, nickname, email, password, sign_up_date) values
		(
			'$user_id', '$user_nick', '$user_email', '$user_pwd1', now()
		)";
		if(!$db->query($qr))
		{
			display_alert_back('회원 가입에 실패했습니다.', '에러 페이지');
			exit;
		}
		else
		{
			$qr = "select * from pro_user where id = '$user_id'";
			$result = $db->query($qr);
			$row = $result->fetch_assoc();
			// 회원 가입이 끝나면 로그인된 상태로 홈으로 보낸다.
			foreach($row as $k=> $v)
			{
				$_SESSION['user'][$k] = $v; // 회원의 모든 필드 세션 변수에 저장
			}
			display_alert_location("'".$_SESSION['user']['nickname']."'님 환영합니다.\\n\\n성공적으로 가입되셨습니다!", '회원가입 성공', '/');
			exit;
		}
	}
	elseif($_POST['type'] == 8) // 로그인
	{
		$user_id = addslashes($_POST['user_id']);
		$user_pwd = sha1($_POST['user_pwd']);
		
		$db = db_connect();
		// 로그인 조건에 not_member is null 을 추가했다. 이미 탈퇴한 유저는 로그인 할 수 없다.
		$qr = "select * from pro_user where id = '$user_id' and password = '$user_pwd' and not_member is null";
		$result = $db->query($qr);
		if($result-> num_rows != 1)
		{
			echo $qr;
			display_alert_back('ID와 비밀번호를 알맞게 입력하세요.', '에러 페이지');
			exit;
		}
		else
		{
			$row = $result->fetch_assoc();
			// 로그인된 상태로 로그인 페이지로 오긴 직전 페이지로 보낸다.
			foreach($row as $k=> $v)
			{
				$_SESSION['user'][$k] = $v; // 회원의 모든 필드 세션 변수에 저장
			}
			header('Location:'.$_POST['login_referer']);
		}
	}
	elseif($_REQUEST['type'] == 9) // 로그아웃
	{
		unset($_SESSION['user']);
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
	elseif($_POST['type'] == 10) // 회원정보 수정
	{
		$user_nick = $_POST['user_nick']; // 닉네임은 대, 소문자 다 받지만 중복은 안된다. 예) Abcdd == abCdD 두개 같은 걸로 간주
		$user_email = $_POST['user_email']; // email은 소문자로 받는다.
		$user_pwd1 = $_POST['user_pwd1'];
		$user_pwd2 = $_POST['user_pwd2'];
		$db = db_connect();
		
		// 닉네임이 바뀌었을 때만 유효성 검사를 한다.
		if(strtolower($_SESSION['user']['nickname']) != strtolower($user_nick))
		{
			// 닉네임 유효성 검사 시작
			// '한글, 영문, 숫자, _, -'로만 되어 있는지 확인
			if(!preg_match("/^[ㄱ-ㅎ가-힣ㅏ-ㅣa-zA-Z0-9\-\_]+$/", $user_nick))
			{
				display_alert_back('닉네임 형식이 맞지 않습니다.', '에러 페이지');
				exit;
			}
			// 한글 문자열 세기, 한글은 한 글자당 길이가 3이다.
			preg_match_all("/[ㄱ-ㅎ가-힣ㅏ-ㅣ]{3,3}/", $user_nick, $arr);
			$han_len = sizeof($arr[0])*2; // 2를 곱해준다. 한글은 10자까지고 영문은 20자까지기 때문에 계산 해준 것임
			// 영문 문자열 세기
			preg_match_all("/[a-zA-Z0-9\-\_]{1,1}/", $user_nick, $arr);
			$eng_len = sizeof($arr[0]);
			if(($han_len+$eng_len) > 20 || ($han_len+$eng_len) < 4)
			{
				display_alert_back('닉네임은 한글 2자, 영문 또는 숫자 4자 이상 입력하세요.', '에러 페이지');
				exit;
			}
			else
			{
				// 비교할 땐 둘다 소문자로 하고 삽입할 땐 그대로 넣음
				$qr = "select * from pro_user where LOWER(nickname) = '".strtolower($user_nick)."'"; 
				$result = $db->query($qr);
				if($result->num_rows != 0)
				{
					display_alert_back($user_nick.'은(는) 이미 사용중인 닉네임입니다.', '에러 페이지');
					exit;
				}
			}
		}
		
		// 이메일이 바뀌었을 때만 유횽성 검사
		if($_SESSION['user']['email'] != $user_email)
		{
			// email 유효성 검사
			if(!preg_match("/^[a-zA-Z0-9\-\_]+@[a-zA-Z0-9\-\_]+\.[a-zA-Z]+$/", $user_email))
			{
				display_alert_back('이메일 형식이 맞지 않습니다.', '에러 페이지');
				exit;
			}
			else
			{
				// email은 소문자로 저장하기 때문에 소문자로 비교해준다.
				$qr = "select * from pro_user where email = '".strtolower($user_email)."'"; 
				$result = $db->query($qr);
				if($result->num_rows != 0)
				{
					display_alert_back($user_email.'은(는) 이미 가입된 email주소입니다.', '에러 페이지');
					exit;
				}
				
				$user_email = strtolower($user_email); // email을 소문자로 바꿔 넣어준다.
			}
		}
		
		// 두개의 비밀번호 변경란 중 하나라도 입력 되어 있을 때만 유효성 검사를 한다.
		if(!empty($user_pwd1) || !empty($user_pwd1))
		{
			// 비밀번호 유효성 검사
			if(!preg_match("/^[^\s]{5,16}$/", $user_pwd1))
			{
				display_alert_back('비밀번호는 5~16자로 공백이 포함되면 안됩니다.', '에러 페이지');
				exit;
			}
			if($user_pwd1 != $user_pwd2)
			{
				display_alert_back('비밀번호가 일치하지 않습니다.', '에러 페이지');
				exit;
			}
			// 변경된 비밀번호를 암호화 하여 넣어준다.
			$modi_pwd = sha1($user_pwd1);
		}
		else
		{
			// 비밀번호 변경이 없을 땐 세션에 저장된 비밀번호를 그대로 넣어준다.
			$modi_pwd = $_SESSION['user']['password'];
		}


		$qr = "update pro_user set
		nickname = '".$user_nick."', email = '".$user_email."', password = '".$modi_pwd."' where id = '".$_SESSION['user']['id']."'";

		if(!$db->query($qr))
		{
			display_alert_back('회원정보 수정에 실패했습니다.', '에러 페이지');
			exit;
		}
		else
		{
			$qr = "select * from pro_user where id = '".$_SESSION['user']['id']."'";
			$result = $db->query($qr);
			$row = $result->fetch_assoc();
			// 회원 정보 수정이 끝나면 세션 값을 변경해 레퍼러 페이지로 보낸다.
			foreach($row as $k=> $v)
			{
				$_SESSION['user'][$k] = $v; // 회원의 모든 필드 세션 변수에 저장
			}
			display_alert_location('회원정보가 수정되었습니다.', '회원정보 수정 성공', '/auth/user_info.php');
			exit;
		}
	}
	elseif($_POST['type'] == 11) //회원 탈퇴
	{
		// 로그인 여부 다시 한번 확인
		if(!isset($_SESSION['user']))
		{
			display_alert_back('잘못된 접근입니다.', '에러 페이지');
			exit;
		}
		// 세션을 통해서 현재 유저의 id, 비밀번호와 입력한 것들이 일치하는지 확인한다.
		if(($_SESSION['user']['id'] != $_POST['user_id'])  || ($_SESSION['user']['password'] != sha1($_POST['user_pwd'])))
		{
			display_alert_back('ID와 비밀번호를 알맞게 입력하세요.', '에러 페이지');
			exit;
		}
		$db = db_connect();
		$qr = "update pro_user set not_member = 1, not_member_date = now() where id = '".$_SESSION['user']['id']."' and password = '".$_SESSION['user']['password']."'";
		$db->query($qr);
		if($db->affected_rows != 1)
		{
			echo $qr;
			display_alert_back('회원 탈퇴에 실패하였습니다.', '에러 페이지');
			exit;
		}
		else
		{
			// 탈퇴 완료 후 회원 정보를 세션에서 지워 준다.(로그인 해제)
			$by_nick = $_SESSION['user']['nickname'];
			unset($_SESSION['user']);
			display_alert_location("'".$by_nick."'님의 회원 탈퇴가 완료되었습니다..", '회원 탈퇴 성공', '/');
			exit;
		}
	}
	elseif($_POST['type'] == 12) //네이버 id로 로그인
	{
		$mt = microtime();
		$rand = mt_rand();
		$_SESSION['naver_state_token'] = md5($mt . $rand); // 상태 토큰 생성
		header('Location: https://nid.naver.com/oauth2.0/authorize?client_id=_jv3EMRjoT4XZFTn9Qvg&response_type=code&redirect_uri='.urlencode ('http://truekevin.cafe24.com').'&state='.$_SESSION['naver_state_token']);
	}
	else
	{
		header('Location: /');
	}
}
?>