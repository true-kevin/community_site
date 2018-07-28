<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_list_page_fnc.php');

display_post_detail($_REQUEST, 'forum_post_header', 'forum_post_body', '자유 게시판', 1, 'Forum');
?>