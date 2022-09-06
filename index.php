<?php
 session_start();
/**
 * route function
 * The match expression used for method and included files based on that method 
 */

// include router object file
require_once "router.php";

route('/', function () {	
	match (strtoupper($_SERVER['REQUEST_METHOD'])) {
		'GET' => include 'welcome.php',
		default => include './api/404.php'
	};	
});

route('/api/users', function () {
	match (strtoupper($_SERVER['REQUEST_METHOD'])) {
		'GET' => include './api/read_all.php',
		default => include './api/404.php'
	};		
});

route('/api/user', function () {
	match (strtoupper($_SERVER['REQUEST_METHOD'])) {
		'GET' => include './api/read_single.php',
		'POST' => include './api/create.php',
		'PUT' => include './api/update.php',		
		default => include '404.php'
	};
});

route('/api/user/code', function () {
	match (strtoupper($_SERVER['REQUEST_METHOD'])) {
		'GET' => include './api/get_code.php',
		default => include '404.php'
	};
});

route('/api/user/login', function () {
	match (strtoupper($_SERVER['REQUEST_METHOD'])) {
		'POST' => include './api/login.php',
		default => include '404.php'
	};
});

route('/api/user/logout', function () {
	match (strtoupper($_SERVER['REQUEST_METHOD'])) {
		'POST' => include './api/logout.php',
		default => include '404.php'
	};
});


route('/api/user/admin', function () {
	match (strtoupper($_SERVER['REQUEST_METHOD'])) {
		'POST' => include './api/create_admin.php',
		'PUT' => include './api/update_admin.php',
		'DELETE' => include './api/delete_admin.php',
		default => include '404.php'
	};
});


/** 
 * @param $req_uri - check the environment and replace folder name if is on local
*/
$req_uri = str_replace(basename(dirname(__FILE__)), '', $_SERVER['REQUEST_URI']);
dispatch($req_uri);
?>