<?php
/**
 * @author Paul Bukowski <pbukowski@telaxus.com>
 * @copyright Copyright &copy; 2006, Telaxus LLC
 * @license MIT
 * @version 1.0
 * @package epesi-base
 */

use Symfony\Component\HttpFoundation\Response;

include('vendor/autoload.php');
$response = new Response();

$response->mustRevalidate();
$response->setExpires(new DateTime());
$response->headers->set('Content-type', 'text/javascript');

if(!isset($_POST['url']) || !isset($_SERVER['HTTP_X_CLIENT_ID'])) {
	$response->sendContent('alert(\'Invalid request\');');
	$response->send();
	die();
}


define('JS_OUTPUT',1);
define('EPESI_PROCESS',1);
require_once('include.php');

if (epesi_requires_update()) {
	$response->setContent('window.location="index.php";');
	$response->send();
	die();
}

if(!isset($_SESSION['num_of_clients'])) {
	Epesi::alert('Session expired, restarting Epesi');
	Epesi::redirect();
	define('SESSION_EXPIRED',1);
	//session_commit();
	//DBSession::destroy(session_id());
} elseif((!isset($_POST['history']) || !is_numeric($_POST['history']) || $_POST['history']>0) && !isset($_SESSION['client']['__history_id__'])) {
	Epesi::alert('Too many Epesi tabs open - session expired, restarting Epesi');
	Epesi::redirect();
	define('SESSION_EXPIRED',1);
	//session_commit();
	DBSession::destroy_client(session_id(),CID);
} else {
	Epesi::process($_POST['url'],isset($_POST['history'])?$_POST['history']:false);
}

$twig = ModuleManager::get_container()['twig'];

/** @var Twig_Environment $twig */
$content = $twig->render('process.js.twig', array(
	'load_css' => Epesi::get_csses(),
	'load_js' => Epesi::get_jses(),
	'content' => Epesi::get_content(),
	'debug' => Epesi::get_debug(),
	'eval_js' => Epesi::get_eval_jses(),
));

$response->setContent($content);
$response->send();