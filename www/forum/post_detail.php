<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_detail_page_fnc.php');

display_post_detail($_REQUEST, $_SESSION, 'forum_post_header', 'forum_post_body', 'forum_post_comment', 1, 'Forum');
?>