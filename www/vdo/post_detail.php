<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_detail_page_fnc.php');

display_post_detail($_REQUEST, $_SESSION, 'vdo_post_header', 'vdo_post_body', 'vdo_post_comment', 4, 'video');
?>