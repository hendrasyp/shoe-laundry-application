<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
	<meta http-equiv="Pragma" content="no-cache"/>
	<meta http-equiv="Expires" content="0"/>

	<title><?= (isset($page_title)) ? $page_title." | " : "Dashboard | ";?><?=$config_company_name;?></title>
	<link rel="shortcut icon" href="<?= _load("img/mini-logo.png"); ?>">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->load->view('shared/fragments/css_bundle'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed text-sm accent-warning">
<div class="wrapper">
	<input type="hidden" name="txtCounterID" id="txtCounterID" value="<?=$users->counterid;?>">
	<input type="hidden" name="txtUserID" id="txtUserID" value="<?=$users->id;?>">

	<?php $this->load->view('shared/fragments/nav_bar', array('page_title' => $page_title)); ?>
	<?php $this->load->view('shared/fragments/main_sidebar', array('mainmenu' => $menus)); ?>

	<div class="content-wrapper">

		<!-- Main content -->
		<section class="content" style="padding-top: 14px;">
			<div class="container-fluid" id="floki_container">
