<?php
header('Content-Type: text/html; charset=utf-8');
	require_once ('employer.php');
	$emp=new employer;
	$emp->username='Иванов';
	$emp->name='Иван';
	$emp->patronymic='Иванович';
	$emp->set_age(55);
	echo $emp->get_full_info();
?>