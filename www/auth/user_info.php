<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/share_output_fnc.php');

if(!isset($_SESSION['user']) || isset($_SESSION['user']['oauth'])) //oauth로 로그인한 멤버는 접근 불가
{
	header('Location: /');
	exit;
}

display_header('개인정보 수정', 5);
?>

<div class="container page_container" style="max-width:500px;">
  <h1 style="text-align:center"><span style="color:white;background:#337ab7;padding:5px;border-radius:5px;">개인정보 수정</span></h1>
  <form action="auth_process.php" method="post" accept-charset="utf-8">
    <input type="hidden" name="type" value="10">
	<div class="form-group">
      <label style="color:#337ab7">ID:</label>
      <input type="text" class="form-control" value="<?echo $_SESSION['user']['id'];?>" readonly>
    </div>
    <div class="form-group">
      <label style="color:#337ab7">닉네임:</label>
      <input type="text" class="form-control" value="<?echo $_SESSION['user']['nickname'];?>" name="user_nick" maxlength="20" placeholder="한글 10자, 영문 또는 숫자 20자 이내로 입력">
    </div>
    <div class="form-group">
      <label style="color:#337ab7">Email:</label>
      <input type="email" class="form-control" value="<?echo $_SESSION['user']['email'];?>" name="user_email" maxlength="40" placeholder="Email 입력">
    </div>
    <div class="form-group">
      <label style="color:#337ab7">비밀번호 변경:</label>
      <input type="password" class="form-control" name="user_pwd1" maxlength="16" placeholder="비밀번호 입력">
    </div>
    <div class="form-group">
      <label style="color:#337ab7">비밀번호 변경 확인:</label>
      <input type="password" class="form-control" name="user_pwd2" maxlength="16" placeholder="비밀번호 확인">
    </div>
    <div class="form-group" style="text-align:right;position:relative">
		<a href="/auth/delete_account.php" style="position:absolute;left:0px;top:2px;" class="btn btn-default btn-sm">회원 탈퇴</a>
		<div class="btn-group">
			<a href="/" class="btn btn-primary">취소</a>
			<button type="submit" class="btn btn-primary">수정하기</button>
		</div>
	</div>
  </form>
</div>


 
<?
display_footer()
?>