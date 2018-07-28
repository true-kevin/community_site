<?
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/include/post_process_fnc.php');

post_procedure($_REQUEST, $_SESSION, 'vdo_post_header', 'vdo_post_body', 'vdo_post_comment');

?>