<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_process_fnc.php');

post_procedure($_REQUEST, $_SESSION, 'ent_post_header', 'ent_post_body', 'ent_post_comment');

?>