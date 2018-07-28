<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_process_fnc.php');

post_procedure($_REQUEST, $_SESSION, 'fun_post_header', 'fun_post_body', 'fun_post_comment');

?>