<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_detail_page_fnc.php');

display_post_detail($_REQUEST, $_SESSION, 'ent_post_header', 'ent_post_body', 'ent_post_comment', 3, 'Entertainment');
?>