<?php
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/share_output_fnc.php');
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_output_fnc.php');

display_header('Home', 5);
?>


	<h1 class="text-center" style="margin-bottom:40px;margin-top:60px;"><a href="/" style="text-decoration:none;color:white;background:#337ab7;padding:5px;border-radius:5px;">트루 케빈<span class="glyphicon glyphicon-apple"></a></h1>

<div class="container-fluid page_container" style="max-width:1000px;">
	<div class="row">
		<div class="col-sm-5">
			<h2 style="text-align:center"><a href="/forum" style="text-decoration:none;font-size:20px;color:white;background:#337ab7;padding:5px;border-radius:5px;">자유 게시판</a></h2>
			<?display_post_list(1, 5, 'forum_post_header', 'forum_post_body', null, null, '/forum/'); //리스트 출력?>
		</div>
		<div class="col-sm-2">
		</div>
		<div class="col-sm-5">
			<h2 style="text-align:center"><a href="/fun" style="text-decoration:none;font-size:20px;color:white;background:#337ab7;padding:5px;border-radius:5px;">유머 엽기 게시판</a></h2>
			<?display_post_list(1, 5, 'fun_post_header', 'fun_post_body', null, null, '/fun/'); //리스트 출력?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-5">
			<h2 style="text-align:center"><a href="/ent" style="text-decoration:none;font-size:20px;color:white;background:#337ab7;padding:5px;border-radius:5px;">연예 게시판</a></h2>
			<?display_post_list(1, 5, 'ent_post_header', 'ent_post_body', null, null, '/ent/'); //리스트 출력?>
		</div>
		<div class="col-sm-2">
		</div>
		<div class="col-sm-5">
			<h2 style="text-align:center"><a href="/vdo" style="text-decoration:none;font-size:20px;color:white;background:#337ab7;padding:5px;border-radius:5px;">동영상 게시판</a></h2>
			<?display_post_list(1, 5, 'vdo_post_header', 'vdo_post_body', null, null, '/vdo/'); //리스트 출력?>
		</div>
	</div>
</div>

<?
display_footer();
?>