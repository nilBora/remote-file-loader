<?php

define('ROOT_DIR', dirname(__FILE__).'/');
define('COMMON_DIR', ROOT_DIR.'Common/');
define('BUNDLE_DIR', COMMON_DIR.'bundle/');

require_once "config.php";

require_once COMMON_DIR.'Object.php';
require_once COMMON_DIR.'Core.php';

require_once BUNDLE_DIR.'User/UserObject.php';
require_once BUNDLE_DIR.'User/User.php';

require_once BUNDLE_DIR.'Downloads/DownloadsObject.php';
require_once BUNDLE_DIR.'Downloads/Downloads.php';

require_once BUNDLE_DIR.'ServerSocket/ServerSocket.php';

$db = new PDO(
    $GLOBALS['db'],
    $GLOBALS['user'],
    $GLOBALS['password']
);

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$res = $db->query('SET NAMES utf8');

$core = new Core();
$core->db = Object::factory($db);
