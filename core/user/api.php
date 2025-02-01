<?php
ob_start();
$action = $_GET['action'];
include 'actions.php';
$crud = new Actions();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'register'){
	$register = $crud->register();
	if($register)
		echo $register;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}

if($action == "save_booking"){
	$save = $crud->save_booking();
	if($save)
		echo $save;
}

if($action == "save_register"){
	$save = $crud->save_register();
	if($save)
		echo $save;
}

if($action == "save_event"){
	$save = $crud->save_event();
	if($save)
		echo $save;
}
if($action == "delete_event"){
	$save = $crud->delete_event();
	if($save)
		echo $save;
}
if($action == "get_audience_report"){
	$get = $crud->get_audience_report();
	if($get)
		echo $get;
}
if($action == "download_audience_report"){
	$get = $crud->download_audience_report();
	if($get)
		echo $get;
}
