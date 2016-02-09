<?php
/**
 * @author Paul Bukowski <pbukowski@telaxus.com>
 * @copyright Copyright &copy; 2006, Telaxus LLC
 * @license MIT
 * @version 1.0
 * @package epesi-base
 */
ob_start();
header("Content-type: text/javascript");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // date in the past


if(!isset($_POST['url']) || !isset($_SERVER['HTTP_X_CLIENT_ID']))
	die('alert(\'Invalid request\');');


define('JS_OUTPUT',1);
define('EPESI_PROCESS',1);
require_once('include.php');

if (epesi_requires_update()) {
    die ('window.location = "index.php";');
}
if(!isset($_SESSION['num_of_clients'])) {
	Epesi::alert('Session expired, restarting Epesi');
	Epesi::redirect();
	Epesi::send_output();
	define('SESSION_EXPIRED',1);
	//session_commit();
	//DBSession::destroy(session_id());
} elseif((!isset($_POST['history']) || !is_numeric($_POST['history']) || $_POST['history']>0) && !isset($_SESSION['client']['__history_id__'])) {
	Epesi::alert('Too many Epesi tabs open - session expired, restarting Epesi');
	Epesi::redirect();
	Epesi::send_output();
	define('SESSION_EXPIRED',1);
	//session_commit();
	DBSession::destroy_client(session_id(),CID);
} else {
	Epesi::process($_POST['url'],isset($_POST['history'])?$_POST['history']:false);
	Epesi::text(Epesi::get_content(), 'main_content');
	Epesi::text(Epesi::get_debug(),'debug');
	Epesi::send_output();
}
$content = ob_get_contents();
ob_end_clean();

require_once('libs/minify/HTTP/Encoder.php');
$he = new HTTP_Encoder(array('content' => $content));
if (MINIFY_ENCODE)
	$he->encode();
$he->sendAll();
?>
