<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/share_output_fnc.php');

if(!isset($_SESSION['user']) || isset($_SESSION['user']['oauth'])) //oauth로 로그인한 멤버는 접근 불가
{
	header('Location: /');
	exit;
}

display_header('회원 탈퇴', 5);
?>
<script>

// 회원 탈퇴 확인을 위한 컨펌 버튼
function delete_account(idname) 
{
	var r = confirm('정말 탈퇴하시겠습니까?');
	
	if (r == true)
	{
		document.getElementById(idname).submit();
	}
}
</script>

<div class="container page_container" style="max-width:500px;">
  <h1 style="text-align:center"><span style="color:white;background:#337ab7;padding:5px;border-radius:5px;">회원 탈퇴</span></h1>
  <h2 class="text-danger" style="font-size:20px;">한번 탈퇴하면 계정을 다시 복구할 수 없습니다.</h2>
  <form id="delete_account" action="auth_process.php" method="post" accept-charset="utf-8">
    <input type="hidden" name="type" value="11">
	<div class="form-group">
      <label style="color:#337ab7">ID:</label>
      <input type="text" class="form-control" name="user_id" maxlength="20" placeholder="ID 입력">
    </div>
    <div class="form-group">
      <label style="color:#337ab7">비밀번호:</label>
      <input type="password" class="form-control" name="user_pwd" maxlength="16" placeholder="비밀번호 입력">
    </div>
    <div class="form-group" style="text-align:right;">
		<div class="btn-group">
			<a href="/" class="btn btn-primary">취소</a>
			<button type="button" onclick="delete_account('delete_account')" class="btn btn-primary">탈퇴하기</button>
		</div>
	</div>
  </form>
</div>

 
<?
display_footer()
?>