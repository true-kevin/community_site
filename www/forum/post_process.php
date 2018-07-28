<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_process_fnc.php');

post_procedure($_REQUEST, $_SESSION, 'forum_post_header', 'forum_post_body', 'forum_post_comment');

?>