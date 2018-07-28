<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_detail_page_fnc.php');

display_post_detail($_REQUEST, $_SESSION, 'fun_post_header', 'fun_post_body', 'fun_post_comment', 2, 'Fun');
?>