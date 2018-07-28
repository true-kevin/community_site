<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_list_page_fnc.php');

display_post_detail($_REQUEST, 'vdo_post_header', 'vdo_post_body', '동영상 게시판', 4, 'video');
?>