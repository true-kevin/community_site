<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/db_fnc.php');

session_start(); // 모든 페이지에서 세션을 쓸 수 있도록 하자. 일단 이 파일을 인클루드하는 모든 페이지는 세션을 쓸 수 있다.
//echo '<xmp>';
//print_r($_SESSION);
//echo '</xmp>';



if(!empty($_GET['code']) && !empty($_GET['state']) && !empty($_SESSION['naver_state_token'])) // 네이버 콜백 토큰 확인
{

	if($_SESSION['naver_state_token'] != $_GET['state'])
	{
		echo '<script>alert("로그인에 실패하였습니다")<script>';
	}
	else //정상적인 콜백 토큰 확인
	{
		$curl_session = curl_init ();
		curl_setopt ($curl_session, CURLOPT_URL, 'https://nid.naver.com/oauth2.0/token?client_id=_jv3EMRjoT4XZFTn9Qvg&client_secret=y5RsaeGucP&grant_type=authorization_code&state='.$_GET['state'].'&code='.$_GET['code']);
		curl_setopt ($curl_session, CURLOPT_RETURNTRANSFER, 1);
		$access_json = curl_exec ($curl_session);
		curl_close($curl_session);
		$access_obj = json_decode($access_json); // 유저 정보 접근 토큰을 객체화 한다.

		if(!isset($access_obj->error)) //$access_obj->error 있는 경우는 유저가 취소한 경우다.
		{
			$curl_session = curl_init();
			curl_setopt($curl_session, CURLOPT_URL, 'https://openapi.naver.com/v1/nid/me' );
			curl_setopt($curl_session, CURLOPT_HTTPHEADER, array('Authorization: '. $access_obj->token_type.' '.$access_obj->access_token));
			curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, 1 );
			$user_info = curl_exec($curl_session);
			curl_close($curl_session);
			$user_info_obj = json_decode($user_info); // 유저 정보를 객체화 한다.

			foreach($user_info_obj->response as $k=> $v)
			{
				$_SESSION['user'][$k] = $v;
				// 로그인을 위해 세션 변수 user를 만든다. 다행히도 내가 만든 테이블 컬럼이름과 같다.(id, nickname, email 등) 따라서 그냥 넣어줘도 된다.
			}
			$_SESSION['user']['id'] = $_SESSION['user']['id'].'/naver'; //기존 멤버와의 id충돌을 막기 위해 /naver를 붙인다.
			$_SESSION['user']['nickname'] = $_SESSION['user']['nickname'].'(N)'; //기존 멤버와의 id충돌을 막기 위해 /naver를 붙인다.
			$_SESSION['user']['oauth'] = true; //편한 구분을 위해 oauth변수를 만들어 준다.
		}
	}
	unset($_SESSION['naver_state_token']); // 실패든 성공이든 상태 토큰을 무조건 지운다.
}



//phpinfo();
//print_r($_SESSION);

// 로그 확인 쿼리
$db = db_connect();
$db->query("insert into log values ('".$_SERVER['REMOTE_ADDR']."', now())");

function display_header($title, $nav_activ=0)
{
	$li1 = $li2 = $li3 = $li4 = $li5 ='';
	if($nav_activ !== 0)
	{
		switch($nav_activ)
		{
			case 1:
				$li1 = 'class="active"';
				break;
			case 2:
				$li2 = 'class="active"';
				break;
			case 3:
				$li3 = 'class="active"';
				break;
			case 4:
				$li4 = 'class="active"';
				break;
			case 5:
				$li5 = 'style="border:2px solid #337ab7;border-radius:5px;"';
				break;
		}
	}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <title>True Kevin | <?echo $title?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/share.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="/js/share.js"></script>
</head>

<body>

	<nav class="navbar navbar-default">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="/" <?echo $li5?>>True Kevin</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
		  <ul class="nav navbar-nav">
			<li <?echo $li1?>><a href="/forum/post_list.php">자유 게시판</a></li>
			<li <?echo $li2?>><a href="/fun/post_list.php">유머 엽기</a></li>
			<li <?echo $li3?>><a href="/ent/post_list.php">연예</a></li>
			<li <?echo $li4?>><a href="/vdo/post_list.php">동영상</a></li>
			<li <?echo $li6?>><a href="/chat/chat_view.php">채팅방</a></li>
		  </ul>
		  <ul class="nav navbar-nav navbar-right">
		  <?if(!isset($_SESSION['user']))
		  {
		  ?>
			<li><a href="/auth/sign_up.php"><span class="glyphicon glyphicon-hand-right"></span> 회원 가입</a></li>
			<li><a href="/auth/login.php"><span class="glyphicon glyphicon-log-in"></span> 로그인</a></li>
		  <?
		  }
		  ?>
		  <?if(isset($_SESSION['user']))
		  {
		  ?>
			<li><a href="/auth/auth_process.php?type=9"><span class="glyphicon glyphicon-log-out"></span> 로그아웃</a></li>
			<li data-toggle="modal" data-target="#myModal"><a href="#"><span class="glyphicon glyphicon-user"></span> <?echo $_SESSION['user']['nickname']?></a></li>
		  <?
		  }
		  ?>
		  </ul>
		</div>
	  </div>
	</nav>

	<?if(isset($_SESSION['user']))
	{
		if(isset($_SESSION['user']['profile_image'])) // 네이버 로그인시 프로필 사진을 넣어 준다.
		{
			$user_img = '<img src="'.$_SESSION['user']['profile_image'].'" style="display:inline-block;width:100px;">';
		}
		else // 네이버 로그인이 아니면 글리피콘으로 대체한다.
		{
			$user_img = '<span class="glyphicon glyphicon-picture" style="font-size:100px;color:pink;display:inline-block;"></span>';
		}
	?>
	<div class="modal fade" id="myModal" role="dialog" style="margin-top:120px;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<?echo $user_img;?>
					<div style="color:#337ab7;margin-top:4px;"><?echo $_SESSION['user']['nickname']?></div>
					<div style="display:inlin-block;"><?echo $_SESSION['user']['email']?></div>
				</div>
				<div class="modal-body" style="position:relative;">
					<?if(!isset($_SESSION['user']['oauth']))
					{
					?>
					<a href="/auth/user_info.php" style="display:block;position:absolute; left:15px;bottom:20px;color:#2E8B57;text-decoration:none;">개인정보 수정 <span class="glyphicon glyphicon-pencil"></span></a>
					<?	
					}
					?>
					<button style="position:absolute; right:15px;bottom:12px;" type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
				</div>
			</div>
		</div>
	</div>
	<?
	}
	?>
<?
}




function display_footer()
{
?>
	<footer class="bs-docs-footer" style="background:#337ab7;height:100px;margin-top:50px;">
		<div class="container text-center">
			<p style="margin-top:40px; font-size:20px; color:white;">
				Copyright © 2016~ true kevin 
			</p>
		</div>
	</footer>
</body>
</html>
<?	
}



?>