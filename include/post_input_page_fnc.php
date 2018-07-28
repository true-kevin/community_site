<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/share_output_fnc.php');

function display_post_detail($request, $session, $current_tab, $page_title)
{

	if(!empty($request['pg']))
	{
		$pg = $request['pg'];
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

	display_header($page_title, $current_tab);
	?>
	<script type="text/javascript" src="/se2/js/HuskyEZCreator.js" charset="utf-8"></script>
	<div class="container-fluid page_container" style="max-width: 1000px; margin-bottom:20px;">
		<h1 style="text-align:center"><span style="color:white;background:#337ab7;padding:5px;border-radius:5px;">새글 작성</span></h1>
		<form action="post_process.php?pg=<?echo $pg.$search_get;?>" method="post" accept-charset="utf-8">
			<?if(!isset($session['user']))
			{
			?>
			<div class="form-group">
				<label style="color:#337ab7">글쓴이:</label>
				<input type="text" class="form-control" name="user" maxlength="10" placeholder="10자 이내로 입력하세요.">
			</div>
			<div class="form-group">
				<label style="color:#337ab7">비밀번호:</label>
				<input type="password" class="form-control" name="pwd"  maxlength="10" placeholder="10자 이내로 입력하세요.">
			</div>
			<?
			}
			?>
			<?if(isset($session['user']))
			{
			?>
			<div class="form-group">
				<label style="color:#337ab7">글쓴이:</label>
				<input style="color:#337ab7;" type="text" class="form-control" value="<?echo $session['user']['nickname'];?>" readonly>
			</div>
			<?
			}
			?>
			<div class="form-group">
				<label style="color:#337ab7">제목:</label>
				<input type="text" class="form-control" name="title">
			</div>
			<div class="form-group" style="position:relative;">
				<label style="color:#337ab7">내용:</label>
				<div style="text-align:right; font-size:17px; padding-right:5px;">
					<span onclick="add_pic()" style="cursor:pointer" class="glyphicon glyphicon-camera" title="이미지 URL 첨부"></span>
				</div>
				<textarea id="content" name="content" rows="10" cols="100" style="width:100%; min-width:260px; height:412px; display:none;"></textarea>
			</div>
			<input type="hidden" name="type" value="1">
			<input type="hidden" name="rand" value="<?echo mt_rand().'1'; //인서트할 땐 랜덤값 + type값을 보내준다.?>"> 
			<div class="row text-right">
				<div class="btn-group" style="margin-right:20px;">
					<input type="button" class="btn btn-primary" onclick="submitContents(this);" value="글쓰기" />
					<a href="post_list.php?pg=<?echo $pg.$search_get;?>" class="btn btn-primary">목록으로</a>
				</div>
			</div>
		</form>

	</div>

<script>
var oEditors = [];

// 추가 글꼴 목록
//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "content",
	sSkinURI: "/se2/SmartEditor2Skin.html",	
	htParams : {
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : false,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		//bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
		fOnBeforeUnload : function(){
			//alert("완료!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//oEditors.getById["content"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
	},
	fCreator: "createSEditor2"
});
	
function submitContents(elClickedObj) {
	oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
	
	// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("content").value를 이용해서 처리하면 됩니다.
	
	try {
		elClickedObj.form.submit();
	} catch(e) {}
}

function add_pic()
{
	var pr = prompt("이지미 URL을 입력해주세요.", "http://");
	if(pr != null)
	{
		var sHTML = '<img style="max-width:100%;" src="'+pr+'">';
		oEditors.getById["content"].exec("PASTE_HTML", [sHTML]);
	}
}



</script>

	<?
	display_footer();

}
?>