// 포스트 수정, 삭제, 댓글 폼 토글
function show_form(idname)
{
	dis = document.getElementById(idname).style.display;
	if(dis == 'none' || dis == '')
	{
		document.getElementById('comment_form').style.display='none';
		document.getElementById('post_delete').style.display='none';
		document.getElementById('post_modify').style.display='none';

		dis = 'block';
	}
	else
	{
		dis = 'none';
	}
	document.getElementById(idname).style.display = dis;
	document.getElementById('comment_text').focus();
}

// 댓글 삭제 버튼 토글
var save_id = '';
function show_form2(idname)
{
	dis = document.getElementById('co_del_form_'+idname).style.display;
	col = document.getElementById('co_li_'+idname).style.backgroundColor;
	if(dis == 'none' || dis == '')
	{
		if(save_id != '')
		{
			document.getElementById('co_del_form_'+save_id).style.display='none';
			document.getElementById('co_li_'+save_id).style.backgroundColor='';
			document.getElementById('co_modi_'+save_id).style.display='none';
		}
		dis = 'block';
		document.getElementById('co_li_'+idname).style.backgroundColor='#F0F8FF';

		save_id = idname;
	}
	else
	{
		dis = 'none';
		document.getElementById('co_li_'+idname).style.backgroundColor='';
		save_id = '';
	}
	document.getElementById('co_del_form_'+idname).style.display = dis;
	document.getElementById('co_del_input_'+idname).focus();
}

// 댓글 수정 버튼
function show_form3(idname)
{
	dis = document.getElementById('co_modi_'+idname).style.display;
	if(dis == 'none' || dis == '')
	{
		if(save_id != '')
		{
			document.getElementById('co_del_form_'+save_id).style.display='none';
			document.getElementById('co_li_'+save_id).style.backgroundColor='';
			document.getElementById('co_modi_'+save_id).style.display='none';
		}
		dis = 'block';
		save_id = idname;
	}
	else
	{
		dis = 'none';
		save_id = '';
	}
	document.getElementById('co_modi_'+idname).style.display = dis;
	document.getElementById('co_text_'+idname).focus();
}

// 회원용 포스트 삭제 확인을 위한 컨펌 버튼
function delete_confirm(idname) 
{
	var r = confirm('게시글을 정말 삭제하시겠습니까?');
	
	if (r == true)
	{
		document.getElementById(idname).submit();
	}
}

// 회원용 댓글 삭제 확인을 위한 컨펌 버튼
function delete_confirm2(idname) 
{
	var r = confirm('게시글을 정말 삭제하시겠습니까?');
	
	if (r == true)
	{
		document.getElementById('co_del_form_'+idname).submit();
	}
}

