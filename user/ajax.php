<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

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
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}

if($action == "save_booking"){
	$save = $crud->save_booking();
	if($save)
		echo $save;
}
if($action == "delete_book"){
	$save = $crud->delete_book();
	if($save)
		echo $save;
}

if($action == "save_register"){
	$save = $crud->save_register();
	if($save)
		echo $save;
}
if($action == "delete_register"){
	$save = $crud->delete_register();
	if($save)
		echo $save;
}

if($action == "update_order"){
	$save = $crud->update_order();
	if($save)
		echo $save;
}
if($action == "delete_order"){
	$save = $crud->delete_order();
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
if($action == "get_venue_report"){
	$get = $crud->get_venue_report();
	if($get)
		echo $get;
}
if($action == "save_art_fs"){
	$save = $crud->save_art_fs();
	if($save)
		echo $save;
}
if($action == "delete_art_fs"){
	$save = $crud->delete_art_fs();
	if($save)
		echo $save;
}