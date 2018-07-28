<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/share_output_fnc.php');

if(isset($_SESSION['user']))
{
	header('Location: /');
	exit;
}



display_header('회원 가입', 5);
?>

<div class="container page_container" style="max-width:500px;">
  <h1 style="text-align:center"><span style="color:white;background:#337ab7;padding:5px;border-radius:5px;">회원 가입</span></h1>
  <form action="auth_process.php" method="post" accept-charset="utf-8">
    <input type="hidden" name="type" value="7">
	<div class="form-group">
      <label style="color:#337ab7">ID:</label>
      <input type="text" class="form-control" name="user_id" maxlength="20" placeholder="영문 또는 숫자 5~20자로 입력">
    </div>
    <div class="form-group">
      <label style="color:#337ab7">닉네임:</label>
      <input type="text" class="form-control" name="user_nick" maxlength="20" placeholder="한글 10자, 영문 또는 숫자 20자 이내로 입력">
    </div>
    <div class="form-group">
      <label style="color:#337ab7">Email:</label>
      <input type="email" class="form-control" name="user_email" maxlength="40" placeholder="Email 입력">
    </div>
    <div class="form-group">
      <label style="color:#337ab7">비밀번호:</label>
      <input type="password" class="form-control" name="user_pwd1" maxlength="16" placeholder="비밀번호 입력">
    </div>
    <div class="form-group">
      <label style="color:#337ab7">비밀번호 확인:</label>
      <input type="password" class="form-control" name="user_pwd2" maxlength="16" placeholder="비밀번호 확인">
    </div>
    <div class="form-group" style="text-align:right;">
		<button type="submit" class="btn btn-primary">가입하기</button>
	</div>
  </form>
</div>

<?
display_footer()
?>