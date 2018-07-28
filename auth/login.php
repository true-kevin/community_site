<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/share_output_fnc.php');

if(isset($_SESSION['user']))
{
	header('Location: /');
	exit;
}


/*
function generate_state() {
    $mt = microtime();
    $rand = mt_rand();
    return md5($mt . $rand);
}

// 상태 토큰으로 사용할 랜덤 문자열을 생성
$state = generate_state();
// 세션 또는 별도의 저장 공간에 상태 토큰을 저장
$session->set_state($state);
return $state;

https://nid.naver.com/oauth2.0/authorize?client_id={클라이언트 아이디}&response_type=code&redirect_uri={개발자 센터에 등록한 콜백 URL(URL 인코딩)}&state={상태 토큰}
*/











display_header('로그인', 5);
?>


<div class="container page_container" style="max-width:500px;">
  <h1 style="text-align:center"><span style="color:white;background:#337ab7;padding:5px;border-radius:5px;">로그인</span></h1>
  <form action="auth_process.php" method="post" accept-charset="utf-8">
    <input type="hidden" name="login_referer" value="<?echo $_SERVER['HTTP_REFERER'];?>">
    <input type="hidden" name="type" value="8">
	<div class="form-group">
      <label style="color:#337ab7">ID:</label>
      <input type="text" class="form-control" name="user_id" maxlength="20" placeholder="ID 입력">
    </div>
    <div class="form-group">
      <label style="color:#337ab7">비밀번호:</label>
      <input type="password" class="form-control" name="user_pwd" maxlength="16" placeholder="비밀번호 입력">
    </div>
    <div class="form-group" style="text-align:right;">
		<button type="submit" class="btn btn-primary">로그인</button>
	</div>
  </form>
  <form action="auth_process.php" method="post" accept-charset="utf-8">
    <input type="hidden" name="type" value="12">
    <div class="form-group" style="text-align:right;">
    <input type="hidden" name="login_referer" value="<?echo $_SERVER['HTTP_REFERER'];?>">
		<input type="image" src="/img/naver_login.PNG" alt="네이버 아이디로 로그인" style="width:170px;">
	</div>
  </form>
</div>



<?
display_footer()
?>