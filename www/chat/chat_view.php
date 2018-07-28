<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/share_output_fnc.php');


display_header('익명 채팅', 6);
?>
<style>
#chat_con {
border:1px solid #337ab7; border-radius:5px; max-width:1000px; height:400px;
overflow-y:auto;
word-break: break-all;

}
</style>

<div id="chat_con" class="container"></div>
<div class="container" style="max-width:1000px;height:80px;padding:0px;">
	<?if(isset($_SESSION['user']))
	{
		$chat_user = $_SESSION['user']['nickname'];
	}
	else
	{
		$chat_user = '유저'.time();
	}
	?>
	<input value="<?echo $chat_user;?>" id="chat_user" maxlength="12" type="text" placeholder="닉네임 입력" class="form-control" style="display:block;width:200px;height:40px;">
	<input id="chat_txt"type="text" placeholder="내용 입력" class="form-control" style="display:block;height:40px;width:100%">
</div>
<div class="container" style="max-width:1000px;height:80px;padding:0px;text-align:right">
<input id="chat_btn" type="button" class="btn btn-primary" value="보내기">
</div>


<script>
var chat_con = document.getElementById('chat_con');
var chat_user = document.getElementById('chat_user');
var chat_txt = document.getElementById('chat_txt');
var chat_btn = document.getElementById('chat_btn');

chat_con.style.height = window.innerHeight -382 +'px';
chat_con.scrollTop = chat_con.scrollHeight;

setTimeout(function()
{
	chat_con.style.height = window.innerHeight -382 +'px';
	chat_con.scrollTop = chat_con.scrollHeight;
}, 1000);

window.onresize = function()
{
	chat_con.style.height = window.innerHeight -382 +'px';
	chat_con.scrollTop = chat_con.scrollHeight;
};


chat_txt.onkeydown = function(event)
{
	var kc = event.which || event.keyCode;
	if(kc == 13)
	{
		write_txt();
	}
};

chat_btn.onclick = function(){write_txt();};


function write_txt()
{
	var user = encodeURIComponent(chat_user.value);
	var txt = encodeURIComponent(chat_txt.value);
	if(txt != '')
	{
		var xhttp = new XMLHttpRequest();
		xhttp.open("GET", "chat_back.php?user="+user+"&txt="+txt, true);
		xhttp.send();
		xhttp.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				var result_obj = JSON.parse(this.responseText);
				chat_con.innerHTML += result_obj[0];
				chat_con.scrollTop = chat_con.scrollHeight;
				chat_txt.value = '';
			}
		};
	}
}
function auto_get()
{
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "chat_back.php?", true);
	xhttp.send();
	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			var result_obj = JSON.parse(this.responseText);
			chat_con.innerHTML += result_obj[0];
			chat_con.scrollTop = chat_con.scrollHeight;
		}
	};
}
setInterval(auto_get, 3000);

</script>


<?
display_footer();
?>